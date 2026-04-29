@extends('core::dashboard-layout')
@section('header', 'Hero')
@section('content')
<div class="space-y-4">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Hero</h1>
            <p class="text-gray-500 text-sm mt-0.5">Kelola banner utama halaman</p>
        </div>
        <a href="{{ route('heroes.create') }}"
           class="inline-flex items-center gap-2 bg-teal-600 hover:bg-teal-700 text-white px-4 py-2.5 rounded-lg text-sm font-semibold transition self-start sm:self-auto">
            <i data-lucide="plus" class="w-4 h-4"></i> Tambah Hero
        </a>
    </div>

    <!-- Search -->
    <form method="GET" action="{{ route('heroes.index') }}" class="flex gap-2">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Cari hero..."
               class="flex-1 min-w-0 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
        <button type="submit"
                class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition whitespace-nowrap">
            Cari
        </button>
    </form>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[480px]">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wide">Judul</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wide hidden sm:table-cell">Deskripsi</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wide">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wide">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($heroes as $hero)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $hero->hero_title }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600 hidden sm:table-cell">{{ Str::limit($hero->hero_keterangan, 50) }}</td>
                        <td class="px-4 py-3">
                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full
                                {{ $hero->hero_status ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                                {{ $hero->hero_status ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex gap-3 items-center">
                                <a href="{{ route('heroes.edit', $hero) }}" class="text-blue-500 hover:text-blue-800 p-1">
                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                </a>
                                <form action="{{ route('heroes.destroy', $hero) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Hapus {{ $hero->hero_title }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-800 p-1">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-4 py-10 text-center text-sm text-gray-500">
                            Belum ada hero.
                            <a href="{{ route('heroes.create') }}" class="text-teal-600 font-semibold">Buat yang pertama</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="flex justify-center">{{ $heroes->links() }}</div>
</div>
@endsection
