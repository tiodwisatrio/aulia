<?php

use Illuminate\Support\Facades\Route;
use App\Modules\About\Http\Controllers\Backend\AboutController as BackendAboutController;
use App\Modules\About\Http\Controllers\Frontend\AboutController as FrontendAboutController;

// Frontend routes (public)
Route::get('/abouts', [FrontendAboutController::class, 'index'])->name('frontend.abouts.index');
Route::get('/abouts/{about:slug}', [FrontendAboutController::class, 'show'])->name('frontend.abouts.show');

// Backend routes (protected)
Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    Route::resource('abouts', BackendAboutController::class)
        ->middleware('can:admin-access');
});
