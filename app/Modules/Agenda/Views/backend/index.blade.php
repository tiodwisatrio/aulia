@extends('core::dashboard-layout')

@section('content')
<div class="space-y-6">
        <!-- Header -->
    <div class="flex items-start justify-between gap-8">
        <!-- Left: Title, Description, Button -->
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Agenda</h1>
            <p class="text-gray-600 mt-1">Kelola semua agenda dan acara</p>
            <div class="mt-4">
                <a href="{{ route('agendas.create') }}" class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded-lg font-semibold transition inline-block">
                    + Tambah Agenda
                </a>
            </div>
        </div>

        <!-- Right: Search -->
        <div class="flex-shrink-0">
            <form method="GET" action="{{ route('agendas.index') }}" class="flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari agenda..."
                    class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                    Cari
                </button>
            </form>
        </div>
    </div>

    <!-- Agendas Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Judul</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Deskripsi</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Tanggal</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Lokasi</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Dibuat</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($agendas as $agenda)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4">
                        <span class="font-medium text-gray-900">{{ $agenda->agenda_judul }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-gray-700">{{ Str::limit($agenda->agenda_deskripsi, 50) }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-gray-700">{{ \Carbon\Carbon::parse($agenda->agenda_tanggal_mulai)->format('d M Y') }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-gray-700">{{ $agenda->agenda_lokasi ?? '-' }}</span>
                    </td>
                    <td class="px-6 py-4 text-gray-600">
                        {{ $agenda->created_at->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex gap-2">
                            <a href="{{ route('agendas.edit', $agenda) }}" class="text-blue-600 hover:text-blue-900 font-semibold text-sm">Edit</a>
                            <form action="{{ route('agendas.destroy', $agenda) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 font-semibold text-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-600">
                        Belum ada agenda. <a href="{{ route('agendas.create') }}" class="text-teal-600 hover:text-teal-900 font-semibold">Buat yang pertama</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="flex justify-center">
        {{ $agendas->links() }}
    </div>
</div>
@endsection
