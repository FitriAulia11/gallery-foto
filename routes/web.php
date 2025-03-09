<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\CommentController;
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
Route::get('/photo/{id}', function ($id) {
    $photo = Photo::findOrFail($id);
    return response()->file(storage_path('app/public/' . $photo->image_path));
});
// Halaman utama
Route::get('/', function () {
    return view('welcome');
});

// Autentikasi
Auth::routes();

// Halaman User
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user', [UserController::class, 'index'])->name('user.dashboard');

    // Foto
    Route::get('/photos/create', [PhotoController::class, 'create'])->name('photos.create');
    Route::post('/photos', [PhotoController::class, 'store'])->name('photos.store');
    Route::get('/photos/{id}/edit', [PhotoController::class, 'edit'])->name('photos.edit');
    Route::put('/photos/{id}', [PhotoController::class, 'update'])->name('photos.update');
    Route::delete('/photos/{id}', [PhotoController::class, 'destroy'])->name('photos.destroy');

    // Komentar & Like
    Route::post('/photos/{id}/comment', [CommentController::class, 'store'])->name('comments.store');
    Route::post('/photos/{id}/like', [PhotoController::class, 'like'])->name('photos.like');
});

// Halaman Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');

    
  
    // Kelola User
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::delete('/admin/users/{id}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');

    // On/Off Foto
    Route::patch('/admin/photos/{id}/toggle', [PhotoController::class, 'toggleStatus'])->name('photos.toggle');
});