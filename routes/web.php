<?php

use App\Http\Controllers\MusicController2;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MusicController2::class, 'index']);
Route::get('/music', [MusicController2::class, 'index'])->name('music.index');
Route::get('/music/bai-hat/{id}', [MusicController2::class, 'songDetail'])->name('music.song');
Route::get('/music/bai-hat', [MusicController2::class, 'songs'])->name('music.songs');
Route::get('/music/album/{id}', [MusicController2::class, 'albumDetail'])->name('music.album');
Route::get('/music/album', [MusicController2::class, 'albums'])->name('music.albums');
Route::get('/music/nghe-si/{id}', [MusicController2::class, 'artistDetail'])->name('music.artist');
Route::get('/music/nghe-si', [MusicController2::class, 'artists'])->name('music.artists');
Route::get('/music/the-loai/{id}', [MusicController2::class, 'genreDetail'])->name('music.genre');
Route::get('/music/the-loai', [MusicController2::class, 'genres'])->name('music.genres');
Route::get('/music/genres', [MusicController2::class, 'genres'])->name('music.genres.alt');
Route::get('/music/tin-tuc', [MusicController2::class, 'news'])->name('music.news');
Route::post('/timkiem', [MusicController2::class, 'search'])->name('music.search');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
