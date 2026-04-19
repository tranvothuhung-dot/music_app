<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();

        return view('profile.edit', [
            'user' => $user,
            ...$this->dashboardSharedData((int) ($user?->getKey() ?? 0)),
        ]);
    }

    private function dashboardSharedData(int $userId): array
    {
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

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $validated = $request->validated();

        foreach (['name', 'username'] as $optionalField) {
            if (!array_key_exists($optionalField, $validated)) {
                continue;
            }

            if ($validated[$optionalField] === null || $validated[$optionalField] === '') {
                unset($validated[$optionalField]);
            }
        }

        if ($request->hasFile('avatar_image')) {
            $file = $request->file('avatar_image');
            $fileName = 'avatar_' . $user->getKey() . '_' . time() . '.' . $file->getClientOriginalExtension();

            if (! empty($user->avatar_image) && Storage::disk('public')->exists($user->avatar_image)) {
                Storage::disk('public')->delete($user->avatar_image);
            }

            Storage::disk('public')->putFileAs('avatars', $file, $fileName);
            $validated['avatar_image'] = 'avatars/' . $fileName;
        }

        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $user->fill($validated);

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
