<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\DashboardController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\UsersController;
// Route::get('/', function () {
//     return view('admin.auth.login');
// });


Route::get('/', [LoginController::class, 'showLoginForm'])->name('login')->middleware('redirectIfAuthenticated');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('redirectIfAuthenticated');
Route::post('/login', [LoginController::class, 'login'])->name('post.login');

Route::middleware(['auth'])->group(function () {
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::resource('users', UsersController::class);

    Route::get('my-profile', [ProfileController::class, 'index'])->name('user.getProfile');
    Route::get('edit-profile', [ProfileController::class, 'edit'])->name('user.editProfile');
    Route::put('edit-profile/{id}', [ProfileController::class, 'update'])->name('user.updateProfile');
    Route::get('change-password', [ProfileController::class, 'changePassword'])->name('user.changePassword');
    Route::post('change-password', [ProfileController::class, 'updatePassword'])->name('user.updatePassword');
});
