<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Agenda\Http\Controllers\Backend\AgendaController as BackendAgendaController;
use App\Modules\Agenda\Http\Controllers\Frontend\AgendaController as FrontendAgendaController;

// Frontend routes (public)
Route::get('/agendas', [FrontendAgendaController::class, 'index'])->name('frontend.agendas.index');
Route::get('/agendas/{agenda:slug}', [FrontendAgendaController::class, 'show'])->name('frontend.agendas.show');

// Backend routes (protected)
Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    Route::resource('agendas', BackendAgendaController::class)
        ->middleware('can:admin-access');
});
