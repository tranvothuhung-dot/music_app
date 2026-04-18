<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LibraryController;

Route::get('/', [HomeController::class, 'index']);
Route::get('/music', [HomeController::class, 'index'])->name('music.index');
Route::post('/timkiem', [HomeController::class, 'search'])->name('music.search');
Route::get('/music/liked-songs', [LibraryController::class, 'likedSongs'])->name('liked.songs');
Route::post('/music/liked-songs/remove/{song_id}', [LibraryController::class, 'removeLikedSong'])->name('liked.songs.remove');
Route::post('/music/playlist/create', [LibraryController::class, 'createPlaylist'])->name('playlist.create');
Route::post('/music/playlist/add-song', [LibraryController::class, 'addSongToPlaylist'])->name('playlist.add.song');
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
