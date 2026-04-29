<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Testimonial\Http\Controllers\Backend\TestimonialController as BackendTestimonialController;
use App\Modules\Testimonial\Http\Controllers\Frontend\TestimonialController as FrontendTestimonialController;

// Frontend routes (public)
Route::get('/testimonials', [FrontendTestimonialController::class, 'index'])->name('frontend.testimonials.index');
Route::get('/testimonials/{testimonial:slug}', [FrontendTestimonialController::class, 'show'])->name('frontend.testimonials.show');

// Backend routes (protected)
Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    Route::resource('testimonials', BackendTestimonialController::class)
        ->middleware('can:admin-access');
});
