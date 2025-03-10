<?php

use Illuminate\Support\Facades\Route;
 
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


    Route::get('/gallery', [PhotoController::class, 'index'])->name('photos.index');
    Route::get('/photos/create', [PhotoController::class, 'create'])->name('photos.create');
    Route::post('/photos', [PhotoController::class, 'store'])->name('photos.store');
    Route::get('/photos/{id}/edit', [PhotoController::class, 'edit'])->name('photos.edit');
    Route::put('/photos/{id}', [PhotoController::class, 'update'])->name('photos.update');
    Route::delete('/photos/{id}', [PhotoController::class, 'destroy'])->name('photos.destroy');
    Route::get('/photos/user', [PhotoController::class, 'user'])->name('photos.user');
    Route::post('/photos/{photo}/like', [PhotoController::class, 'like'])->name('photos.like');
    Route::get('/photos/{photo}', [PhotoController::class, 'show'])->name('photos.show'); // Untuk komentar

    
    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::delete('/admin/users/{id}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');
    });

  Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user', [UserController::class, 'index'])->name('user.dashboard');
});

Route::get('/dashboard', function () {
    return auth()->user()->role === 'admin' 
        ? redirect()->route('admin.dashboard') 
        : redirect()->route('user.dashboard');
})->middleware('auth')->name('dashboard');
});

