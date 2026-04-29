<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Navigation\Http\Controllers\Backend\NavigationController as BackendNavigationController;
use App\Modules\Navigation\Http\Controllers\Frontend\NavigationController as FrontendNavigationController;

// Frontend routes (public)
Route::get('/navigations', [FrontendNavigationController::class, 'index'])->name('frontend.navigations.index');
Route::get('/navigations/{navigation:slug}', [FrontendNavigationController::class, 'show'])->name('frontend.navigations.show');

// Backend routes (protected)
Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    Route::get('navigations', [BackendNavigationController::class, 'index'])
        ->name('navigations.index')
        ->middleware('can:admin-access');
    Route::post('navigations/reorder', [BackendNavigationController::class, 'reorder'])
        ->name('navigations.reorder')
        ->middleware('can:admin-access');
    Route::post('navigations', [BackendNavigationController::class, 'store'])
        ->name('navigations.store')
        ->middleware('can:admin-access');
    Route::put('navigations/{navigation}', [BackendNavigationController::class, 'update'])
        ->name('navigations.update')
        ->middleware('can:admin-access');
    Route::delete('navigations/{navigation}', [BackendNavigationController::class, 'destroy'])
        ->name('navigations.destroy')
        ->middleware('can:admin-access');
});
