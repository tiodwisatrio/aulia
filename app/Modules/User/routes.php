<?php

use Illuminate\Support\Facades\Route;
use App\Modules\User\Http\Controllers\Backend\UserController;

/**
 * User Module Routes
 *
 * All user management routes are defined here
 */

Route::middleware(['auth'])->prefix('dashboard')->name('')->group(function () {
    Route::resource('users', UserController::class)
        ->middleware('can:admin-access');
});
