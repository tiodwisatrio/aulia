<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Reel\Http\Controllers\Backend\ReelController as BackendReelController;
use App\Modules\Reel\Http\Controllers\Frontend\ReelController as FrontendReelController;

// Backend
Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    Route::resource('reels', BackendReelController::class)
        ->except(['show'])
        ->middleware('can:admin-access');
});

// Frontend
Route::get('/projects', [FrontendReelController::class, 'index'])
    ->name('frontend.reels.index');
