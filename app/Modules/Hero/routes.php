<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Hero\Http\Controllers\Backend\HeroController;

Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    Route::resource('heroes', HeroController::class)
        ->middleware('can:admin-access');
});
