<?php

namespace App\Modules\Catalog\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Catalog\Models\Catalog;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Catalog::latest();

        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('katalog_judul', 'like', '%' . $request->search . '%')
                  ->orWhere('katalog_deskripsi', 'like', '%' . $request->search . '%');
            });
        }

        $catalogs = $query->paginate(10);
        return view('catalog::backend.index', compact('catalogs'));
    }

    public function create()
    {
        return view('catalog::backend.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'katalog_judul'     => 'required|string|max:255',
            'katalog_deskripsi' => 'nullable|string',
            'katalog_gambar'    => 'nullable|string|max:255',
            'katalog_status'    => 'required|in:0,1',
            'katalog_urutan'    => 'nullable|integer',
        ]);

        $data = $request->only(['katalog_judul', 'katalog_deskripsi', 'katalog_gambar', 'katalog_status', 'katalog_urutan']);

        Catalog::create($data);

        return redirect()->route('catalogs.index')->with('success', 'Katalog berhasil ditambahkan.');
    }

    public function show(Catalog $catalog)
    {
        return view('catalog::backend.show', compact('catalog'));
    }

    public function edit(Catalog $catalog)
    {
        return view('catalog::backend.edit', compact('catalog'));
    }

    public function update(Request $request, Catalog $catalog)
    {
        $request->validate([
            'katalog_judul'     => 'required|string|max:255',
            'katalog_deskripsi' => 'nullable|string',
            'katalog_gambar'    => 'nullable|string|max:255',
            'katalog_status'    => 'required|in:0,1',
            'katalog_urutan'    => 'nullable|integer',
        ]);

        $data = $request->only(['katalog_judul', 'katalog_deskripsi', 'katalog_gambar', 'katalog_status', 'katalog_urutan']);

        $catalog->update($data);

        return redirect()->route('catalogs.index')->with('success', 'Katalog berhasil diperbarui.');
    }

    public function destroy(Catalog $catalog)
    {
        $catalog->delete();

        return redirect()->route('catalogs.index')->with('success', 'Katalog berhasil dihapus.');
    }
}
