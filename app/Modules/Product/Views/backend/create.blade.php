@extends('core::dashboard-layout')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Buat Produk</h1>
            <p class="text-gray-600 mt-1">Tambahkan produk baru</p>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6">
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            {!! formField('produk_nama', 'text', 'Nama Produk', null, [], ['required' => true, 'placeholder' => 'Masukkan nama produk']) !!}

            {!! formField('produk_kategori_id', 'select', 'Kategori', null, $categories->pluck('kategori_nama', 'kategori_id')->toArray(), ['required' => true]) !!}

            <!-- Price Section -->
                {!! formField('produk_harga', 'number', 'Harga', null, [], ['required' => true, 'step' => '0.01', 'min' => '0', 'placeholder' => '0']) !!}
                <!-- {!! formField('produk_harga_diskon', 'number', 'Harga Diskon', null, [], ['step' => '0.01', 'min' => '0', 'placeholder' => '0']) !!} -->

            
            {!! formField('produk_gambar_utama', 'file', 'Gambar Utama', null, [], ['accept' => 'image/*']) !!}

            <!-- Ukuran & Origin -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                {!! formField('produk_ukuran', 'number', 'Ukuran (gram)', null, [], ['min' => '0', 'placeholder' => 'contoh: 200']) !!}
                {!! formField('produk_origin', 'text', 'Origin', null, [], ['placeholder' => 'contoh: Gayo, Aceh']) !!}
            </div>

            <!-- Ketinggian, Profile Roasting, Varietas, Process & Roast Date -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                {!! formField('produk_ketinggian', 'text', 'Ketinggian', null, [], ['placeholder' => 'contoh: 1200-1500 mdpl']) !!}
                {!! formField('produk_profile_roasting', 'text', 'Profile Roasting', null, [], ['placeholder' => 'contoh: Light Roast']) !!}
                {!! formField('produk_varietas', 'text', 'Varietas', null, [], ['placeholder' => 'contoh: Typica, Mix Varietas']) !!}
                {!! formField('produk_process', 'text', 'Process', null, [], ['placeholder' => 'contoh: Natural, Washed, Honey']) !!}
                {!! formField('produk_roast_date', 'date', 'Roast Date', null, [], []) !!}
            </div>


            {!! formField('produk_deskripsi', 'textarea', 'Deskripsi', null, [], ['rows' => 5, 'placeholder' => 'Masukkan deskripsi produk']) !!}
            {!! formField('produk_status', 'select', 'Status', 'aktif', ['aktif' => 'Aktif', 'nonaktif' => 'Nonaktif'], ['required' => true]) !!}


            <!-- Buttons -->
            <div class="flex gap-4 pt-4">
                <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                    Simpan Produk
                </button>
                <a href="{{ route('products.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-900 px-6 py-2 rounded-lg font-semibold transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
