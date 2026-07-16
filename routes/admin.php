<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;

Route::get('admin/login', [AuthController::class, 'create'])->name('admin.login');
Route::post('admin/login', [AuthController::class, 'store'])->name('admin.login.store');
Route::post('admin/logout', [AuthController::class, 'destroy'])->name('admin.logout');


Route::group(['as' => 'admin.', 'prefix' => 'admin', 'middleware' => ['auth','role:admin']], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Profile
     Route::get('profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('profile/password', [ProfileController::class, 'PasswordUpdate'])->name('profile.password.update');

    // User Management
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    // Role Management
    Route::resource('roles', \App\Http\Controllers\Admin\RoleController::class);
});
