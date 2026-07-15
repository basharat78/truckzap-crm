<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('admin/login', [DashboardController::class, 'login'])->name('admin.login');

Route::group(['as' => 'admin.', 'prefix' => 'admin', 'middleware' => ['auth','role:admin']], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Profile
    // Route::get('profile', [ProfileController::class, 'index'])->name('profile');
    // Route::post('profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::post('profile/password', [ProfileController::class, 'PasswordUpdate'])->name('profile.password.update');
});
