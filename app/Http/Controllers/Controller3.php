<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;

class Controller3 extends Controller
{
    private function trackSiteVisit(): void
    {
        if (! Schema::hasTable('site_visits')) {
            return;
        }

        $today = Carbon::today()->toDateString();
        $exists = DB::table('site_visits')->where('visit_date', $today)->exists();

        if ($exists) {
            $updateData = [
                'visit_count' => DB::raw('visit_count + 1'),
            ];

            if (Schema::hasColumn('site_visits', 'updated_at')) {
                $updateData['updated_at'] = now();
            }

            DB::table('site_visits')
                ->where('visit_date', $today)
                ->update($updateData);

            return;
        }

        $insertData = [
            'visit_date' => $today,
            'visit_count' => 1,
        ];

        if (Schema::hasColumn('site_visits', 'created_at')) {
            $insertData['created_at'] = now();
        }
        if (Schema::hasColumn('site_visits', 'updated_at')) {
            $insertData['updated_at'] = now();
        }

        DB::table('site_visits')->insert($insertData);
    }

    public function removeSongFromPlaylist(Request $request)
    {
        $userId = Auth::id();
        $playlistId = (int) $request->input('playlist_id');
        $songId = (int) $request->input('song_id');

        if (! $playlistId || ! $songId) {
            return response()->json([
                'message' => 'Dữ liệu không hợp lệ.',
            ], 422);
        }

        $playlistExists = DB::table('playlists')
            ->where('playlist_id', $playlistId)
            ->where('user_id', $userId)
            ->exists();

        if (! $playlistExists) {
            return response()->json([
                'message' => 'Không tìm thấy playlist.',
            ], 404);
        }

        $deleted = DB::table('playlist_songs')
            ->where('playlist_id', $playlistId)
            ->where('song_id', $songId)
            ->delete();

        return response()->json([
            'deleted' => $deleted > 0,
        ]);
    }

    public function addSongToPlaylist(Request $request)
    {
        $userId = Auth::id();
        $songId = (int) $request->input('song_id');
        $playlistId = (int) $request->input('playlist_id', 0);
        $playlistName = trim((string) $request->input('playlist_name', ''));

        if (! $songId || ! DB::table('songs')->where('song_id', $songId)->exists()) {
            return response()->json([
                'message' => 'Bài hát không tồn tại.',
            ], 422);
        }

        $playlist = null;
        $createdPlaylist = false;

        if ($playlistId > 0) {
            $playlist = DB::table('playlists')
                ->where('playlist_id', $playlistId)
                ->where('user_id', $userId)
                ->first();
        }

        if (! $playlist && $playlistName !== '') {
            $playlist = DB::table('playlists')
                ->where('user_id', $userId)
                ->whereRaw('LOWER(playlist_name) = ?', [mb_strtolower($playlistName)])
                ->first();

            if (! $playlist) {
                $newPlaylistId = DB::table('playlists')->insertGetId([
                    'user_id' => $userId,
                    'playlist_name' => $playlistName,
                    'created_at' => now(),
                ], 'playlist_id');

                $playlist = (object) [
                    'playlist_id' => $newPlaylistId,
                    'playlist_name' => $playlistName,
                ];
                $createdPlaylist = true;
            }
        }

        if (! $playlist) {
            return response()->json([
                'message' => 'Playlist không hợp lệ.',
            ], 422);
        }

        $exists = DB::table('playlist_songs')
            ->where('playlist_id', $playlist->playlist_id)
            ->where('song_id', $songId)
            ->exists();

        if (! $exists) {
            DB::table('playlist_songs')->insert([
                'playlist_id' => $playlist->playlist_id,
                'song_id' => $songId,
                'added_at' => now(),
            ]);
        }

        return response()->json([
            'added' => ! $exists,
            'created_playlist' => $createdPlaylist,
            'playlist' => [
                'playlist_id' => (int) $playlist->playlist_id,
                'playlist_name' => (string) $playlist->playlist_name,
            ],
        ]);
    }

    public function createPlaylist(Request $request)
    {
        $userId = Auth::id();
        $playlistName = trim((string) $request->input('playlist_name', ''));

        if ($playlistName === '') {
            return response()->json([
                'message' => 'Tên playlist không được để trống.',
            ], 422);
        }

        if (mb_strlen($playlistName) > 120) {
            return response()->json([
                'message' => 'Tên playlist quá dài.',
            ], 422);
        }

        $playlistId = DB::table('playlists')->insertGetId([
            'user_id' => $userId,
            'playlist_name' => $playlistName,
            'created_at' => now(),
        ], 'playlist_id');

        return response()->json([
            'created' => true,
            'playlist' => [
                'playlist_id' => $playlistId,
                'playlist_name' => $playlistName,
            ],
        ]);
    }

    public function deletePlaylist(Request $request)
    {
        $userId = Auth::id();
        $playlistId = (int) $request->input('playlist_id');

        if (! $playlistId) {
            return response()->json([
                'message' => 'Playlist không hợp lệ.',
            ], 422);
        }

        $deleted = DB::table('playlists')
            ->where('playlist_id', $playlistId)
            ->where('user_id', $userId)
            ->delete();

        if (! $deleted) {
            return response()->json([
                'message' => 'Không tìm thấy playlist.',
            ], 404);
        }

        return response()->json([
            'deleted' => true,
        ]);
    }

