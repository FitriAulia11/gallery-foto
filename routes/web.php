<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\{LikeController, PhotoController, AdminController, UserController, CommentController};
use App\Http\Controllers\WelcomeController;
use App\Models\Photo;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Halaman Utama
Route::get('/welcome', function () {
    $photos = Photo::latest()->take(8)->get(); // Misal ambil 8 foto terbaru
    return view('welcome', compact('photos'));
})->name('welcome');

// Autentikasi
Auth::routes();

// Redirect setelah login
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



// Middleware untuk autentikasi
Route::middleware(['auth'])->group(function () {
    // Redirect berdasarkan role user
    Route::get('/dashboard', function () {
        return auth()->user()->role === 'admin' 
            ? redirect()->route('admin.dashboard') 
            : redirect()->route('user.dashboard');
    })->name('dashboard');

    // Routes untuk pengguna (User)
    Route::middleware(['role:user'])->group(function () {
        Route::get('/user', [UserController::class, 'index'])->name('user.dashboard');
        Route::get('/profile/{id}', [UserController::class, 'showProfile'])->name('profile.show');
        Route::get('/dashboard-user/photos', [PhotoController::class, 'index'])->name('photos.index');

    });
    Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
        Route::get('/pengguna', [AdminController::class, 'showUsers'])->name('admin.pengguna.index');
        Route::get('/pengguna/{id}/edit', [AdminController::class, 'editUser'])->name('admin.pengguna.edit');
        Route::put('/pengguna/{id}', [AdminController::class, 'updateUser'])->name('admin.pengguna.update');
        Route::delete('/pengguna/{id}', [AdminController::class, 'destroyUser'])->name('admin.pengguna.destroy');
        Route::get('/pengguna/create',         [AdminController::class, 'createPengguna'])->name('admin.pengguna.create');
    Route::post('/pengguna',               [AdminController::class, 'storePengguna'])->name('admin.pengguna.store');
      });

    // Routes untuk admin
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::delete('/admin/users/{id}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');
        Route::patch('/photos/{id}/toggle', [PhotoController::class, 'toggleStatus'])->name('photos.toggle');
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/admin/likes', [AdminController::class, 'likesChart'])->name('admin.likes');
        Route::get('/admin/comments', [AdminController::class, 'commentsChart'])->name('admin.comments');
        Route::get('/admin/photos', [AdminController::class, 'photosChart'])->name('admin.photos'); // Pastikan ini ada

    });
    
    // Routes untuk Foto
    Route::prefix('photos')->name('photos.')->group(function () {
        Route::get('/', [PhotoController::class, 'index'])->name('index');
        Route::get('/create', [PhotoController::class, 'create'])->name('create');
        Route::post('/', [PhotoController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [PhotoController::class, 'edit'])->name('edit');
        Route::put('/{id}', [PhotoController::class, 'update'])->name('update');
        Route::delete('/{id}', [PhotoController::class, 'destroy'])->name('destroy');
        Route::get('/user', [PhotoController::class, 'user'])->name('user');
        Route::get('/{photo}', [PhotoController::class, 'show'])->name('show');
        Route::post('/photos/{photo}/comments', [PhotoCommentController::class, 'store'])->name('photos.comments');

        Route::post('/photos/{photo}/like', [PhotoController::class, 'like'])->name('photos.like');
        Route::get('/', [PhotoController::class, 'showWelcome']);
        Route::get('/dashboard-user/photos', [PhotoController::class, 'index'])->name('photos.index');
    });

    // Routes untuk Like
    Route::prefix('photos/{id}')->group(function () {
        Route::post('/like', [LikeController::class, 'like'])->name('photos.like');
        Route::get('/likes', [LikeController::class, 'getLikes'])->name('photos.likes');
    });

    // Routes untuk Komentar
    Route::post('/photo/{id}/comment', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

});


Route::get('/', [WelcomeController::class, 'index']);

Route::resource('pengguna', PenggunaController::class)->middleware('auth', 'role:admin');

// Route untuk halaman galeri foto

Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
Route::get('/gallery/search', [GalleryController::class, 'search'])->name('gallery.search');
Route::post('/photos/{photo}/like', [GalleryController::class, 'like'])->name('photos.like');

// Logout
Route::get('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');
