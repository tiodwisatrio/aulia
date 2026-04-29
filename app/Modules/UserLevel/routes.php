<?php

use Illuminate\Support\Facades\Route;
use App\Modules\UserLevel\Http\Controllers\Backend\UserLevelController;

Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    Route::get('user-levels', [UserLevelController::class, 'index'])
        ->middleware('can:developer-access')
        ->name('user-levels.index');

    Route::post('user-levels', [UserLevelController::class, 'update'])
        ->middleware('can:developer-access')
        ->name('user-levels.update');
});
