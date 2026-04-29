<?php

namespace App\Modules\FAQ\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Modules\FAQ\Models\FAQ;

class FAQController extends Controller
{
    public function index()
    {
        $faqs = FAQ::where('status', 1)
            ->orderBy('order')
            ->paginate(12);

        return view('faq::frontend.index', compact('faqs'));
    }

    public function show(FAQ $faq)
    {
        if ($faq->status !== 1) {
            abort(404);
        }

        return view('faq::frontend.show', compact('faq'));
    }
}
