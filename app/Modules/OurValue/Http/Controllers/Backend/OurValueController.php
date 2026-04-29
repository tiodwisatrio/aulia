<?php

namespace App\Modules\OurValue\Http\Controllers\Backend;

use App\Modules\OurValue\Models\OurValue;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class OurValueController extends Controller
{
    public function index(Request $request)
    {
        $query = OurValue::latest();

        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('nilai_kami_nama', 'like', '%' . $request->search . '%')
                  ->orWhere('nilai_kami_deskripsi', 'like', '%' . $request->search . '%');
            });
        }

        $values = $query->paginate(10);
        return view('ourvalue::backend.index', compact('values'));
    }

    public function create()
    {
        return view('ourvalue::backend.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nilai_kami_nama'      => 'required|string|max:255',
            'nilai_kami_deskripsi' => 'nullable|string',
            'nilai_kami_gambar'    => 'nullable|image|max:2048',
            'nilai_kami_status'    => 'required|boolean',
            'nilai_kami_urutan'    => 'required|integer',
        ]);
        if ($request->hasFile('nilai_kami_gambar')) {
            $data['nilai_kami_gambar'] = $request->file('nilai_kami_gambar')->store('nilai-kami', 'public');
        }
        OurValue::create($data);
        return redirect()->route('ourvalues.index')->with('success', 'Nilai berhasil ditambahkan.');
    }

    public function show(OurValue $ourvalue)
    {
        return view('ourvalue::backend.show', compact('ourvalue'));
    }

    public function edit(OurValue $ourvalue)
    {
        return view('ourvalue::backend.edit', compact('ourvalue'));
    }

    public function update(Request $request, OurValue $ourvalue)
    {
        $data = $request->validate([
            'nilai_kami_nama'      => 'required|string|max:255',
            'nilai_kami_deskripsi' => 'nullable|string',
            'nilai_kami_gambar'    => 'nullable|image|max:2048',
            'nilai_kami_status'    => 'required|boolean',
            'nilai_kami_urutan'    => 'required|integer',
        ]);
        if ($request->hasFile('nilai_kami_gambar')) {
            if ($ourvalue->nilai_kami_gambar) {
                Storage::disk('public')->delete($ourvalue->nilai_kami_gambar);
            }
            $data['nilai_kami_gambar'] = $request->file('nilai_kami_gambar')->store('nilai-kami', 'public');
        }
        $ourvalue->update($data);
        return redirect()->route('ourvalues.index')->with('success', 'Nilai berhasil diperbarui.');
    }

    public function destroy(OurValue $ourvalue)
    {
        if ($ourvalue->nilai_kami_gambar) {
            Storage::disk('public')->delete($ourvalue->nilai_kami_gambar);
        }
        $ourvalue->delete();
        return redirect()->route('ourvalues.index')->with('success', 'Nilai berhasil dihapus.');
    }
}
