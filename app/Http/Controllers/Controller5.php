<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Controller5 extends Controller
{
    private function formatViewCount($views) {
        if ($views >= 1000000) return round($views / 1000000, 1) . 'M';
        if ($views >= 1000) return round($views / 1000, 1) . 'K';
        return $views;
    }

    private function formatDuration($seconds) {
        return sprintf("%02d:%02d", floor($seconds / 60), $seconds % 60);
    }

    // Xử lý Gợi ý AJAX & Trending
    public function ajaxSearch(Request $request)
    {
        $q = $request->query('q', '');
        
        if (empty($q)) {
            $trendingSongs = DB::table('songs')
                ->join('artists', 'songs.artist_id', '=', 'artists.artist_id')
                ->orderBy('view_count', 'desc')
                ->limit(5)
                ->get(['song_id', 'song_name', 'song_image', 'artist_name', 'view_count', 'song_url']);
            
            return response()->json([
                'type' => 'trending',
                'data' => $trendingSongs
            ]);
        }

        // Chuyển từ khóa sang chữ thường để so sánh Binary (Giải quyết lỗi Sơn = Sóng)
        $kw = mb_strtolower($q, 'UTF-8');

        $songs = DB::table('songs')
            ->join('artists', 'songs.artist_id', '=', 'artists.artist_id')
            ->whereRaw('LOWER(songs.song_name) COLLATE utf8mb4_bin LIKE ?', ["%{$kw}%"])
            ->orWhereRaw('LOWER(artists.artist_name) COLLATE utf8mb4_bin LIKE ?', ["%{$kw}%"])
            ->limit(5)
            ->get(['song_id', 'song_name', 'song_image', 'artist_name', 'song_url', 'view_count']);
            
        $artists = DB::table('artists')
            ->whereRaw('LOWER(artist_name) COLLATE utf8mb4_bin LIKE ?', ["%{$kw}%"])
            ->limit(3)
            ->get(['artist_id', 'artist_name', 'avatar_image']);

        $albums = DB::table('albums')
            ->join('artists', 'albums.artist_id', '=', 'artists.artist_id')
            ->whereRaw('LOWER(albums.album_name) COLLATE utf8mb4_bin LIKE ?', ["%{$kw}%"])
            ->orWhereRaw('LOWER(artists.artist_name) COLLATE utf8mb4_bin LIKE ?', ["%{$kw}%"])
            ->limit(2)
            ->get(['album_id', 'album_name', 'cover_image']);

        return response()->json([
            'type' => 'search',
            'songs' => $songs,
            'artists' => $artists,
            'albums' => $albums
        ]);
    }

    // Xử lý Trang kết quả tìm kiếm chi tiết
    public function search(Request $request)
    {
        $keyword = $request->query('q', '');

        if (empty($keyword)) {
            return view('music.search', ['keyword' => $keyword, 'songs' => collect(), 'artists' => collect(), 'albums' => collect(), 'priority' => 'none']);
        }

        $kw = mb_strtolower($keyword, 'UTF-8');

        $songs = DB::table('songs')
            ->join('artists', 'songs.artist_id', '=', 'artists.artist_id')
            ->whereRaw('LOWER(songs.song_name) COLLATE utf8mb4_bin LIKE ?', ["%{$kw}%"])
            ->orWhereRaw('LOWER(artists.artist_name) COLLATE utf8mb4_bin LIKE ?', ["%{$kw}%"])
            ->select('songs.*', 'artists.artist_name')
            ->get()
            ->map(function($song) {
                $song->formatted_views = $this->formatViewCount($song->view_count);
                $song->formatted_duration = $this->formatDuration($song->duration);
                return $song;
            });

        $artists = DB::table('artists')
            ->whereRaw('LOWER(artist_name) COLLATE utf8mb4_bin LIKE ?', ["%{$kw}%"])
            ->get();

        $albums = DB::table('albums')
            ->join('artists', 'albums.artist_id', '=', 'artists.artist_id')
            ->whereRaw('LOWER(albums.album_name) COLLATE utf8mb4_bin LIKE ?', ["%{$kw}%"])
            ->orWhereRaw('LOWER(artists.artist_name) COLLATE utf8mb4_bin LIKE ?', ["%{$kw}%"])
            ->select('albums.*', 'artists.artist_name')
            ->get();

        $priority = 'song'; 
        if ($artists->contains(function ($val) use ($kw) { return mb_stripos($val->artist_name, $kw, 0, 'UTF-8') !== false; })) {
            $priority = 'artist';
        } elseif ($albums->contains(function ($val) use ($kw) { return mb_stripos($val->album_name, $kw, 0, 'UTF-8') !== false; })) {
            $priority = 'album';
        }

        return view('music.search', compact('keyword', 'songs', 'artists', 'albums', 'priority'));
    }
}