<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Header\Http\Controllers\Backend\HeaderController;

Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    Route::resource('headers', HeaderController::class)
        ->middleware('can:admin-access');
});
