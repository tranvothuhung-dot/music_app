<?php

use App\Http\Controllers\Admin\ArtistController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\SongController;
use App\Http\Controllers\Admin\AlbumsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GenresController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\MusicController2;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Controller3;
use App\Http\Controllers\Controller5;
use Illuminate\Support\Facades\Route;


Route::get('/dashboard', function () {
    if ((int) (auth()->user()?->role_id ?? 0) === 1) {
        return redirect()->route('admin.dashboard');
    }

    return app(Controller3::class)->index();
})->middleware(['auth', 'verified'])->name('dashboard');
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

Route::get('/timkiem', [Controller5::class, 'search'])->name('music.search');
Route::get('/search/ajax', [Controller5::class, 'ajaxSearch'])->name('search.ajax');

Route::middleware(['auth', 'admin'])->group(function () {
    // Các route này CHỈ ADMIN mới vào được
    // Route::get('/admin/dashboard', [AdminController::class, 'index']);
    // Route::get('/admin/quan-ly-bai-hat', [AdminController::class, 'songs']);
    // ...
});

Route::middleware('auth')->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/users', [UsersController::class, 'users'])->name('users.index');
        Route::post('/users', [UsersController::class, 'storeUser'])->name('users.store');
        Route::put('/users/{user}', [UsersController::class, 'updateUser'])->name('users.update');
        Route::delete('/users/{user}', [UsersController::class, 'destroyUser'])->name('users.destroy');

        Route::get('/artists', [ArtistController::class, 'index'])->name('artists.index');
        Route::post('/artists', [ArtistController::class, 'store'])->name('artists.store');
        Route::put('/artists/{artist}', [ArtistController::class, 'update'])->name('artists.update');
        Route::delete('/artists/{artist}', [ArtistController::class, 'destroy'])->name('artists.destroy');

        Route::get('/albums', [AlbumsController::class, 'index'])->name('albums.index');
        Route::get('/albums/{album}/songs', [AlbumsController::class, 'songs'])->name('albums.songs');
        Route::post('/albums', [AlbumsController::class, 'store'])->name('albums.store');
        Route::put('/albums/{album}', [AlbumsController::class, 'update'])->name('albums.update');
        Route::delete('/albums/{album}', [AlbumsController::class, 'destroy'])->name('albums.destroy');

        Route::get('/genres', [GenresController::class, 'index'])->name('genres.index');
        Route::get('/genres/{genre}/songs', [GenresController::class, 'songs'])->name('genres.songs');
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

    Route::get('/dashboard/bai-hat', [HomeController::class, 'songs'])->name('dashboard.songs');
    Route::get('/dashboard/moi-phat-hanh', [HomeController::class, 'newReleases'])->name('dashboard.new-releases');
    Route::get('/dashboard/bang-xep-hang', [HomeController::class, 'leaderboard'])->name('dashboard.leaderboard');
    Route::get('/dashboard/album', [HomeController::class, 'albums'])->name('dashboard.albums');
    Route::get('/dashboard/nghe-si', [HomeController::class, 'artists'])->name('dashboard.artists');
    Route::get('/dashboard/the-loai', [HomeController::class, 'genres'])->name('dashboard.genres');
    Route::get('/dashboard/tin-tuc', [HomeController::class, 'news'])->name('dashboard.news');
    Route::get('/dashboard/tin-tuc/{newsId}', [HomeController::class, 'newsDetail'])->name('dashboard.news.detail');
    Route::get('/dashboard/yeu-thich', [HomeController::class, 'favorites'])->name('dashboard.favorites');
    Route::post('/dashboard/favorites/toggle', [\App\Http\Controllers\Controller3::class, 'toggleFavorite'])->name('dashboard.favorites.toggle');
    Route::post('/dashboard/history/add', [\App\Http\Controllers\Controller3::class, 'addToHistory'])->name('dashboard.history.add');
    Route::post('/dashboard/playlists/create', [\App\Http\Controllers\Controller3::class, 'createPlaylist'])->name('dashboard.playlists.create');
    Route::post('/dashboard/playlists/delete', [\App\Http\Controllers\Controller3::class, 'deletePlaylist'])->name('dashboard.playlists.delete');
    Route::post('/dashboard/playlists/add-song', [\App\Http\Controllers\Controller3::class, 'addSongToPlaylist'])->name('dashboard.playlists.addSong');
    Route::post('/dashboard/playlists/remove-song', [\App\Http\Controllers\Controller3::class, 'removeSongFromPlaylist'])->name('dashboard.playlists.removeSong');
    
});

require __DIR__.'/auth.php';
