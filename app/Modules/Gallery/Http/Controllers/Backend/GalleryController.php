<?php
namespace App\Modules\Gallery\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Modules\Gallery\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $query = Gallery::latest();

        if ($request->filled('search')) {
            $query->where('gallery_name', 'like', '%' . $request->search . '%');
        }

        $galleries = $query->paginate(10);
        return view('gallery::backend.index', compact('galleries'));
    }

    public function create()
    {
        return view('gallery::backend.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'gallery_name'     => 'required|max:255',
            'gallery_image' => 'nullable',
            'gallery_order'    => 'nullable|integer',
        ]);

        $data = $request->only([
            'gallery_name', 'gallery_image',
            'gallery_status', 'gallery_order',
        ]);

        if ($request->hasFile('gallery_image')) {
            $data['gallery_image'] = $request->file('gallery_image')
                ->store('uploads/gallery', 'public');
        }

        Gallery::create($data);

        return redirect()->route('galleries.index')
            ->with('success', 'Gallery berhasil ditambahkan.');
    }

    public function show(Gallery $gallery)
    {
        return view('gallery::backend.show', compact('gallery'));
    }

    public function edit(Gallery $gallery)
    {
        return view('gallery::backend.edit', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'gallery_name'     => 'required|max:255',
            'gallery_image' => 'nullable',
            'gallery_order'    => 'nullable|integer',
        ]);

        $data = $request->only([
            'gallery_name', 'gallery_image',
            'gallery_status', 'gallery_order',
        ]);

        if ($request->hasFile('gallery_image')) {
            // Hapus gambar lama sebelum simpan yang baru
            if ($gallery->gallery_image) {
                Storage::disk('public')->delete($gallery->gallery_image);
            }
            $data['gallery_image'] = $request->file('gallery_image')
                ->store('uploads/gallery', 'public');
        }

        $gallery->update($data);

        return redirect()->route('galleries.index')
            ->with('success', 'Gallery berhasil diperbarui.');
    }

    public function destroy(Gallery $gallery)
    {
        if ($gallery->gallery_image) {
            Storage::disk('public')->delete($gallery->gallery_image);
        }

        $gallery->delete();

        return redirect()->route('galleries.index')
            ->with('success', 'Gallery berhasil dihapus.');
    }
}