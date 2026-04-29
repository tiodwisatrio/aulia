<?php
namespace App\Modules\WhyChooseUs\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\WhyChooseUs\Models\WhyChooseUs;
use Illuminate\Support\Facades\Storage;

class WhyChooseUsController extends Controller
{
    public function index(Request $request)
    {
        $query = WhyChooseUs::latest();

        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('mengapa_kami_judul', 'like', '%' . $request->search . '%')
                  ->orWhere('mengapa_kami_deskripsi', 'like', '%' . $request->search . '%');
            });
        }

        $items = $query->paginate(10);
        return view('whychooseus::backend.index', compact('items'));
    }

    public function create()
    {
        return view('whychooseus::backend.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'mengapa_kami_judul'     => 'required|string|max:255',
            'mengapa_kami_deskripsi' => 'nullable|string',
            'mengapa_kami_gambar'    => 'nullable|image|max:2048',
            'mengapa_kami_status'    => 'required|in:0,1',
        ]);
        if ($request->hasFile('mengapa_kami_gambar')) {
            $data['mengapa_kami_gambar'] = $request->file('mengapa_kami_gambar')->store('mengapa-kami', 'public');
        }
        WhyChooseUs::create($data);
        return redirect()->route('whychooseus.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function show(WhyChooseUs $whychooseus)
    {
        return view('whychooseus::backend.show', compact('whychooseus'));
    }

    public function edit(WhyChooseUs $whychooseus)
    {
        return view('whychooseus::backend.edit', compact('whychooseus'));
    }

    public function update(Request $request, WhyChooseUs $whychooseus)
    {
        $data = $request->validate([
            'mengapa_kami_judul'     => 'required|string|max:255',
            'mengapa_kami_deskripsi' => 'nullable|string',
            'mengapa_kami_gambar'    => 'nullable|image|max:2048',
            'mengapa_kami_status'    => 'required|in:0,1',
        ]);
        if ($request->hasFile('mengapa_kami_gambar')) {
            if ($whychooseus->mengapa_kami_gambar) {
                Storage::disk('public')->delete($whychooseus->mengapa_kami_gambar);
            }
            $data['mengapa_kami_gambar'] = $request->file('mengapa_kami_gambar')->store('mengapa-kami', 'public');
        }
        $whychooseus->update($data);
        return redirect()->route('whychooseus.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(WhyChooseUs $whychooseus)
    {
        if ($whychooseus->mengapa_kami_gambar) {
            Storage::disk('public')->delete($whychooseus->mengapa_kami_gambar);
        }
        $whychooseus->delete();
        return redirect()->route('whychooseus.index')->with('success', 'Data berhasil dihapus.');
    }
}
