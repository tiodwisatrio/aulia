<?php

use Illuminate\Support\Facades\Route;
use App\Modules\OurClient\Http\Controllers\Backend\OurClientController as BackendOurClientController;
use App\Modules\OurClient\Http\Controllers\Frontend\OurClientController as FrontendOurClientController;

// Frontend routes (public)
Route::get('/ourclients', [FrontendOurClientController::class, 'index'])->name('frontend.ourclients.index');
Route::get('/ourclients/{ourclient:slug}', [FrontendOurClientController::class, 'show'])->name('frontend.ourclients.show');

// Backend routes (protected)
Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    Route::resource('ourclient', BackendOurClientController::class, [
        'parameters' => ['ourclient' => 'ourclient']
    ])->middleware('can:admin-access');
});
