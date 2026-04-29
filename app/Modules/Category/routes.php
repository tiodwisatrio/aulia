<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Category\Http\Controllers\Backend\CategoryController as BackendCategoryController;
use App\Modules\Category\Http\Controllers\Frontend\CategoryController as FrontendCategoryController;

// Frontend routes (public)
Route::get('/categories', [FrontendCategoryController::class, 'index'])->name('frontend.categories.index');
Route::get('/categories/{category:slug}', [FrontendCategoryController::class, 'show'])->name('frontend.categories.show');

// Backend routes (protected)
Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    Route::resource('categories', BackendCategoryController::class)
        ->middleware('can:admin-access');
});
