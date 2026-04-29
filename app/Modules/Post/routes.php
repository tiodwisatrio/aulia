<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Post\Http\Controllers\Backend\PostController as BackendPostController;
use App\Modules\Post\Http\Controllers\Frontend\PostController as FrontendPostController;

// Frontend routes (public)
Route::get('/blog', [FrontendPostController::class, 'index'])->name('frontend.blog.index');
Route::get('/blog/{post:posts_slug}', [FrontendPostController::class, 'show'])->name('frontend.blog.show');

// Backend routes (protected)
Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    Route::resource('posts', BackendPostController::class)
        ->middleware('can:admin-access');
});
