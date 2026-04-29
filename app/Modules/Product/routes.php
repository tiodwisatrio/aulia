<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Product\Http\Controllers\Backend\ProductController as BackendProductController;
use App\Modules\Product\Http\Controllers\Frontend\ProductController as FrontendProductController;

// Frontend routes (public)
Route::get('/products', [FrontendProductController::class, 'index'])->name('frontend.products.index');
Route::get('/products/{product:produk_slug}', [FrontendProductController::class, 'show'])->name('frontend.products.show');
Route::get('/cart', [FrontendProductController::class, 'cart'])->name('frontend.cart');

// Backend routes (protected)
Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    Route::resource('products', BackendProductController::class)
        ->middleware('can:admin-access');
});
