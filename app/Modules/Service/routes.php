<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Service\Http\Controllers\Backend\ServiceController as BackendServiceController;
use App\Modules\Service\Http\Controllers\Frontend\ServiceController as FrontendServiceController;

// Frontend routes (public)
Route::get('/services', [FrontendServiceController::class, 'index'])->name('frontend.services.index');
Route::get('/services/{service:slug}', [FrontendServiceController::class, 'show'])->name('frontend.services.show');

// Backend routes (protected)
Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    Route::resource('services', BackendServiceController::class)
        ->middleware('can:admin-access');
});
