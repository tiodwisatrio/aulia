<?php

use Illuminate\Support\Facades\Route;
use App\Modules\OurValue\Http\Controllers\Backend\OurValueController as BackendOurValueController;
use App\Modules\OurValue\Http\Controllers\Frontend\OurValueController as FrontendOurValueController;

// Frontend routes (public)
Route::get('/ourvalues', [FrontendOurValueController::class, 'index'])->name('frontend.ourvalues.index');
Route::get('/ourvalues/{ourvalue:slug}', [FrontendOurValueController::class, 'show'])->name('frontend.ourvalues.show');

// Backend routes (protected)
Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    Route::resource('ourvalues', BackendOurValueController::class)
        ->middleware('can:admin-access');
});
