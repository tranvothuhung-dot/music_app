<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LibraryController extends Controller
{
    public function likedSongs()
    {
        $userId = Auth::user()->user_id;

        $likedSongs = DB::table('favorites as f')
            ->join('songs as s', 'f.song_id', '=', 's.song_id')
            ->leftJoin('artists as a', 's.artist_id', '=', 'a.artist_id')
            ->select(
                'f.song_id',
                's.song_name',
                's.song_image',
                'a.artist_name'
            )
            ->where('f.user_id', $userId)
            ->orderByDesc('f.added_at')
            ->get();

        $playlists = DB::table('playlists')
            ->where('user_id', $userId)
            ->orderByDesc('playlist_id')
            ->get();

        return view('music.liked-songs', [
            'title' => 'Liked Songs',
            'likedSongs' => $likedSongs,
            'playlists' => $playlists,
        ]);
    }

    public function removeLikedSong($song_id)
    {
        $userId = Auth::user()->user_id;

        DB::table('favorites')
            ->where('user_id', $userId)
            ->where('song_id', $song_id)
            ->delete();

        return redirect()->route('liked.songs')
            ->with('success', 'Đã xóa bài hát khỏi yêu thích');
    }

    public function createPlaylist(Request $request)
    {
        $request->validate([
            'playlist_name' => 'required|string|max:255',
        ]);

        $userId = Auth::user()->user_id;

        DB::table('playlists')->insert([
            'user_id' => $userId,
            'playlist_name' => $request->playlist_name,
            'created_at' => now(),
        ]);

        return redirect()->route('liked.songs')
            ->with('success', 'Tạo playlist thành công');
    }

    public function addSongToPlaylist(Request $request)
    {
        $request->validate([
            'song_id' => 'required|integer',
            'playlist_id' => 'required|integer',
        ]);

        $userId = Auth::user()->user_id;

        $playlist = DB::table('playlists')
            ->where('playlist_id', $request->playlist_id)
            ->where('user_id', $userId)
            ->first();

        if (! $playlist) {
            return redirect()->route('liked.songs')
                ->with('error', 'Playlist không hợp lệ');
        }

        $exists = DB::table('playlist_songs')
            ->where('playlist_id', $request->playlist_id)
            ->where('song_id', $request->song_id)
            ->exists();

        if (! $exists) {
            DB::table('playlist_songs')->insert([
                'playlist_id' => $request->playlist_id,
                'song_id' => $request->song_id,
                'added_at' => now(),
            ]);
        }

        return redirect()->route('liked.songs')
            ->with('success', 'Đã thêm bài hát vào playlist');
    }
}