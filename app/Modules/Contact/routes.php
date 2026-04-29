<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Contact\Http\Controllers\Backend\ContactController as BackendContactController;
use App\Modules\Contact\Http\Controllers\Frontend\ContactController as FrontendContactController;

// Frontend routes (public)
Route::get('/contacts', [FrontendContactController::class, 'index'])->name('frontend.contacts.index');
Route::post('/contacts', [FrontendContactController::class, 'store'])->name('frontend.contacts.store');

// Backend routes (protected)
Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    Route::get('contacts', [BackendContactController::class, 'index'])
        ->name('contacts.index')
        ->middleware('can:admin-access');
    Route::get('contacts/{contact}', [BackendContactController::class, 'show'])
        ->name('contacts.show')
        ->middleware('can:admin-access');
    Route::post('contacts/{contact}/reply', [BackendContactController::class, 'reply'])
        ->name('contacts.reply')
        ->middleware('can:admin-access');
    Route::delete('contacts/{contact}', [BackendContactController::class, 'destroy'])
        ->name('contacts.destroy')
        ->middleware('can:admin-access');
});
