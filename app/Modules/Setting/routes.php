<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Setting\Http\Controllers\Backend\SettingController as BackendSettingController;
use App\Modules\Setting\Http\Controllers\Frontend\SettingController as FrontendSettingController;

// Frontend routes (public)
Route::get('/settings', [FrontendSettingController::class, 'index'])->name('frontend.settings.index');
Route::get('/settings/{setting:slug}', [FrontendSettingController::class, 'show'])->name('frontend.settings.show');

// Backend routes (protected)
Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    Route::get('settings', [BackendSettingController::class, 'index'])
        ->name('settings.index')
        ->middleware('can:admin-access');
    Route::put('settings', [BackendSettingController::class, 'update'])
        ->name('settings.update')
        ->middleware('can:admin-access');
});
