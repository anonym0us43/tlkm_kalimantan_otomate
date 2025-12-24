<?php

use Mews\Captcha\Captcha;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MapController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DashboardController;

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'login_post'])->name('login.post');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('captcha', [Captcha::class, 'create'])->name('captcha');

Route::middleware(['auth'])->group(function ()
{
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::prefix('profile')->group(function ()
    {
        Route::get('/', [UserController::class, 'profile'])->name('profile');
        Route::post('{id}', [UserController::class, 'profile_post'])->name('profile.post');
    });

    Route::prefix('order')->group(function ()
    {
        Route::get('{id}', [OrderController::class, 'index'])->name('order.index');
        Route::post('index', [OrderController::class, 'order_post'])->name('order.post');
        Route::post('status', [OrderController::class, 'status_post'])->name('order.status.post');
        Route::post('reject', [OrderController::class, 'reject_post'])->name('order.reject');
    });

    Route::prefix('dashboard')->group(function ()
    {
        Route::get('monitoring', [DashboardController::class, 'monitoring'])->name('dashboard.monitoring');
        Route::get('monitoring-detail', [DashboardController::class, 'monitoring_detail'])->name('dashboard.monitoring.detail');
        Route::get('rekoncile', [DashboardController::class, 'rekoncile'])->name('dashboard.rekoncile');
    });

    Route::prefix('document')->group(function ()
    {
        Route::get('generate-spk/{id}', [DocumentController::class, 'generate_spk'])->name('document.generate_spk');
        Route::get('generate-ba-recovery/{id}', [DocumentController::class, 'generate_ba_recovery'])->name('document.generate_ba_recovery');
    });

    Route::prefix('ajax')->group(function ()
    {
        Route::prefix('order')->group(function ()
        {
            Route::get('tacc-ticket-alita-detail', [AjaxController::class, 'tacc_ticket_alita_detail'])->name('ajax.order.tacc.ticket.alita.detail');
        });

        Route::prefix('dashboard')->group(function ()
        {
            Route::prefix('monitoring')->group(function ()
            {
                Route::get('/', [AjaxController::class, 'dashboard_monitoring'])->name('ajax.dashboard.monitoring');
                Route::get('detail', [AjaxController::class, 'dashboard_monitoring_detail'])->name('ajax.dashboard.monitoring.detail');
            });
            Route::get('rekoncile', [AjaxController::class, 'dashboard_rekoncile'])->name('ajax.dashboard.rekoncile');
        });

        Route::prefix('setting')->group(function ()
        {
            Route::get('designator-khs', [AjaxController::class, 'designator_khs'])->name('ajax.setting.designator.khs');
        });
    });
});

Route::middleware(['guest'])->group(function ()
{
    Route::prefix('map')->group(function ()
    {
        Route::get('/', [MapController::class, 'index'])->name('map.index');
        Route::get('site-to-site', [MapController::class, 'site_to_site'])->name('map.site.to.site');
    });

    Route::prefix('ajax')->group(function ()
    {
        Route::prefix('map')->group(function ()
        {
            Route::prefix('sites')->group(function ()
            {
                Route::get('/', [AjaxController::class, 'map_get_sites'])->name('ajax.map.sites');
                Route::get('site-to-site', [AjaxController::class, 'map_get_site_to_site'])->name('ajax.map.site.to.site');
            });
        });
    });
});
