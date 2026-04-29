<?php

namespace App\Modules\About\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Modules\About\Models\About;
use App\Modules\OurValue\Models\OurValue;

class AboutController extends Controller
{
    public function index()
    {
        $abouts = About::where('tentang_status', 1)
            ->latest()
            ->get();

        $ourvalues = OurValue::where('nilai_kami_status', 1)
            ->orderBy('nilai_kami_urutan')
            ->get();

        return view('about::frontend.index', compact('abouts', 'ourvalues'));
    }

    public function show(About $about)
    {
        if ($about->status !== 1) {
            abort(404);
        }

        return view('about::frontend.show', compact('about'));
    }
}
