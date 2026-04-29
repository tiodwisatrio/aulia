@extends('core::dashboard-layout')

@section('content')
<div class="space-y-6">
        <!-- Header -->
    <div class="flex items-center justify-between gap-8">
        <!-- Left: Title, Description, Button -->
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Why Choose Us</h1>
            <p class="text-gray-600 mt-1">Kelola alasan memilih perusahaan</p>
            <div class="mt-4">
                <a href="{{ route('whychooseus.create') }}" class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded-lg font-semibold transition inline-block">
                    + Tambah Why Choose Us
                </a>
            </div>
        </div>

        <!-- Right: Search -->
        <div class="flex-shrink-0">
            <form method="GET" action="{{ route('whychooseus.index') }}" class="flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari why choose us..."
                    class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                    Cari
                </button>
            </form>
        </div>
    </div>

    <!-- Items Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Judul</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Deskripsi</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Icon</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Status</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Dibuat</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($items as $item)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4">
                        <span class="font-medium text-gray-900">{{ $item->mengapa_kami_judul }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-gray-700">{{ Str::limit(strip_tags($item->mengapa_kami_deskripsi), 50) }}</span>
                    </td>
                    <td class="px-6 py-4">
                        @if($item->mengapa_kami_gambar)
                            <img src="{{ asset('storage/' . $item->mengapa_kami_gambar) }}" alt="{{ $item->mengapa_kami_judul }}" class="h-10 w-auto object-cover rounded">
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-xs font-semibold px-3 py-1 rounded-full {{ $item->mengapa_kami_status ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $item->mengapa_kami_status ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-600">
                        {{ $item->created_at->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex gap-3 items-center">
                            <!-- Show Button -->
                            <a href="{{ route('whychooseus.show', $item) }}" class="text-gray-600 hover:text-gray-900 transition" title="Lihat">
                                <i data-lucide="eye" class="w-5 h-5"></i>
                            </a>

                            <!-- Edit Button -->
                            <a href="{{ route('whychooseus.edit', $item) }}" class="text-blue-600 hover:text-blue-900 transition" title="Edit">
                                <i data-lucide="edit" class="w-5 h-5"></i>
                            </a>

                            <!-- Delete Button -->
                            <form action="{{ route('whychooseus.destroy', $item) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 transition" title="Hapus" onclick="return confirm('Yakin ingin menghapus?')">
                                    <i data-lucide="trash-2" class="w-5 h-5"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-gray-600">
                        Belum ada item. <a href="{{ route('whychooseus.create') }}" class="text-teal-600 hover:text-teal-900 font-semibold">Buat yang pertama</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="flex justify-center">
        {{ $items->links() }}
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Lucide icons
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
</script>
@endpush

@endsection
