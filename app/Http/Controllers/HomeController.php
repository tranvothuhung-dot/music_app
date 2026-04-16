<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    public function index()
    {
        $hasArtistStatus = Schema::hasColumn('artists', 'status');

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
            ->when($hasArtistStatus, function ($query) {
                $query->where('status', 1);
            })
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

        return view('music.songs', [
            'songs' => $songs,
        ]);
    }

    public function albums()
    {
        $albums = DB::table('albums as al')
            ->join('artists as a', 'al.artist_id', '=', 'a.artist_id')
            ->select('al.*', 'a.artist_name')
            ->paginate(20);

        return view('music.albums', [
            'albums' => $albums,
        ]);
    }

    public function artists()
    {
        $artists = DB::table('artists')
            ->when(Schema::hasColumn('artists', 'status'), function ($query) {
                $query->where('status', 1);
            })
            ->paginate(20);

        return view('music.artists', [
            'artists' => $artists,
        ]);
    }


    public function news()
    {
        $news = [];

        if (Schema::hasTable('news')) {
            $news = DB::table('news')
                ->orderByDesc('created_at')
                ->get();
        }

        return view('music.news', [
            'news' => $news,
        ]);
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
                ->when(Schema::hasColumn('artists', 'status'), function ($query) {
                    $query->where('status', 1);
                })
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
