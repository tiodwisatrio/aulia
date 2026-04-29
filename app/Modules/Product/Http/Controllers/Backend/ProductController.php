<?php

namespace App\Modules\Product\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Modules\Product\Models\Product;
use App\Modules\Category\Models\Category;
use App\Modules\Product\Http\Requests\StoreProductRequest;
use App\Modules\Product\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'user']);

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('produk_nama', 'like', '%' . $request->search . '%')
                  ->orWhere('produk_sku', 'like', '%' . $request->search . '%')
                  ->orWhere('produk_deskripsi', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('category')) {
            $query->where('produk_kategori_id', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('produk_status', $request->status);
        }

        if ($request->filled('stock_status')) {
            switch ($request->stock_status) {
                case 'in_stock':
                    $query->inStock();
                    break;
                case 'low_stock':
                    $query->where('produk_pantau_stok', true)
                          ->whereColumn('produk_stok', '<=', 'produk_stok_minimum');
                    break;
                case 'out_of_stock':
                    $query->where('produk_pantau_stok', true)
                          ->where('produk_stok', '<=', 0);
                    break;
            }
        }

        if ($request->filled('featured')) {
            $query->where('produk_unggulan', $request->featured);
        }

        $products = $query->orderBy('created_at', 'desc')->paginate(10);
        $categories = Category::forProducts()->active()->ordered()->get();

        return view('product::backend.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::forProducts()->active()->ordered()->get();

        return view('product::backend.create', compact('categories'));
    }

    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('produk_gambar_utama')) {
            $validated['produk_gambar_utama'] = $request->file('produk_gambar_utama')
                ->store('products/images', 'public');
        }

        if ($request->hasFile('produk_galeri')) {
            $galeri = [];
            foreach ($request->file('produk_galeri') as $file) {
                $galeri[] = $file->store('products/gallery', 'public');
            }
            $validated['produk_galeri'] = $galeri;
        }

        if ($request->has('produk_spesifikasi')) {
            $specs = [];
            foreach ($request->produk_spesifikasi as $spec) {
                if (!empty($spec['key']) && !empty($spec['value'])) {
                    $specs[] = $spec;
                }
            }
            $validated['produk_spesifikasi'] = $specs;
        }

        if (empty($validated['produk_slug'])) {
            $validated['produk_slug'] = Str::slug($validated['produk_nama']);
        }

        $validated['produk_pengguna_id'] = Auth::id();

        Product::create($validated);

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil dibuat!');
    }

    public function show(Product $product)
    {
        $product->load(['category', 'user']);

        $product->increment('produk_jumlah_lihat');

        return view('product::backend.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::forProducts()->active()->ordered()->get();

        return view('product::backend.edit', compact('product', 'categories'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $validated = $request->validated();

        if ($request->has('remove_current_image') && $product->produk_gambar_utama) {
            Storage::disk('public')->delete($product->produk_gambar_utama);
            $validated['produk_gambar_utama'] = null;
        }

        if ($request->hasFile('produk_gambar_utama')) {
            if ($product->produk_gambar_utama && !$request->has('remove_current_image')) {
                Storage::disk('public')->delete($product->produk_gambar_utama);
            }
            $validated['produk_gambar_utama'] = $request->file('produk_gambar_utama')
                ->store('products/images', 'public');
        }

        $currentGallery = $product->produk_galeri ?: [];
        if ($request->has('remove_gallery_images')) {
            foreach ($request->input('remove_gallery_images', []) as $index) {
                if (isset($currentGallery[$index])) {
                    Storage::disk('public')->delete($currentGallery[$index]);
                    unset($currentGallery[$index]);
                }
            }
            $currentGallery = array_values($currentGallery);
            $validated['produk_galeri'] = $currentGallery;
        }

        if ($request->hasFile('produk_galeri')) {
            $newGaleri = [];
            foreach ($request->file('produk_galeri') as $file) {
                $newGaleri[] = $file->store('products/gallery', 'public');
            }
            $validated['produk_galeri'] = array_merge($currentGallery, $newGaleri);
        }

        if ($request->has('produk_spesifikasi')) {
            $specs = [];
            foreach ($request->produk_spesifikasi as $spec) {
                if (!empty($spec['key']) && !empty($spec['value'])) {
                    $specs[] = $spec;
                }
            }
            $validated['produk_spesifikasi'] = $specs;
        }

        $product->update($validated);

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        if ($product->produk_gambar_utama) {
            Storage::disk('public')->delete($product->produk_gambar_utama);
        }

        if ($product->produk_galeri) {
            foreach ($product->produk_galeri as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil dihapus!');
    }
}
