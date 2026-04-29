@extends('core::dashboard-layout')
@section('header', 'Gallery')
@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between gap-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Gallery</h1>
            <p class="text-gray-600 mt-1">Kelola semua gallery</p>
            <div class="mt-4">
                <a href="{{ route('galleries.create') }}"
                   class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded-lg font-semibold transition inline-block">
                    + Tambah Gallery
                </a>
            </div>
        </div>
        <form method="GET" action="{{ route('galleries.index') }}" class="flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari gallery..."
                   class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
            <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded-lg font-semibold transition">Cari</button>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Nama</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Foto</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Status</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($galleries as $gallery)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4text-gray-900">{{ $gallery->gallery_name }}</td>
                    <!-- gallery_image -->
                    <td class="px-6 py-4">
                        @if($gallery->gallery_image)
                            <img src="{{ asset('storage/' . $gallery->gallery_image) }}" alt="{{ $gallery->gallery_name }}" class="w-16 h-16 object-cover rounded">
                        @else
                            <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center text-gray-500">
                                <i data-lucide="image" class="w-6 h-6"></i>
                            </div>
                        @endif
                    <td class="px-6 py-4">
                        <span class="text-xs font-semibold px-3 py-1 rounded-full
                            {{ $gallery->gallery_status ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                            {{ $gallery->gallery_status ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex gap-3 items-center">
                            <a href="{{ route('galleries.show', $gallery) }}" class="text-gray-500 hover:text-gray-800" title="Lihat">
                                <i data-lucide="eye" class="w-4 h-4"></i>
                            </a>
                            <a href="{{ route('galleries.edit', $gallery) }}" class="text-blue-500 hover:text-blue-800" title="Edit">
                                <i data-lucide="pencil" class="w-4 h-4"></i>
                            </a>
                            <form action="{{ route('galleries.destroy', $gallery) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Hapus {{ $gallery->gallery_name }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-800" title="Hapus">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                        Belum ada gallery.
                        <a href="{{ route('galleries.create') }}" class="text-teal-600 font-semibold">Buat yang pertama</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="flex justify-center">{{ $galleries->links() }}</div>
</div>
@endsection