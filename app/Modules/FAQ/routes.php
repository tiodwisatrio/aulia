<?php

use Illuminate\Support\Facades\Route;
use App\Modules\FAQ\Http\Controllers\Backend\FAQController as BackendFAQController;
use App\Modules\FAQ\Http\Controllers\Frontend\FAQController as FrontendFAQController;

// Frontend routes (public)
Route::get('/faqs', [FrontendFAQController::class, 'index'])->name('frontend.faqs.index');
Route::get('/faqs/{faq:slug}', [FrontendFAQController::class, 'show'])->name('frontend.faqs.show');

// Backend routes (protected)
Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    Route::resource('faqs', BackendFAQController::class)
        ->middleware('can:admin-access');
});
