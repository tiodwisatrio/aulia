<?php

namespace App\Modules\Testimonial\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Modules\Testimonial\Models\Testimonial;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::where('testimoni_status', 1)
            ->orderBy('testimoni_urutan')
            ->paginate(10);

        return view('testimonial::frontend.index', compact('testimonials'));
    }

    public function show(Testimonial $testimonial)
    {
        if (!$testimonial->testimoni_status) {
            abort(404);
        }

        return view('testimonial::frontend.show', compact('testimonial'));
    }
}
