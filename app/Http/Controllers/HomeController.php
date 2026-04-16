<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    private function dashboardSharedData(): array
    {
        $userId = Auth::id();

        if (! $userId) {
            return [
                'count_liked' => 0,
                'my_playlists' => collect(),
                'history_list' => collect(),
                'liked_songs' => collect(),
                'queue_songs' => collect(),
                'js_data' => [
                    'queue' => collect(),
                ],
            ];
        }

        $count_liked = DB::table('favorites')
            ->where('user_id', $userId)
            ->count();

        $my_playlists = DB::table('playlists')
            ->where('user_id', $userId)
            ->orderByDesc('created_at')
            ->get();

        $history_list = DB::table('listening_history')
            ->join('songs', 'listening_history.song_id', '=', 'songs.song_id')
            ->join('artists', 'songs.artist_id', '=', 'artists.artist_id')
            ->where('listening_history.user_id', $userId)
            ->select('songs.*', 'artists.artist_name', 'listening_history.listened_at')
            ->orderByDesc('listening_history.listened_at')
            ->limit(10)
            ->get();

        $liked_songs = DB::table('favorites')
            ->join('songs', 'favorites.song_id', '=', 'songs.song_id')
            ->join('artists', 'songs.artist_id', '=', 'artists.artist_id')
            ->where('favorites.user_id', $userId)
            ->select('songs.*', 'artists.artist_name', 'favorites.added_at')
            ->orderByDesc('favorites.added_at')
            ->limit(10)
            ->get();

        $popular_songs = DB::table('songs')
            ->join('artists', 'songs.artist_id', '=', 'artists.artist_id')
            ->select('songs.*', 'artists.artist_name')
            ->orderByDesc('songs.view_count')
            ->limit(20)
            ->get();

        $queue_songs = $popular_songs
            ->concat($liked_songs)
            ->concat($history_list)
            ->unique('song_id')
            ->values();

        return [
            'count_liked' => $count_liked,
            'my_playlists' => $my_playlists,
            'history_list' => $history_list,
            'liked_songs' => $liked_songs,
            'queue_songs' => $queue_songs,
            'js_data' => [
                'queue' => $queue_songs,
            ],
        ];
    }

    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        $trending = DB::table('songs as s')
            ->join('artists as a', 's.artist_id', '=', 'a.artist_id')
            ->select('s.*', 'a.artist_name')
            ->orderByDesc('s.view_count')
            ->limit(8)
            ->get();

        $newReleases = DB::table('songs as s')
            ->join('artists as a', 's.artist_id', '=', 'a.artist_id')
            ->select('s.*', 'a.artist_name')
            ->orderByDesc('s.created_at')
            ->limit(8)
            ->get();

        $featuredAlbums = DB::table('albums as al')
            ->join('artists as a', 'al.artist_id', '=', 'a.artist_id')
            ->select('al.*', 'a.artist_name')
            ->orderByDesc('al.created_at')
            ->limit(6)
            ->get();

        $featuredArtists = DB::table('artists')
            ->orderByDesc('created_at')
            ->limit(8)
            ->get();

        $news = [];
        if (Schema::hasTable('news')) {
            $news = DB::table('news')
                ->orderByDesc('created_at')
                ->limit(4)
                ->get();
        }

        return view('music.index', [
            'trending' => $trending,
            'newReleases' => $newReleases,
            'featuredAlbums' => $featuredAlbums,
            'featuredArtists' => $featuredArtists,
            'news' => $news,
        ]);
    }

    public function category($id)
    {
        $category = DB::table('danh_muc_am_nhac')->find($id);

        if (! $category) {
            abort(404);
        }

        $songs = DB::table('songs as s')
            ->join('artists as a', 's.artist_id', '=', 'a.artist_id')
            ->select('s.*', 'a.artist_name')
            ->where('s.genre_id', $id)
            ->get();

        return view('music.category', [
            'category' => $category,
            'songs' => $songs,
        ]);
    }

    public function songs()
    {
        $songs = DB::table('songs as s')
            ->join('artists as a', 's.artist_id', '=', 'a.artist_id')
            ->select('s.*', 'a.artist_name')
            ->paginate(20);

        return view('music.songs', array_merge([
            'songs' => $songs,
        ], $this->dashboardSharedData()));
    }

    public function albums(Request $request)
    {
        $albumId = (int) $request->query('album_id', 0);
        $artistId = (int) $request->query('artist_id', 0);

        $albumsQuery = DB::table('albums as al')
            ->join('artists as a', 'al.artist_id', '=', 'a.artist_id')
            ->select('al.*', 'a.artist_name');

        if ($albumId > 0) {
            $albumsQuery->where('al.album_id', $albumId);
        }

        if ($artistId > 0) {
            $albumsQuery->where('al.artist_id', $artistId);
        }

        $albums = $albumsQuery->paginate(20)->withQueryString();

        return view('music.albums', array_merge([
            'albums' => $albums,
            'selected_album_id' => $albumId,
            'selected_artist_id' => $artistId,
        ], $this->dashboardSharedData()));
    }

    public function artists(Request $request)
    {
        $artistId = (int) $request->query('artist_id', 0);

        $artistsQuery = DB::table('artists');

        if ($artistId > 0) {
            $artistsQuery->where('artist_id', $artistId);
        }

        $artists = $artistsQuery->paginate(20)->withQueryString();

        return view('music.artists', array_merge([
            'artists' => $artists,
            'selected_artist_id' => $artistId,
        ], $this->dashboardSharedData()));
    }


    public function news()
    {
        $news = [];

        if (Schema::hasTable('news')) {
            $news = DB::table('news')
                ->orderByDesc('created_at')
                ->get();
        }

        return view('music.news', array_merge([
            'news' => $news,
        ], $this->dashboardSharedData()));
    }

    public function search(Request $request)
    {
        $keyword = trim($request->input('keyword', ''));

        $songs = collect();
        $artists = collect();
        $albums = collect();

        if ($keyword !== '') {
            $searchTerm = "%{$keyword}%";

            $songs = DB::table('songs as s')
                ->join('artists as a', 's.artist_id', '=', 'a.artist_id')
                ->select('s.*', 'a.artist_name')
                ->where('s.song_name', 'like', $searchTerm)
                ->limit(10)
                ->get();

            $artists = DB::table('artists')
                ->where('artist_name', 'like', $searchTerm)
                ->limit(10)
                ->get();

            $albums = DB::table('albums')
                ->where('album_name', 'like', $searchTerm)
                ->limit(10)
                ->get();
        }

        return view('music.search', [
            'keyword' => $keyword,
            'songs' => $songs,
            'artists' => $artists,
            'albums' => $albums,
        ]);
    }
}
