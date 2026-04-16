<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);
Route::get('/music', [HomeController::class, 'index'])->name('music.index');
Route::post('/timkiem', [HomeController::class, 'search'])->name('music.search');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard/bai-hat', [HomeController::class, 'songs'])->name('dashboard.songs');
    Route::get('/dashboard/album', [HomeController::class, 'albums'])->name('dashboard.albums');
    Route::get('/dashboard/nghe-si', [HomeController::class, 'artists'])->name('dashboard.artists');
    Route::get('/dashboard/tin-tuc', [HomeController::class, 'news'])->name('dashboard.news');
    Route::post('/dashboard/favorites/toggle', [\App\Http\Controllers\Controller3::class, 'toggleFavorite'])->name('dashboard.favorites.toggle');
    Route::post('/dashboard/history/add', [\App\Http\Controllers\Controller3::class, 'addToHistory'])->name('dashboard.history.add');
    Route::post('/dashboard/playlists/delete', [\App\Http\Controllers\Controller3::class, 'deletePlaylist'])->name('dashboard.playlists.delete');
});

require __DIR__.'/auth.php';

use App\Http\Controllers\Controller3;

// Đảm bảo route này được bảo vệ bởi middleware 'auth' để chỉ user đã đăng nhập mới vào được
Route::get('/dashboard', [Controller3::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
