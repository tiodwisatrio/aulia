@extends('core::dashboard-layout')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between gap-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Catalogs</h1>
            <p class="text-gray-600 mt-1">Kelola semua Catalogs</p>
            <div class="mt-4">
                <a href="{{ route('catalogs.create') }}" class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded-lg font-semibold transition inline-block">
                    + Tambah Catalog
                </a>
            </div>
        </div>

        <div class="flex-shrink-0">
            <form method="GET" action="{{ route('catalogs.index') }}" class="flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Catalogs..."
                    class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                    Cari
                </button>
            </form>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Title</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Description</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Images</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Status</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Dibuat</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($catalogs as $catalog)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4">
                        <span class="font-medium text-gray-900">{{ $catalog->title }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-gray-700">{{ Str::limit(strip_tags($catalog->description), 50) }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="font-medium text-gray-900">{{ $catalog->images }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-xs font-semibold px-3 py-1 rounded-full {{ $catalog->status ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $catalog->status ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-600">
                        {{ $catalog->created_at->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex gap-3 items-center">
                            <a href="{{ route('catalogs.show', $catalog) }}" class="text-gray-600 hover:text-gray-900 transition" title="Lihat">
                                <i data-lucide="eye" class="w-5 h-5"></i>
                            </a>
                            <a href="{{ route('catalogs.edit', $catalog) }}" class="text-blue-600 hover:text-blue-900 transition" title="Edit">
                                <i data-lucide="edit" class="w-5 h-5"></i>
                            </a>
                            <form action="{{ route('catalogs.destroy', $catalog) }}" method="POST" class="inline">
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
                    <td colspan="6" class="px-6 py-8 text-center text-gray-600">
                        Belum ada data. <a href="{{ route('catalogs.create') }}" class="text-teal-600 hover:text-teal-900 font-semibold">Buat yang pertama</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="flex justify-center">
        {{ $catalogs->links() }}
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
</script>
@endpush

@endsection
