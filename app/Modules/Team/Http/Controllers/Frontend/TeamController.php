<?php

namespace App\Modules\Team\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Modules\Team\Models\Team;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::where('tim_status', 1)
            ->latest()
            ->paginate(10);

        return view('team::frontend.index', compact('teams'));
    }

    public function show(Team $team)
    {
        if ($team->tim_status !== 1) {
            abort(404);
        }

        return view('team::frontend.show', compact('team'));
    }
}
