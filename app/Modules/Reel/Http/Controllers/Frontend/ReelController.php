<?php

namespace App\Modules\Reel\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Modules\Reel\Models\Reel;

class ReelController extends Controller
{
    public function index()
    {
        $reels = Reel::where('reel_status', 1)
            ->orderBy('reel_urutan')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('reel::frontend.index', compact('reels'));
    }
}
