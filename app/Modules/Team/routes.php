<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Team\Http\Controllers\Backend\TeamController as BackendTeamController;
use App\Modules\Team\Http\Controllers\Frontend\TeamController as FrontendTeamController;

// Frontend routes (public)
Route::get('/teams', [FrontendTeamController::class, 'index'])->name('frontend.teams.index');
Route::get('/teams/{team:slug}', [FrontendTeamController::class, 'show'])->name('frontend.teams.show');

// Backend routes (protected)
Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    Route::resource('teams', BackendTeamController::class)
        ->middleware('can:admin-access');
});
