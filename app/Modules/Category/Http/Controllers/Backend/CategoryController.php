<?php

namespace App\Modules\Category\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Modules\Category\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->input('type', 'post');

        $query = Category::query()->where('kategori_tipe', $type);

        if ($request->filled('status')) {
            $query->where('kategori_aktif', $request->status === 'active' ? 1 : 0);
        }

        if ($request->filled('search')) {
            $query->where('kategori_nama', 'like', "%{$request->search}%");
        }

        $categories = $query->orderBy('kategori_urutan')->paginate(15);

        return view('category::backend.index', compact('categories', 'type'));
    }

    public function create(Request $request)
    {
        $type = $request->input('type', 'post');
        return view('category::backend.create', compact('type'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_nama'      => 'required|string|max:255',
            'kategori_tipe'      => 'required|in:post,product,portfolio,team,general,menu',
            'kategori_slug'      => 'nullable|string|max:255|unique:kategori,kategori_slug',
            'kategori_deskripsi' => 'nullable|string',
            'kategori_warna'     => 'nullable|string|max:7',
            'kategori_ikon'      => 'nullable|string|max:50',
            'kategori_aktif'     => 'boolean',
            'kategori_urutan'    => 'nullable|integer|min:0',
        ]);

        $validated['kategori_aktif']  = $request->has('kategori_aktif');
        $validated['kategori_urutan'] = $validated['kategori_urutan'] ?? 0;

        Category::create($validated);

        return redirect()->route('categories.index', ['type' => $validated['kategori_tipe']])
                         ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function show(Category $category)
    {
        return view('category::backend.show', compact('category'));
    }

    public function edit(Category $category)
    {
        return view('category::backend.edit', ['category' => $category]);
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'kategori_nama'      => 'required|string|max:255',
            'kategori_tipe'      => 'required|in:post,product,portfolio,team,general,menu',
            'kategori_slug'      => 'nullable|string|max:255|unique:kategori,kategori_slug,' . $category->kategori_id . ',kategori_id',
            'kategori_deskripsi' => 'nullable|string',
            'kategori_warna'     => 'nullable|string|max:7',
            'kategori_ikon'      => 'nullable|string|max:50',
            'kategori_aktif'     => 'boolean',
            'kategori_urutan'    => 'nullable|integer|min:0',
        ]);

        $validated['kategori_aktif']  = $request->has('kategori_aktif');
        $validated['kategori_urutan'] = $validated['kategori_urutan'] ?? $category->kategori_urutan;

        $category->update($validated);

        return redirect()->route('categories.index', ['type' => $validated['kategori_tipe']])
                         ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        if ($category->posts()->count() > 0 || $category->products()->count() > 0 || $category->menus()->count() > 0) {
            return redirect()->route('categories.index', ['type' => $category->kategori_tipe])
                             ->with('error', 'Tidak bisa menghapus kategori karena masih memiliki data.');
        }

        $category->delete();

        return redirect()->route('categories.index', ['type' => $category->kategori_tipe])
                         ->with('success', 'Kategori berhasil dihapus.');
    }
}
