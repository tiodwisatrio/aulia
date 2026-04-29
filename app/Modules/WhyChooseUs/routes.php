<?php

use Illuminate\Support\Facades\Route;
use App\Modules\WhyChooseUs\Http\Controllers\Backend\WhyChooseUsController as BackendWhyChooseUsController;
use App\Modules\WhyChooseUs\Http\Controllers\Frontend\WhyChooseUsController as FrontendWhyChooseUsController;

// Frontend routes (public)
Route::get('/whychooseus', [FrontendWhyChooseUsController::class, 'index'])->name('frontend.whychooseus.index');
Route::get('/whychooseus/{whychooseus:slug}', [FrontendWhyChooseUsController::class, 'show'])->name('frontend.whychooseus.show');

// Backend routes (protected)
Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    Route::resource('whychooseus', BackendWhyChooseUsController::class, [
        'parameters' => ['whychooseus' => 'whychooseus']
    ])->middleware('can:admin-access');
});
