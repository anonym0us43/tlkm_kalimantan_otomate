<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\MapController;

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
        Route::get('rekoncile', [DashboardController::class, 'rekoncile'])->name('dashboard.rekoncile');
    });

    Route::prefix('map')->group(function ()
    {
        Route::get('/', [MapController::class, 'index'])->name('map.index');
        Route::get('site-to-site', [MapController::class, 'site_to_site'])->name('map.site.to.site');
    });

    Route::prefix('ajax')->group(function ()
    {
        Route::prefix('dashboard')->group(function ()
        {
            Route::prefix('monitoring')->group(function ()
            {
                Route::get('/', [AjaxController::class, 'dashboard_monitoring'])->name('ajax.dashboard.monitoring');
                Route::get('detail', [AjaxController::class, 'dashboard_monitoring_detail'])->name('ajax.dashboard.monitoring.detail');
            });
        });

        Route::prefix('map')->group(function ()
        {
            Route::prefix('sites')->group(function ()
            {
                Route::get('/', [AjaxController::class, 'map_get_sites'])->name('ajax.map.sites');
                Route::get('{site_id}', [AjaxController::class, 'map_get_site_by_id'])->name('ajax.map.site.by.id');
            });
        });
    });
});
