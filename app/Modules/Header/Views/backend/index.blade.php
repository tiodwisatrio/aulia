@extends('core::dashboard-layout')
@section('header', 'Portfolio')
@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between gap-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Header</h1>
            <p class="text-gray-600 mt-1">Kelola semua header</p>
            <div class="mt-4">
                <a href="{{ route('headers.create') }}"
                   class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded-lg font-semibold transition inline-block">
                    + Tambah Header
                </a>
            </div>
        </div>
        <form method="GET" action="{{ route('headers.index') }}" class="flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari Header..."
                   class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
            <button type="submit"
                    class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                Cari
            </button>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Section</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Header Title</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Header Subtitle</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Aksi</th>
               
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($headers as $header)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4"><span class="px-2 py-1 bg-teal-50 text-teal-700 rounded text-xs font-mono">{{ $header->header_section ?? '-' }}</span></td>
                    <td class="px-6 py-4">{{ $header->header_title }}</td>
                    <td class="px-6 py-4">{{ Str::limit($header->header_subtitle, 50) }}</td>
                    <td class="px-6 py-4">
                        <div class="flex gap-3">
                         
                            <a href="{{ route('headers.edit', $header) }}" class="text-blue-500 hover:text-blue-800">
                                <i data-lucide="pencil" class="w-4 h-4"></i>
                            </a>
                            <form action="{{ route('headers.destroy', $header) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Hapus {{ $header->header_title }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-800">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                        Belum ada header.
                        <a href="{{ route('headers.create') }}" class="text-teal-600 font-semibold">Buat yang pertama</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="flex justify-center">{{ $headers->links() }}</div>
</div>
@endsection