@extends('core::dashboard-layout')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Edit Produk</h1>
            <p class="text-gray-600 mt-1">{{ $product->produk_nama }}</p>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6">
        <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            {!! formField('produk_nama', 'text', 'Nama Produk', $product->produk_nama, [], ['required' => true, 'placeholder' => 'Masukkan nama produk']) !!}

            {!! formField('produk_kategori_id', 'select', 'Kategori', $product->produk_kategori_id, $categories->pluck('kategori_nama', 'kategori_id')->toArray(), ['required' => true]) !!}

            <!-- Price Section -->
            {!! formField('produk_harga', 'number', 'Harga', $product->produk_harga, [], ['required' => true, 'step' => '0.01', 'min' => '0']) !!}


            <!-- Gambar -->
            <div>
                <label class="block text-sm font-semibold text-gray-900 mb-2">Gambar Utama</label>
                @if($product->produk_gambar_utama)
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $product->produk_gambar_utama) }}" alt="{{ $product->produk_nama }}" class="h-32 w-auto rounded-lg">
                        <p class="text-xs text-gray-600 mt-2">Gambar saat ini</p>
                    </div>
                @endif
                <input type="file" name="produk_gambar_utama" accept="image/*"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 @error('produk_gambar_utama') border-red-500 @enderror">
                @error('produk_gambar_utama')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Ukuran & Origin -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                {!! formField('produk_ukuran', 'number', 'Ukuran (gram)', $product->produk_ukuran, [], ['min' => '0', 'placeholder' => 'contoh: 200']) !!}
                {!! formField('produk_origin', 'text', 'Origin', $product->produk_origin, [], ['placeholder' => 'contoh: Gayo, Aceh']) !!}
            </div>

            <!-- Ketinggian, Profile Roasting, Varietas, Process & Roast Date -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                {!! formField('produk_ketinggian', 'text', 'Ketinggian', $product->produk_ketinggian, [], ['placeholder' => 'contoh: 1200-1500 mdpl']) !!}
                {!! formField('produk_profile_roasting', 'text', 'Profile Roasting', $product->produk_profile_roasting, [], ['placeholder' => 'contoh: Light Roast']) !!}
                {!! formField('produk_varietas', 'text', 'Varietas', $product->produk_varietas, [], ['placeholder' => 'contoh: Arabika, Robusta']) !!}
                {!! formField('produk_process', 'text', 'Process', $product->produk_process, [], ['placeholder' => 'contoh: Natural, Washed, Honey']) !!}
                {!! formField('produk_roast_date', 'date', 'Roast Date', $product->produk_roast_date?->format('Y-m-d'), [], []) !!}
            </div>

            {!! formField('produk_deskripsi', 'textarea', 'Deskripsi', $product->produk_deskripsi, [], ['rows' => 5, 'placeholder' => 'Masukkan deskripsi produk']) !!}
            {!! formField('produk_status', 'select', 'Status', $product->produk_status, ['aktif' => 'Aktif', 'nonaktif' => 'Nonaktif'], ['required' => true]) !!}

            <!-- Buttons -->
            <div class="flex gap-4 pt-4">
                <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                    Perbarui Produk
                </button>
                <a href="{{ route('products.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-900 px-6 py-2 rounded-lg font-semibold transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
