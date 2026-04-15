<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
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

        Route::get('/users', [AdminController::class, 'users'])->name('users.index');
        Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
        Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
        Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');

        Route::view('/artists', 'admin.placeholder', [
            'title' => 'Nghệ Sĩ - Admin',
            'heading' => 'Nghệ Sĩ',
            'description' => 'Trang quản lý nghệ sĩ sẽ được hiển thị ở đây.',
        ])->name('artists.index');

        Route::view('/albums', 'admin.placeholder', [
            'title' => 'Albums - Admin',
            'heading' => 'Albums',
            'description' => 'Trang quản lý albums sẽ được hiển thị ở đây.',
        ])->name('albums.index');

        Route::view('/genres', 'admin.placeholder', [
            'title' => 'Thể Loại - Admin',
            'heading' => 'Thể Loại',
            'description' => 'Trang quản lý thể loại sẽ được hiển thị ở đây.',
        ])->name('genres.index');

        Route::view('/songs', 'admin.placeholder', [
            'title' => 'Bài Hát - Admin',
            'heading' => 'Bài Hát',
            'description' => 'Trang quản lý bài hát sẽ được hiển thị ở đây.',
        ])->name('songs.index');

        Route::view('/news', 'admin.placeholder', [
            'title' => 'Tin Tức - Admin',
            'heading' => 'Tin Tức',
            'description' => 'Trang quản lý tin tức sẽ được hiển thị ở đây.',
        ])->name('news.index');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
