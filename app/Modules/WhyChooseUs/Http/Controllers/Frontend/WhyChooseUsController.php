<?php

namespace App\Modules\WhyChooseUs\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Modules\WhyChooseUs\Models\WhyChooseUs;

class WhyChooseUsController extends Controller
{
    public function index()
    {
        $whychooseus = WhyChooseUs::where('mengapa_kami_status', 1)
            ->paginate(10);

        return view('whychooseus::frontend.index', compact('whychooseus'));
    }

    public function show(WhyChooseUs $whychooseus)
    {
        if (!$whychooseus->mengapa_kami_status) {
            abort(404);
        }

        return view('whychooseus::frontend.show', compact('whychooseus'));
    }
}
