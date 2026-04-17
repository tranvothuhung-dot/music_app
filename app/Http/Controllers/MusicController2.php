<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MusicController2 extends Controller
{
    public function index()
    {
        $trending = DB::table('songs as s')
            ->join('artists as a', 's.artist_id', '=', 'a.artist_id')
            ->select('s.*', 'a.artist_name')
            ->orderByDesc('s.view_count')
            ->limit(8)
            ->get();

        $newReleases = DB::table('songs as s')
            ->join('artists as a', 's.artist_id', '=', 'a.artist_id')
            ->leftJoin('genres as g', 's.genre_id', '=', 'g.genre_id')
            ->select('s.*', 'a.artist_name', 'g.genre_name')
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

        $genres = collect();
        if (Schema::hasTable('genres')) {
            $genres = DB::table('genres')->limit(4)->get();
        }

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
            'genres' => $genres,
            'news' => $news,
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

    public function songDetail($id)
    {
        $song = null;

        try {
            $song = DB::table('songs as s')
                ->join('artists as a', 's.artist_id', '=', 'a.artist_id')
                ->select('s.*', 'a.artist_name')
                ->where('s.song_id', $id)
                ->first();
        } catch (\Throwable $e) {
            // fallback when schema uses id instead of song_id
        }

        if (! $song) {
            try {
                $song = DB::table('songs as s')
                    ->join('artists as a', 's.artist_id', '=', 'a.artist_id')
                    ->select('s.*', 'a.artist_name')
                    ->where('s.id', $id)
                    ->first();
            } catch (\Throwable $e) {
                // ignore schema mismatch
            }
        }

        if (! $song) {
            abort(404);
        }

        return view('music.song-detail', [
            'song' => $song,
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
        $artists = DB::table('artists')->paginate(20);

        return view('music.artists', [
            'artists' => $artists,
        ]);
    }

    public function genres()
    {
        $genres = collect();

        if (Schema::hasTable('genres')) {
            $genres = DB::table('genres')->get();
        }

        return view('music.genres', [
            'genres' => $genres,
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

    public function albumDetail($id)
    {
        $album = DB::table('albums as al')
            ->join('artists as a', 'al.artist_id', '=', 'a.artist_id')
            ->select('al.*', 'a.artist_name')
            ->where('al.album_id', $id)
            ->first();

        if (!$album) {
            abort(404);
        }

        $songs = DB::table('songs as s')
            ->join('artists as a', 's.artist_id', '=', 'a.artist_id')
            ->select('s.*', 'a.artist_name')
            ->where('s.album_id', $album->album_id)
            ->get();

        return view('music.album-detail', [
            'album' => $album,
            'songs' => $songs,
        ]);
    }

    public function artistDetail($id)
    {
        $artist = DB::table('artists')
            ->where('artist_id', $id)
            ->first();

        if (!$artist) {
            abort(404);
        }

        $songs = DB::table('songs as s')
            ->join('artists as a', 's.artist_id', '=', 'a.artist_id')
            ->select('s.*', 'a.artist_name')
            ->where('s.artist_id', $artist->artist_id)
            ->get();

        return view('music.artist-detail', [
            'artist' => $artist,
            'songs' => $songs,
        ]);
    }

    public function genreDetail($id)
    {
        $genre = DB::table('genres')
            ->where('genre_id', $id)
            ->first();

        if (!$genre) {
            abort(404);
        }

        $songs = DB::table('songs as s')
            ->join('artists as a', 's.artist_id', '=', 'a.artist_id')
            ->select('s.*', 'a.artist_name')
            ->where('s.genre_id', $genre->genre_id)
            ->get();

        return view('music.genre-detail', [
            'genre' => $genre,
            'songs' => $songs,
        ]);
    }
}
