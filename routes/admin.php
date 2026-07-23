<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\BrokerController;
use App\Http\Controllers\Admin\HRController;
use App\Http\Controllers\Admin\LeadsController;
use App\Http\Controllers\Admin\MightyCallController;

Route::get('admin/login', [AuthController::class, 'create'])->name('admin.login');
Route::post('admin/login', [AuthController::class, 'store'])->name('admin.login.store');
Route::post('admin/logout', [AuthController::class, 'destroy'])->name('admin.logout');


Route::group(['as' => 'admin.', 'prefix' => 'admin', 'middleware' => ['auth']], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Profile
     Route::get('profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('profile/password', [ProfileController::class, 'PasswordUpdate'])->name('profile.password.update');

    // User Management
    Route::resource('users', UserController::class)->middleware('role:admin');
    // Role Management
    Route::resource('roles', RoleController::class)->middleware('role:admin');
    //Broker Management
    Route::resource('brokers', BrokerController::class)->middleware('permission:manage-brokers');
    // HR Management
    Route::resource('hr', HRController::class)->middleware('permission:manage-hr');
    // Leads
    Route::get('leads',[LeadsController::class,'index'])->name('leads')->middleware('permission:manage-leads');
    //Mighty Calls
    Route::middleware('permission:manage-mighty-calls')->group(function () {
        Route::get('/mc',[MightyCallController::class ,'index'])->name('mc');
        Route::get('/mc/agent-cards',[MightyCallController::class ,'agentCards'])->name('mc.agent-cards');
        // Open Api
        Route::post('/mc/{mightyCall}/summary', [MightyCallController::class, 'summary'])->name('mc.summary');
    });

    
});
