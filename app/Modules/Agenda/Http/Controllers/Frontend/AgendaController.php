<?php

namespace App\Modules\Agenda\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Modules\Agenda\Models\Agenda;

class AgendaController extends Controller
{
    public function index()
    {
        $agendas = Agenda::where('agenda_status', 1)
            ->latest()
            ->paginate(10);

        return view('agenda::frontend.index', compact('agendas'));
    }

    public function show(Agenda $agenda)
    {
        if ($agenda->agenda_status !== 1) {
            abort(404);
        }

        return view('agenda::frontend.show', compact('agenda'));
    }
}