    public function addToHistory(Request $request)
    {
        $userId = Auth::id();
        $songId = (int) $request->input('song_id');

        if (! $songId || ! DB::table('songs')->where('song_id', $songId)->exists()) {
            return response()->json([
                'message' => 'Bài hát không tồn tại.',
            ], 422);
        }

        $historyQuery = DB::table('listening_history')
            ->where('user_id', $userId)
            ->where('song_id', $songId);

        if ($historyQuery->exists()) {
            $historyQuery->update([
                'listened_at' => now(),
            ]);
        } else {
            DB::table('listening_history')->insert([
                'user_id' => $userId,
                'song_id' => $songId,
                'listened_at' => now(),
            ]);
        }

        DB::table('songs')
            ->where('song_id', $songId)
            ->increment('view_count');

        return response()->json([
            'saved' => true,
        ]);
    }

    public function toggleFavorite(Request $request)
    {
        $userId = Auth::id();
        $songId = (int) $request->input('song_id');

        if (! $songId || ! DB::table('songs')->where('song_id', $songId)->exists()) {
            return response()->json([
                'message' => 'Bài hát không tồn tại.',
            ], 422);
        }

        $favoriteQuery = DB::table('favorites')
            ->where('user_id', $userId)
            ->where('song_id', $songId);

        $isLiked = ! $favoriteQuery->exists();

        if ($isLiked) {
            DB::table('favorites')->insert([
                'user_id' => $userId,
                'song_id' => $songId,
                'added_at' => now(),
            ]);
        } else {
            $favoriteQuery->delete();
        }

        return response()->json([
            'liked' => $isLiked,
            'liked_count' => DB::table('favorites')->where('user_id', $userId)->count(),
        ]);
    }

    public function index()
    {
        $this->trackSiteVisit();

        // Lấy ID người dùng hiện tại
        $user_id = Auth::id();

        // 1. Thịnh Hành (Sắp xếp theo view_count)
        $trending = DB::table('songs')
            ->join('artists', 'songs.artist_id', '=', 'artists.artist_id')
            ->select('songs.*', 'artists.artist_name')
            ->orderByDesc('songs.view_count')
            ->limit(8)
            ->get();

        // 2. Mới Phát Hành (Sắp xếp theo ngày tạo, kèm thể loại)
        $newest_songs = DB::table('songs')
            ->join('artists', 'songs.artist_id', '=', 'artists.artist_id')
            ->leftJoin('genres', 'songs.genre_id', '=', 'genres.genre_id')
            ->select('songs.*', 'artists.artist_name', 'genres.genre_name')
            ->orderByDesc('songs.created_at')
            ->limit(8)
            ->get();

        // 3. Album Nổi Bật
        $albums = DB::table('albums')
            ->join('artists', 'albums.artist_id', '=', 'artists.artist_id')
            ->select('albums.*', 'artists.artist_name')
            ->orderByDesc('albums.release_date')
            ->limit(4)
            ->get();

        // 4. Nghệ Sĩ Nổi Bật
        $artists_list = DB::table('artists')->limit(10)->get();

        // 5. Tin Tức
        $news_list = DB::table('news')->orderByDesc('created_at')->limit(2)->get();

        // 6. Dữ liệu cho Sidebar
        $count_liked = DB::table('favorites')->where('user_id', $user_id)->count();
        
        $my_playlists = DB::table('playlists')
            ->where('user_id', $user_id)
            ->orderByDesc('created_at')
            ->get();

        $playlist_songs_map = DB::table('playlist_songs as ps')
            ->join('playlists as p', 'ps.playlist_id', '=', 'p.playlist_id')
            ->join('songs as s', 'ps.song_id', '=', 's.song_id')
            ->join('artists as a', 's.artist_id', '=', 'a.artist_id')
            ->where('p.user_id', $user_id)
            ->select('ps.playlist_id', 's.song_id', 's.song_name', 'a.artist_name', 'ps.added_at')
            ->orderByDesc('ps.added_at')
            ->get()
            ->groupBy('playlist_id');
            
        $history_list = DB::table('listening_history')
            ->join('songs', 'listening_history.song_id', '=', 'songs.song_id')
            ->join('artists', 'songs.artist_id', '=', 'artists.artist_id')
            ->where('listening_history.user_id', $user_id)
            ->select('songs.*', 'artists.artist_name', 'listening_history.listened_at')
            ->orderByDesc('listening_history.listened_at')
            ->limit(10)
            ->get();

        $liked_songs = DB::table('favorites')
            ->join('songs', 'favorites.song_id', '=', 'songs.song_id')
            ->join('artists', 'songs.artist_id', '=', 'artists.artist_id')
            ->where('favorites.user_id', $user_id)
            ->select('songs.*', 'artists.artist_name', 'favorites.added_at')
            ->orderByDesc('favorites.added_at')
            ->limit(10)
            ->get();

        $queue_songs = $trending
            ->concat($newest_songs)
            ->concat($liked_songs)
            ->concat($history_list)
            ->unique('song_id')
            ->values();

        // Dữ liệu cho Javascript (Audio Player)
        $js_data = [
            'trending' => $trending,
            'newest' => $newest_songs,
            'queue' => $queue_songs,
        ];

        // Trả về view 'music.home' nằm trong resources/views/music/home.blade.php
        return view('music.home', compact(
            'trending', 'newest_songs', 'albums', 'artists_list', 
            'news_list', 'count_liked', 'my_playlists', 'playlist_songs_map', 'history_list', 'liked_songs', 'queue_songs', 'js_data'
        ));
    }
}