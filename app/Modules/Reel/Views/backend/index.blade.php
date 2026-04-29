@extends('core::dashboard-layout')
@section('header', 'Reels / Projects')
@section('content')
<div class="space-y-4">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Reels / Projects</h1>
            <p class="text-gray-500 text-sm mt-0.5">Kelola konten Instagram Reels</p>
        </div>
        <a href="{{ route('reels.create') }}"
           class="inline-flex items-center gap-2 bg-teal-600 hover:bg-teal-700 text-white px-4 py-2.5 rounded-lg text-sm font-semibold transition self-start sm:self-auto">
            <i data-lucide="plus" class="w-4 h-4"></i> Tambah Reel
        </a>
    </div>

    <!-- Search -->
    <form method="GET" action="{{ route('reels.index') }}" class="flex gap-2">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Cari reel..."
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
                        <!-- <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wide hidden sm:table-cell">Thumbnail</th> -->
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wide">Judul</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wide hidden sm:table-cell">URL</th>
                        <!-- <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wide">Urutan</th> -->
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wide">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wide">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($reels as $reel)
                    <tr class="hover:bg-gray-50 transition">
                        <!-- <td class="px-4 py-3 hidden sm:table-cell">
                            @if($reel->reel_thumbnail)
                                <img src="{{ asset('storage/' . $reel->reel_thumbnail) }}"
                                     class="h-12 w-20 object-cover rounded-lg">
                            @else
                                <span class="text-gray-300 text-sm">—</span>
                            @endif
                        </td> -->
                        <td class="px-4 py-3 text-sm font-medium text-gray-900">
                            {{ $reel->reel_judul ?: '-' }}
                        </td>
                        <td class="px-4 py-3 hidden sm:table-cell">
                            <a href="{{ $reel->reel_url }}" target="_blank"
                               class="text-xs text-teal-600 hover:underline truncate block max-w-xs">
                                {{ Str::limit($reel->reel_url, 50) }}
                            </a>
                        </td>
                        <!-- <td class="px-4 py-3 text-sm text-gray-600">{{ $reel->reel_urutan }}</td> -->
                        <td class="px-4 py-3">
                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full whitespace-nowrap
                                {{ $reel->reel_status ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                                {{ $reel->reel_status ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex gap-3 items-center">
                                <a href="{{ route('reels.edit', $reel) }}" class="text-blue-500 hover:text-blue-800 p-1">
                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                </a>
                                <form action="{{ route('reels.destroy', $reel) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Yakin hapus reel ini?')">
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
                        <td colspan="5" class="px-4 py-10 text-center text-sm text-gray-500">
                            Belum ada reel. <a href="{{ route('reels.create') }}" class="text-teal-600 font-semibold">Tambah yang pertama</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="flex justify-center">{{ $reels->links() }}</div>
</div>
@endsection
