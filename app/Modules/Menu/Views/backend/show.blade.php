@extends('core::dashboard-layout')
@section('header', 'Detail Menu')
@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $menu->menu_nama }}</h1>
            <p class="text-gray-500 text-sm mt-0.5">Dibuat {{ $menu->created_at->format('d M Y H:i') }}</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('menus.edit', $menu) }}"
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                Edit
            </a>
            <form action="{{ route('menus.destroy', $menu) }}" method="POST" class="inline"
                  onsubmit="return confirm('Yakin ingin menghapus menu ini?')">
                @csrf @method('DELETE')
                <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                    Hapus
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Kiri: Gambar + Deskripsi --}}
        <div class="lg:col-span-2 space-y-6">

            @if($menu->menu_image)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <img src="{{ asset('storage/' . $menu->menu_image) }}" alt="{{ $menu->menu_nama }}"
                     class="w-full h-72 object-cover">
            </div>
            @endif

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-900 mb-3">Deskripsi</h3>
                <p class="text-sm text-gray-600 leading-relaxed">
                    {{ $menu->menu_deskripsi ?? 'Tidak ada deskripsi.' }}
                </p>
            </div>
        </div>

        {{-- Kanan: Info --}}
        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Informasi</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-gray-500 font-semibold uppercase tracking-wide">Kategori</p>
                        <p class="text-sm text-gray-900 mt-0.5">{{ $menu->category?->kategori_nama ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-semibold uppercase tracking-wide">Harga</p>
                        <p class="text-sm text-gray-900 font-semibold mt-0.5">
                            {{ formatYen($menu->menu_harga) }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-semibold uppercase tracking-wide">Status</p>
                        <span class="inline-block mt-1 text-xs font-semibold px-2.5 py-1 rounded-full
                            {{ $menu->menu_status === 'aktif' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                            {{ $menu->menu_status === 'aktif' ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-semibold uppercase tracking-wide">Slug</p>
                        <p class="text-sm text-gray-900 font-mono mt-0.5">{{ $menu->menu_slug ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Timeline</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-gray-500 font-semibold uppercase tracking-wide">Dibuat</p>
                        <p class="text-sm text-gray-900 mt-0.5">{{ $menu->created_at->format('d M Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-semibold uppercase tracking-wide">Diperbarui</p>
                        <p class="text-sm text-gray-900 mt-0.5">{{ $menu->updated_at->format('d M Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <a href="{{ route('menus.index') }}" class="inline-block text-sm text-teal-600 hover:text-teal-900 font-semibold">
        ← Kembali ke Menu
    </a>
</div>
@endsection
