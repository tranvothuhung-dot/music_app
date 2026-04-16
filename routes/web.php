<?php

use App\Http\Controllers\Admin\ArtistController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\SongController;
use App\Http\Controllers\Admin\AlbumsController;
use App\Http\Controllers\Admin\GenresController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);
Route::get('/music', [HomeController::class, 'index'])->name('music.index');
Route::post('/timkiem', [HomeController::class, 'search'])->name('music.search');

Route::get('/dashboard', function () {
    if (auth()->user()?->role_id === 1) {
        return redirect()->route('admin.dashboard');
    }

    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::view('/dashboard', 'admin.dashboard')->name('dashboard');

        Route::get('/users', [UsersController::class, 'users'])->name('users.index');
        Route::post('/users', [UsersController::class, 'storeUser'])->name('users.store');
        Route::put('/users/{user}', [UsersController::class, 'updateUser'])->name('users.update');
        Route::delete('/users/{user}', [UsersController::class, 'destroyUser'])->name('users.destroy');

        Route::get('/artists', [ArtistController::class, 'index'])->name('artists.index');
        Route::post('/artists', [ArtistController::class, 'store'])->name('artists.store');
        Route::put('/artists/{artist}', [ArtistController::class, 'update'])->name('artists.update');
        Route::delete('/artists/{artist}', [ArtistController::class, 'destroy'])->name('artists.destroy');

        Route::get('/albums', [AlbumsController::class, 'index'])->name('albums.index');
        Route::post('/albums', [AlbumsController::class, 'store'])->name('albums.store');
        Route::put('/albums/{album}', [AlbumsController::class, 'update'])->name('albums.update');
        Route::delete('/albums/{album}', [AlbumsController::class, 'destroy'])->name('albums.destroy');

        Route::get('/genres', [GenresController::class, 'index'])->name('genres.index');
        Route::post('/genres', [GenresController::class, 'store'])->name('genres.store');
        Route::put('/genres/{genre}', [GenresController::class, 'update'])->name('genres.update');
        Route::delete('/genres/{genre}', [GenresController::class, 'destroy'])->name('genres.destroy');

        Route::get('/songs', [SongController::class, 'index'])->name('songs.index');
        Route::post('/songs', [SongController::class, 'store'])->name('songs.store');
        Route::patch('/songs/{song}', [SongController::class, 'update'])->name('songs.update');
        Route::delete('/songs/{song}', [SongController::class, 'destroy'])->name('songs.destroy');

        Route::get('/news', [NewsController::class, 'index'])->name('news.index');
        Route::post('/news', [NewsController::class, 'store'])->name('news.store');
        Route::patch('/news/{news}', [NewsController::class, 'update'])->name('news.update');
        Route::delete('/news/{news}', [NewsController::class, 'destroy'])->name('news.destroy');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
