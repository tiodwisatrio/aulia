<?php

use Illuminate\Support\Facades\Route;
use App\Modules\ModuleGenerator\Http\Controllers\Backend\ModuleGeneratorController;

// Route::middleware(['auth'])->prefix('dashboard')->group(function () {
//     Route::get('module-generator', [ModuleGeneratorController::class, 'index'])
//         ->middleware('can:admin-access')
//         ->name('module-generator.index');

//     Route::post('module-generator', [ModuleGeneratorController::class, 'generate'])
//         ->middleware('can:admin-access')
//         ->name('module-generator.generate');

//     Route::post('module-generator/migrate', [ModuleGeneratorController::class, 'migrate'])
//         ->middleware('can:admin-access')
//         ->name('module-generator.migrate');
// });
