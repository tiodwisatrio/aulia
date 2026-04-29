<?php

namespace App\Modules\OurValue\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Modules\OurValue\Models\OurValue;

class OurValueController extends Controller
{
    public function index()
    {
        $ourvalues = OurValue::where('nilai_kami_status', 1)
            ->orderBy('nilai_kami_urutan')
            ->paginate(10);

        return view('ourvalue::frontend.index', compact('ourvalues'));
    }

    public function show(OurValue $ourvalue)
    {
        if (!$ourvalue->nilai_kami_status) {
            abort(404);
        }

        return view('ourvalue::frontend.show', compact('ourvalue'));
    }
}
