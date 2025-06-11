<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ArtistController;
use App\Http\Controllers\Admin\SongController;
use App\Http\Controllers\Admin\GenreController;
use App\Http\Controllers\Admin\PlaylistController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
// Route Auth (Đăng nhập, đăng ký)
Auth::routes();

// Trang chủ → Redirect đến trang login nếu chưa đăng nhập
Route::get('/', function () {
    return redirect('/music');
});

Route::prefix('admin')->middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
    Route::get('/home', [DashboardController::class, 'index'])->name('home');
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('users', UserController::class);
    Route::resource('artists', ArtistController::class);
    Route::resource('songs', SongController::class);
    Route::resource('genres', GenreController::class);
    Route::resource('playlists', PlaylistController::class);
    Route::get('/artists', [HomeController::class, 'artists'])->name('music.artists');
});

// Route login & logout
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
// Trang chủ công khai (frontend)
Route::get('/music', [App\Http\Controllers\HomeController::class, 'index'])->name('music.index');
Route::get('/music/{id}', [HomeController::class, 'show'])->name('music.show');
Route::get('/playlist/{name}', [HomeController::class, 'playlist'])->name('music.playlist');
Route::get('/genres', [HomeController::class, 'genres'])->name('genres.index');

?>