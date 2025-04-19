<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\{LikeController, PhotoController, AdminController, UserController, CommentController};
use App\Models\Photo;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\PenggunaController;


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

Route::get('/welcome', function () {
    $photos = Photo::latest()->take(8)->get(); 
    return view('welcome', compact('photos'));
})->name('welcome');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [WelcomeController::class, 'index']);



Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return auth()->user()->role === 'admin' 
            ? redirect()->route('admin.dashboard') 
            : redirect()->route('user.dashboard');
    })->name('dashboard');


    Route::middleware(['role:user'])->group(function () {
        Route::get('/user', [UserController::class, 'index'])->name('user.dashboard');
        Route::get('/profile/{id}', [UserController::class, 'showProfile'])->name('profile.show');
        Route::get('/dashboard-user/photos', [PhotoController::class, 'index'])->name('photos.index');

    });
    Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
        Route::get('/pengguna', [AdminController::class, 'showUsers'])->name('admin.pengguna.index');
        Route::get('/pengguna/{id}/edit', [AdminController::class, 'editUser'])->name('admin.pengguna.edit');
        Route::put('/pengguna/{id}', [AdminController::class, 'updateUser'])->name('admin.pengguna.update');
        Route::delete('/pengguna/{id}',[AdminController::class, 'destroyUser'])->name('admin.pengguna.destroy');
        Route::get('/pengguna/create',[AdminController::class, 'createPengguna'])->name('admin.pengguna.create');
    Route::post('/pengguna',[AdminController::class, 'storePengguna'])->name('admin.pengguna.store');
      });

    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::delete('/admin/users/{id}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');
        Route::patch('/photos/{id}/toggle', [PhotoController::class, 'toggleStatus'])->name('photos.toggle');
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/admin/likes', [AdminController::class, 'likesChart'])->name('admin.likes');
        Route::get('/admin/comments', [AdminController::class, 'commentsChart'])->name('admin.comments');
        Route::get('/admin/photos', [AdminController::class, 'photosChart'])->name('admin.photos'); 

    });
    
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
        Route::get('/photos/create', [PhotoController::class, 'create'])->name('photos.create');
        Route::post('/photos', [PhotoController::class, 'store'])->name('photos.store');
        Route::post('/photos/{photo}/like', [PhotoController::class, 'like'])->name('photos.like');
        Route::get('/', [PhotoController::class, 'showWelcome']);
        Route::get('/dashboard-user/photos', [PhotoController::class, 'index'])->name('photos.index');
        Route::get('/kategori/{id}', [PhotoController::class, 'byCategory'])->name('photos.byCategory');
        Route::get('/kategori/{nama}', [KategoriController::class, 'show']);

    });

    Route::prefix('photos/{id}')->group(function () {
        Route::post('/like', [LikeController::class, 'like'])->name('photos.like');
        Route::get('/likes', [LikeController::class, 'getLikes'])->name('photos.likes');
    });

    Route::post('/photo/{id}/comment', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

});



Route::resource('pengguna', PenggunaController::class)->middleware('auth', 'role:admin');


Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
Route::get('/gallery/search', [GalleryController::class, 'search'])->name('gallery.search');
Route::post('/photos/{photo}/like', [GalleryController::class, 'like'])->name('photos.like');



Route::get('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');
