<?php

namespace App\Modules\OurClient\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Modules\OurClient\Models\OurClient;

class OurClientController extends Controller
{
    public function index()
    {
        $ourclients = OurClient::where('klien_status', 1)
            ->orderBy('klien_urutan')
            ->paginate(10);

        return view('ourclient::frontend.index', compact('ourclients'));
    }

    public function show(OurClient $ourclient)
    {
        if (!$ourclient->klien_status) {
            abort(404);
        }

        return view('ourclient::frontend.show', compact('ourclient'));
    }
}
