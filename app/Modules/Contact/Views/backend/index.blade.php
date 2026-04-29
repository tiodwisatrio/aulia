@extends('core::dashboard-layout')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Pesan Kontak</h1>
            <p class="text-gray-600 mt-1">Kelola semua pesan dari formulir kontak</p>
            @if($newCount > 0)
                <span class="inline-block mt-2 px-3 py-1 bg-red-100 text-red-800 text-xs font-bold rounded-full">
                    {{ $newCount }} Pesan Baru
                </span>
            @endif
        </div>
    </div>

    <!-- Messages Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Nama</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Email</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Subjek</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Status</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Tanggal</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($messages as $message)
                <tr class="hover:bg-gray-50 transition {{ $message->hubungi_kami_status === 'baru' ? 'bg-blue-50' : '' }}">
                    <td class="px-6 py-4">
                        <span class="font-medium text-gray-900">{{ $message->hubungi_kami_nama }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <a href="mailto:{{ $message->hubungi_kami_email }}" class="text-blue-600 hover:text-blue-900 text-sm">
                            {{ $message->hubungi_kami_email }}
                        </a>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-gray-700 line-clamp-1">{{ $message->hubungi_kami_subjek }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-xs font-semibold px-3 py-1 rounded-full
                            @if($message->hubungi_kami_status === 'baru') bg-blue-100 text-blue-800
                            @elseif($message->hubungi_kami_status === 'dibalas') bg-green-100 text-green-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ ucfirst($message->hubungi_kami_status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-600 text-sm">
                        {{ $message->created_at->format('d M Y H:i') }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex gap-3">
                            <a href="{{ route('contacts.show', $message) }}" class="text-blue-600 hover:text-blue-900 font-semibold text-sm">Lihat</a>
                            @if($message->hubungi_kami_status !== 'dibalas')
                            <a href="{{ route('contacts.show', $message) }}#replySection" class="text-teal-600 hover:text-teal-900 font-semibold text-sm">Reply</a>
                            @endif
                            <form action="{{ route('contacts.destroy', $message) }}" method="POST" class="inline">
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
                        Belum ada pesan kontak
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="flex justify-center">
        {{ $messages->links() }}
    </div>
</div>
@endsection
