<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Core\Http\Controllers\DashboardController;
use App\Modules\Core\Http\Controllers\ProfileController;
use App\Http\Controllers\Frontend\SitemapController;

// Frontend routes
Route::get('/', [DashboardController::class, 'home'])->name('frontend.home');
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// Dashboard routes (protected)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile routes
    Route::get('/dashboard/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/dashboard/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/dashboard/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
