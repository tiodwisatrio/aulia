<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Catalog\Http\Controllers\Backend\CatalogController as BackendCatalogController;
use App\Modules\Catalog\Http\Controllers\Frontend\CatalogController as FrontendCatalogController;

// Frontend routes (public)
Route::get('/catalogs', [FrontendCatalogController::class, 'index'])->name('frontend.catalogs.index');
Route::get('/catalogs/{catalog:slug}', [FrontendCatalogController::class, 'show'])->name('frontend.catalogs.show');

// Backend routes (protected)
Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    Route::resource('catalogs', BackendCatalogController::class)
        ->middleware('can:admin-access');
});
