<?php

namespace App\Modules\FAQ\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\FAQ\Models\FAQ;

class FAQController extends Controller
{
    public function index(Request $request)
    {
        $query = FAQ::latest();

        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('faq_pertanyaan', 'like', '%' . $request->search . '%')
                  ->orWhere('faq_jawaban', 'like', '%' . $request->search . '%');
            });
        }

        $faqs = $query->paginate(10);
        return view('faq::backend.index', compact('faqs'));
    }

    public function create()
    {
        return view('faq::backend.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'faq_pertanyaan' => 'required|string|max:255',
            'faq_jawaban'    => 'required|string',
            'faq_status'     => 'required|in:0,1',
            'faq_urutan'     => 'nullable|integer',
        ]);

        $data = $request->only(['faq_pertanyaan', 'faq_jawaban', 'faq_status', 'faq_urutan']);

        FAQ::create($data);

        return redirect()->route('faqs.index')->with('success', 'FAQ berhasil ditambahkan.');
    }

    public function show(FAQ $faq)
    {
        return view('faq::backend.show', compact('faq'));
    }

    public function edit(FAQ $faq)
    {
        return view('faq::backend.edit', compact('faq'));
    }

    public function update(Request $request, FAQ $faq)
    {
        $request->validate([
            'faq_pertanyaan' => 'required|string|max:255',
            'faq_jawaban'    => 'required|string',
            'faq_status'     => 'required|in:0,1',
            'faq_urutan'     => 'nullable|integer',
        ]);

        $data = $request->only(['faq_pertanyaan', 'faq_jawaban', 'faq_status', 'faq_urutan']);

        $faq->update($data);

        return redirect()->route('faqs.index')->with('success', 'FAQ berhasil diperbarui.');
    }

    public function destroy(FAQ $faq)
    {
        $faq->delete();

        return redirect()->route('faqs.index')->with('success', 'FAQ berhasil dihapus.');
    }
}
