<?php
namespace App\Modules\About\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Modules\About\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
    public function index(Request $request)
    {
        $query = About::latest();

        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('tentang_judul', 'like', '%' . $request->search . '%')
                  ->orWhere('tentang_konten', 'like', '%' . $request->search . '%');
            });
        }

        $abouts = $query->paginate(10);
        return view('about::backend.index', compact('abouts'));
    }

    public function create()
    {
        return view('about::backend.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tentang_judul'              => 'required',
            'tentang_konten'             => 'required',
            'tentang_status'             => 'required|in:0,1',
            'tentang_gambar'             => 'nullable|image|max:2048',
            'tentang_jumlah_origin'      => 'nullable|string|max:50',
            'tentang_jumlah_pelanggan'   => 'nullable|string|max:50',
            'tentang_jumlah_fresh_roast' => 'nullable|string|max:50',
            'tentang_tahun_berdiri'      => 'nullable|string|max:50',
        ]);

        $gambar = $request->file('tentang_gambar') ? $request->file('tentang_gambar')->store('tentang', 'public') : null;

        About::create([
            'tentang_judul'              => $request->input('tentang_judul'),
            'tentang_konten'             => $request->input('tentang_konten'),
            'tentang_status'             => $request->input('tentang_status'),
            'tentang_gambar'             => $gambar,
            'tentang_jumlah_origin'      => $request->input('tentang_jumlah_origin'),
            'tentang_jumlah_pelanggan'   => $request->input('tentang_jumlah_pelanggan'),
            'tentang_jumlah_fresh_roast' => $request->input('tentang_jumlah_fresh_roast'),
            'tentang_tahun_berdiri'      => $request->input('tentang_tahun_berdiri'),
        ]);

        return redirect()->route('abouts.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function show(About $about)
    {
        return view('about::backend.show', compact('about'));
    }

    public function edit(About $about)
    {
        return view('about::backend.edit', compact('about'));
    }

    public function update(Request $request, About $about)
    {
        $request->validate([
            'tentang_judul'              => 'required',
            'tentang_konten'             => 'required',
            'tentang_status'             => 'required|in:0,1',
            'tentang_gambar'             => 'nullable|image|max:2048',
            'tentang_jumlah_origin'      => 'nullable|string|max:50',
            'tentang_jumlah_pelanggan'   => 'nullable|string|max:50',
            'tentang_jumlah_fresh_roast' => 'nullable|string|max:50',
            'tentang_tahun_berdiri'      => 'nullable|string|max:50',
        ]);

        $data = $request->only([
            'tentang_judul',
            'tentang_konten',
            'tentang_status',
            'tentang_jumlah_origin',
            'tentang_jumlah_pelanggan',
            'tentang_jumlah_fresh_roast',
            'tentang_tahun_berdiri',
        ]);

        if ($request->file('tentang_gambar')) {
            if ($about->tentang_gambar) {
                Storage::disk('public')->delete($about->tentang_gambar);
            }
            $data['tentang_gambar'] = $request->file('tentang_gambar')->store('tentang', 'public');
        }

        $about->update($data);

        return redirect()->route('abouts.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(About $about)
    {
        if ($about->tentang_gambar) {
            Storage::disk('public')->delete($about->tentang_gambar);
        }

        $about->delete();
        return redirect()->route('abouts.index')->with('success', 'Data berhasil dihapus.');
    }
}
