<?php

namespace App\Modules\Testimonial\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Modules\Testimonial\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    public function index(Request $request)
    {
        $query = Testimonial::latest();

        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('testimoni_nama', 'like', '%' . $request->search . '%')
                  ->orWhere('testimoni_isi', 'like', '%' . $request->search . '%');
            });
        }

        $testimonials = $query->paginate(10);
        return view('testimonial::backend.index', compact('testimonials'));
    }

    public function create()
    {
        return view('testimonial::backend.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'testimoni_nama'   => 'required|string|max:191',
            'testimoni_isi'    => 'required|string',
            'testimoni_gambar' => 'nullable|image|max:2048',
            'testimoni_urutan' => 'nullable|integer',
        ]);
        $validated['testimoni_status'] = $request->has('testimoni_status') ? 1 : 0;
        if ($request->hasFile('testimoni_gambar')) {
            $validated['testimoni_gambar'] = $request->file('testimoni_gambar')->store('testimoni', 'public');
        }
        Testimonial::create($validated);
        return redirect()->route('testimonials.index')->with('success', 'Testimoni berhasil ditambahkan.');
    }

    public function show(Testimonial $testimonial)
    {
        return view('testimonial::backend.show', compact('testimonial'));
    }

    public function edit($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        return view('testimonial::backend.edit', compact('testimonial'));
    }

    public function update(Request $request, $id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $validated = $request->validate([
            'testimoni_nama'   => 'required|string|max:191',
            'testimoni_isi'    => 'required|string',
            'testimoni_gambar' => 'nullable|image|max:2048',
            'testimoni_urutan' => 'nullable|integer',
        ]);
        $validated['testimoni_status'] = $request->has('testimoni_status') ? 1 : 0;
        if ($request->hasFile('testimoni_gambar')) {
            if ($testimonial->testimoni_gambar) {
                Storage::disk('public')->delete($testimonial->testimoni_gambar);
            }
            $validated['testimoni_gambar'] = $request->file('testimoni_gambar')->store('testimoni', 'public');
        }
        $testimonial->update($validated);
        return redirect()->route('testimonials.index')->with('success', 'Testimoni berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        if ($testimonial->testimoni_gambar) {
            Storage::disk('public')->delete($testimonial->testimoni_gambar);
        }
        $testimonial->delete();
        return redirect()->route('testimonials.index')->with('success', 'Testimoni berhasil dihapus.');
    }
}
