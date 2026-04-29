<?php

namespace App\Modules\Product\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Modules\Product\Models\Product;
use App\Modules\Category\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['user', 'category'])
                        ->where('produk_status', 'aktif');

        if ($request->has('search') && $request->search != '') {
            $query->where(function ($q) use ($request) {
                $q->where('produk_nama', 'like', '%' . $request->search . '%')
                  ->orWhere('produk_deskripsi', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('category') && $request->category != '') {
            $query->where('produk_kategori_id', $request->category);
        }

        if ($request->has('origin') && $request->origin != '') {
            $query->where('produk_origin', $request->origin);
        }

        if ($request->has('min_price') && $request->min_price != '') {
            $query->where('produk_harga', '>=', $request->min_price);
        }

        if ($request->has('max_price') && $request->max_price != '') {
            $query->where('produk_harga', '<=', $request->max_price);
        }

        switch ($request->sort) {
            case 'price_low':
                $query->orderBy('produk_harga', 'asc');
                break;
            case 'price_high':
                $query->orderBy('produk_harga', 'desc');
                break;
            case 'name':
                $query->orderBy('produk_nama', 'asc');
                break;
            default:
                $query->latest();
        }

        $products = $query->paginate(12);

        $categories = Category::whereHas('products', function ($query) {
            $query->where('produk_status', 'aktif');
        })->where('kategori_tipe', 'product')->get();

        $origins = Product::where('produk_status', 'aktif')
                          ->whereNotNull('produk_origin')
                          ->where('produk_origin', '!=', '')
                          ->distinct()
                          ->pluck('produk_origin')
                          ->sort()
                          ->values();

        return view('product::frontend.index', compact('products', 'categories', 'origins'));
    }

    public function show(Product $product)
    {
        $product->load(['category']);

        $relatedProducts = Product::with(['category'])
                                  ->where('produk_id', '!=', $product->produk_id)
                                  ->where('produk_status', 'aktif')
                                  ->orderByRaw('produk_kategori_id = ? DESC', [$product->produk_kategori_id])
                                  ->latest()
                                  ->limit(4)
                                  ->get();

        return view('product::frontend.show', compact('product', 'relatedProducts'));
    }

    public function cart()
    {
        return view('product::frontend.cart');
    }
}
