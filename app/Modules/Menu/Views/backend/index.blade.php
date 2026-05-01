@extends('core::dashboard-layout')
@section('header', 'Menu')
@section('content')
<div class="space-y-4">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Menu</h1>
            <p class="text-gray-500 text-sm mt-0.5">Kelola semua menu</p>
        </div>
        <a href="{{ route('menus.create') }}"
           class="inline-flex items-center gap-2 bg-teal-600 hover:bg-teal-700 text-white px-4 py-2.5 rounded-lg text-sm font-semibold transition self-start sm:self-auto">
            <i data-lucide="plus" class="w-4 h-4"></i> Tambah Menu
        </a>
    </div>

    {{-- Filter & Search --}}
    <form method="GET" action="{{ route('menus.index') }}" class="flex flex-wrap gap-2">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Cari menu..."
               class="flex-1 min-w-[180px] px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
        <select name="category" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
            <option value="">Semua Kategori</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->kategori_id }}" {{ request('category') == $cat->kategori_id ? 'selected' : '' }}>
                    {{ $cat->kategori_nama }}
                </option>
            @endforeach
        </select>
        <select name="status" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
            <option value="">Semua Status</option>
            <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
            <option value="tidak aktif" {{ request('status') === 'tidak aktif' ? 'selected' : '' }}>Tidak Aktif</option>
        </select>
        <button type="submit"
                class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
            Cari
        </button>
        @if(request()->hasAny(['search', 'category', 'status']))
            <a href="{{ route('menus.index') }}"
               class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-semibold transition">
                Reset
            </a>
        @endif
    </form>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[540px]">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wide w-16">Gambar</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wide">Nama</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wide hidden sm:table-cell">Kategori</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wide">Harga</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wide">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wide">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($menus as $menu)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3">
                            @if($menu->menu_image)
                                <img src="{{ asset('storage/' . $menu->menu_image) }}" alt="{{ $menu->menu_nama }}"
                                     class="w-10 h-10 rounded-lg object-cover">
                            @else
                                <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center">
                                    <i data-lucide="utensils" class="w-4 h-4 text-gray-400"></i>
                                </div>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <p class="text-sm font-medium text-gray-900">{{ $menu->menu_nama }}</p>
                            @if($menu->menu_deskripsi)
                                <p class="text-xs text-gray-400 mt-0.5 truncate max-w-[200px]">{{ $menu->menu_deskripsi }}</p>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600 hidden sm:table-cell">
                            {{ $menu->category?->kategori_nama ?? '-' }}
                        </td>
                        <td class="px-4 py-3 text-sm font-semibold text-gray-800 whitespace-nowrap">
                            {{ formatYen($menu->menu_harga) }}
                        </td>
                        <td class="px-4 py-3">
                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full whitespace-nowrap
                                {{ $menu->menu_status === 'aktif' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                                {{ $menu->menu_status === 'aktif' ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex gap-2 items-center">
                                <a href="{{ route('menus.show', $menu) }}" class="text-gray-400 hover:text-gray-700 p-1" title="Detail">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </a>
                                <a href="{{ route('menus.edit', $menu) }}" class="text-blue-500 hover:text-blue-800 p-1" title="Edit">
                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                </a>
                                <form action="{{ route('menus.destroy', $menu) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Yakin hapus {{ addslashes($menu->menu_nama) }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-800 p-1" title="Hapus">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-12 text-center text-sm text-gray-500">
                            Belum ada menu.
                            <a href="{{ route('menus.create') }}" class="text-teal-600 font-semibold">Buat yang pertama</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="flex justify-center">{{ $menus->links() }}</div>
</div>
@endsection
