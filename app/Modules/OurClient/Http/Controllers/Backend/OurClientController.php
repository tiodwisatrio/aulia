<?php
namespace App\Modules\OurClient\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Modules\OurClient\Models\OurClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OurClientController extends Controller
{
    public function index(Request $request)
    {
        $query = OurClient::latest();

        if ($request->has('search') && $request->search) {
            $query->where('klien_nama', 'like', '%' . $request->search . '%');
        }

        $clients = $query->paginate(10);
        return view('ourclient::backend.index', compact('clients'));
    }

    public function create()
    {
        return view('ourclient::backend.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'klien_nama'   => 'required|string|max:191',
            'klien_gambar' => 'nullable|image|max:2048',
            'klien_status' => 'nullable|boolean',
            'klien_urutan' => 'nullable|integer',
        ]);

        $data = $request->only(['klien_nama', 'klien_urutan']);
        $data['klien_status'] = $request->has('klien_status') ? 1 : 0;

        if ($request->hasFile('klien_gambar')) {
            $data['klien_gambar'] = $request->file('klien_gambar')->store('klien', 'public');
        }

        OurClient::create($data);
        return redirect()->route('ourclient.index')->with('success', 'Klien berhasil ditambahkan.');
    }

    public function show(OurClient $ourclient)
    {
        return view('ourclient::backend.show', compact('ourclient'));
    }

    public function edit(OurClient $ourclient)
    {
        return view('ourclient::backend.edit', compact('ourclient'));
    }

    public function update(Request $request, OurClient $ourclient)
    {
        $request->validate([
            'klien_nama'   => 'required|string|max:191',
            'klien_gambar' => 'nullable|image|max:2048',
            'klien_status' => 'nullable|boolean',
            'klien_urutan' => 'nullable|integer',
        ]);

        $data = $request->only(['klien_nama', 'klien_urutan']);
        $data['klien_status'] = $request->has('klien_status') ? 1 : 0;

        if ($request->hasFile('klien_gambar')) {
            if ($ourclient->klien_gambar) {
                Storage::disk('public')->delete($ourclient->klien_gambar);
            }
            $data['klien_gambar'] = $request->file('klien_gambar')->store('klien', 'public');
        }

        $ourclient->update($data);
        return redirect()->route('ourclient.index')->with('success', 'Klien berhasil diperbarui.');
    }

    public function destroy(OurClient $ourclient)
    {
        if ($ourclient->klien_gambar) {
            Storage::disk('public')->delete($ourclient->klien_gambar);
        }
        $ourclient->delete();

        return redirect()->route('ourclient.index')->with('success', 'Klien berhasil dihapus.');
    }
}
