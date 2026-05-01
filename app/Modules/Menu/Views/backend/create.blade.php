@extends('core::dashboard-layout')
@section('header', 'Tambah Menu')
@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Tambah Menu</h1>
            <p class="text-gray-500 text-sm mt-0.5">Buat item menu baru</p>
        </div>
        <a href="{{ route('menus.index') }}" class="text-sm text-gray-500 hover:text-gray-800 font-medium">
            ← Kembali
        </a>
    </div>

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg text-sm">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6">
        <form action="{{ route('menus.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            {{-- Nama & Kategori --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Menu <span class="text-red-500">*</span></label>
                    <input type="text" name="menu_nama" value="{{ old('menu_nama') }}"
                           placeholder="Masukkan nama menu"
                           class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 @error('menu_nama') border-red-500 @enderror">
                    @error('menu_nama') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kategori <span class="text-red-500">*</span></label>
                    <select name="menu_kategori_id"
                            class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 @error('menu_kategori_id') border-red-500 @enderror">
                        <option value="">— Pilih Kategori —</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->kategori_id }}" {{ old('menu_kategori_id') == $cat->kategori_id ? 'selected' : '' }}>
                                {{ $cat->kategori_nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('menu_kategori_id') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Harga & Status --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Harga (¥)</label>
                    <input type="number" name="menu_harga" value="{{ old('menu_harga') }}"
                           placeholder="0" min="0" step="1"
                           class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 @error('menu_harga') border-red-500 @enderror">
                    @error('menu_harga') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Status <span class="text-red-500">*</span></label>
                    <select name="menu_status"
                            class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 @error('menu_status') border-red-500 @enderror">
                        <option value="aktif" {{ old('menu_status', 'aktif') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="tidak aktif" {{ old('menu_status') === 'tidak aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                    @error('menu_status') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Deskripsi --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Deskripsi</label>
                <textarea name="menu_deskripsi" rows="4"
                          placeholder="Masukkan deskripsi menu..."
                          class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 @error('menu_deskripsi') border-red-500 @enderror">{{ old('menu_deskripsi') }}</textarea>
                @error('menu_deskripsi') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Gambar --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Gambar</label>
                <input type="file" name="menu_image" accept="image/*"
                       class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 @error('menu_image') border-red-500 @enderror">
                <p class="text-xs text-gray-400 mt-1">Format: jpeg, png, jpg, gif, webp. Maks 2MB.</p>
                @error('menu_image') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>


            {{-- Buttons --}}
            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2.5 rounded-lg text-sm font-semibold transition">
                    Simpan Menu
                </button>
                <a href="{{ route('menus.index') }}"
                   class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2.5 rounded-lg text-sm font-semibold transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
