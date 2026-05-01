<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Menu\Http\Controllers\Backend\MenuController;
use App\Modules\Menu\Http\Controllers\Frontend\MenuController as FrontendMenuController;

Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    Route::resource('menus', MenuController::class)
        ->middleware('can:admin-access');
});

Route::prefix('menu')->name('frontend.menu.')->group(function () {
    Route::get('/', [FrontendMenuController::class, 'index'])->name('index');
});
