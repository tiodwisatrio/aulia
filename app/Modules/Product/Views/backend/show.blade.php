@extends('core::dashboard-layout')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ $product->produk_nama }}</h1>
            <p class="text-gray-600 mt-1">{{ $product->created_at->format('d M Y H:i') }}</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('products.edit', $product) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                Edit
            </a>
            <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg font-semibold transition" onclick="return confirm('Yakin ingin menghapus?')">
                    Hapus
                </button>
            </form>
        </div>
    </div>

    <!-- Content -->
    <div class="grid grid-cols-3 gap-6">
        <div class="col-span-2 space-y-6">
            <!-- Gambar -->
            @if($product->produk_gambar)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <img src="{{ asset('storage/' . $product->produk_gambar) }}" alt="{{ $product->produk_nama }}" class="w-full h-96 object-cover">
            </div>
            @endif

            <!-- Deskripsi -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                <h3 class="font-semibold text-gray-900 mb-4">Deskripsi</h3>
                <div class="prose max-w-none">
                    {!! nl2br(e($product->produk_deskripsi)) !!}
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Meta Info -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Informasi</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-gray-600 font-semibold">KATEGORI</p>
                        <p class="text-gray-900">{{ $product->category?->kategori_nama ?? 'Tidak ada' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600 font-semibold">SKU</p>
                        <p class="text-gray-900">{{ $product->produk_sku ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600 font-semibold">HARGA</p>
                        <p class="text-gray-900 font-semibold">Rp {{ number_format($product->produk_harga, 0, ',', '.') }}</p>
                    </div>
                    @if($product->produk_harga_diskon)
                    <div>
                        <p class="text-xs text-gray-600 font-semibold">HARGA DISKON</p>
                        <p class="text-gray-900 font-semibold">Rp {{ number_format($product->produk_harga_diskon, 0, ',', '.') }}</p>
                    </div>
                    @endif
                    <div>
                        <p class="text-xs text-gray-600 font-semibold">STOK</p>
                        <p class="text-gray-900">{{ $product->produk_stok }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600 font-semibold">STATUS</p>
                        <span class="text-xs font-semibold px-3 py-1 rounded-full
                            @if($product->produk_status === 'aktif') bg-green-100 text-green-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ $product->produk_status === 'aktif' ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600 font-semibold">UNGGULAN</p>
                        <p class="text-gray-900">{{ $product->produk_unggulan ? 'Ya' : 'Tidak' }}</p>
                    </div>
                </div>
            </div>

            <!-- Dates -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Timeline</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-gray-600 font-semibold">DIBUAT</p>
                        <p class="text-gray-900">{{ $product->created_at->format('d M Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600 font-semibold">DIPERBARUI</p>
                        <p class="text-gray-900">{{ $product->updated_at->format('d M Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Back Button -->
    <div>
        <a href="{{ route('products.index') }}" class="text-teal-600 hover:text-teal-900 font-semibold">
            ← Kembali ke Produk
        </a>
    </div>
</div>
@endsection
