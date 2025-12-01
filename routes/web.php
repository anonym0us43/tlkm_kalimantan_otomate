<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'login_post'])->name('login.post');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['guest'])->group(function ()
{
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::prefix('profile')->group(function ()
    {
        Route::get('/', [UserController::class, 'profile'])->name('profile');
        Route::post('{id}', [UserController::class, 'profile_post'])->name('profile.post');
    });

    Route::prefix('dashboard')->group(function ()
    {
        Route::get('monitoring', [DashboardController::class, 'monitoring'])->name('dashboard.monitoring');
        Route::get('listing', [DashboardController::class, 'listing'])->name('dashboard.listing');
    });
});
