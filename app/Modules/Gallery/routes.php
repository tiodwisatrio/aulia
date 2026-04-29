<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Gallery\Http\Controllers\Backend\GalleryController;

// WAJIB: tulis namespace lengkap controller yang benar

Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    Route::resource('galleries', GalleryController::class)
        ->middleware('can:admin-access');
});