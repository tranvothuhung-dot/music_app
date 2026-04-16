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
                'playlist_songs_map' => collect(),
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

        $playlist_songs_map = DB::table('playlist_songs as ps')
            ->join('playlists as p', 'ps.playlist_id', '=', 'p.playlist_id')
            ->join('songs as s', 'ps.song_id', '=', 's.song_id')
            ->join('artists as a', 's.artist_id', '=', 'a.artist_id')
            ->where('p.user_id', $userId)
            ->select('ps.playlist_id', 's.song_id', 's.song_name', 'a.artist_name', 'ps.added_at')
            ->orderByDesc('ps.added_at')
            ->get()
            ->groupBy('playlist_id');

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
            'playlist_songs_map' => $playlist_songs_map,
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

    public function newReleases()
    {
        $newestSongs = DB::table('songs as s')
            ->join('artists as a', 's.artist_id', '=', 'a.artist_id')
            ->leftJoin('genres as g', 's.genre_id', '=', 'g.genre_id')
            ->select('s.*', 'a.artist_name', 'g.genre_name')
            ->orderByRaw("COALESCE(g.genre_name, 'Khac') ASC")
            ->orderByDesc('s.created_at')
            ->paginate(20);

        $newestSongsByGenre = $newestSongs->getCollection()->groupBy(function ($song) {
            return $song->genre_name ?: 'Khac';
        });

        return view('music.new-releases', array_merge([
            'newest_songs' => $newestSongs,
            'newest_songs_by_genre' => $newestSongsByGenre,
        ], $this->dashboardSharedData()));
    }

    public function leaderboard()
    {
        $leaderboardSongs = DB::table('songs as s')
            ->join('artists as a', 's.artist_id', '=', 'a.artist_id')
            ->select('s.*', 'a.artist_name')
            ->orderByDesc('s.view_count')
            ->limit(100)
            ->get();

        return view('music.leaderboard', array_merge([
            'leaderboard_songs' => $leaderboardSongs,
        ], $this->dashboardSharedData()));
    }

    public function albums(Request $request)
    {
        $albumId = (int) $request->query('album_id', 0);
        $artistId = (int) $request->query('artist_id', 0);

        $selectedAlbum = null;
        $artistSongs = collect();

        if ($albumId > 0) {
            $selectedAlbum = DB::table('albums as al')
                ->join('artists as a', 'al.artist_id', '=', 'a.artist_id')
                ->select('al.*', 'a.artist_name')
                ->where('al.album_id', $albumId)
                ->first();

            if ($selectedAlbum) {
                $artistId = (int) $selectedAlbum->artist_id;

                $artistSongs = DB::table('songs as s')
                    ->join('artists as a', 's.artist_id', '=', 'a.artist_id')
                    ->select('s.*', 'a.artist_name')
                    ->where('s.artist_id', $artistId)
                    ->orderByDesc('s.view_count')
                    ->orderBy('s.song_name')
                    ->get();
            }
        }

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
            'selected_album' => $selectedAlbum,
            'artist_songs' => $artistSongs,
        ], $this->dashboardSharedData()));
    }

    public function artists(Request $request)
    {
        $artistId = (int) $request->query('artist_id', 0);

        $selectedArtist = null;
        $artistSongs = collect();

        if ($artistId > 0) {
            $selectedArtist = DB::table('artists')
                ->where('artist_id', $artistId)
                ->first();

            if ($selectedArtist) {
                $artistSongs = DB::table('songs as s')
                    ->join('artists as a', 's.artist_id', '=', 'a.artist_id')
                    ->select('s.*', 'a.artist_name')
                    ->where('s.artist_id', $artistId)
                    ->orderByDesc('s.view_count')
                    ->orderBy('s.song_name')
                    ->get();
            }
        }

        $artistsQuery = DB::table('artists');

        if ($artistId > 0) {
            $artistsQuery->where('artist_id', $artistId);
        }

        $artists = $artistsQuery->paginate(20)->withQueryString();

        return view('music.artists', array_merge([
            'artists' => $artists,
            'selected_artist_id' => $artistId,
            'selected_artist' => $selectedArtist,
            'artist_songs' => $artistSongs,
        ], $this->dashboardSharedData()));
    }

    public function genres(Request $request)
    {
        $genreId = (int) $request->query('genre_id', 0);

        $genres = DB::table('genres')
            ->orderBy('genre_name')
            ->get();

        $selectedGenre = null;
        $genreSongs = collect();

        if ($genreId > 0) {
            $selectedGenre = DB::table('genres')
                ->where('genre_id', $genreId)
                ->first();

            if ($selectedGenre) {
                $genreSongs = DB::table('songs as s')
                    ->join('artists as a', 's.artist_id', '=', 'a.artist_id')
                    ->select('s.*', 'a.artist_name')
                    ->where('s.genre_id', $genreId)
                    ->orderByDesc('s.view_count')
                    ->orderBy('s.song_name')
                    ->get();
            }
        }

        return view('music.genres', array_merge([
            'genres' => $genres,
            'selected_genre_id' => $genreId,
            'selected_genre' => $selectedGenre,
            'genre_songs' => $genreSongs,
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
            'selected_news' => null,
        ], $this->dashboardSharedData()));
    }

    public function newsDetail(int $newsId)
    {
        if (!Schema::hasTable('news')) {
            abort(404);
        }

        $news = DB::table('news')
            ->orderByDesc('created_at')
            ->get();

        $selectedNews = DB::table('news')
            ->where('news_id', $newsId)
            ->first();

        if (!$selectedNews) {
            abort(404);
        }

        return view('music.news', array_merge([
            'news' => $news,
            'selected_news' => $selectedNews,
        ], $this->dashboardSharedData()));
    }

    public function favorites()
    {
        $userId = Auth::id();

        if (!$userId) {
            return redirect()->route('dashboard');
        }

        $favoriteSongs = DB::table('favorites as f')
            ->join('songs as s', 'f.song_id', '=', 's.song_id')
            ->join('artists as a', 's.artist_id', '=', 'a.artist_id')
            ->select('s.*', 'a.artist_name', 'f.added_at')
            ->where('f.user_id', $userId)
            ->orderByDesc('f.added_at')
            ->get();

        return view('music.favorites', array_merge([
            'favorite_songs' => $favoriteSongs,
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
