<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Menu\Http\Controllers\Backend\MenuController;

Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    Route::resource('menus', MenuController::class)
        ->middleware('can:admin-access');
});
