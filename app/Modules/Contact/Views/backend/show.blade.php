@extends('core::dashboard-layout')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ $hubungi_kami->hubungi_kami_subjek }}</h1>
            <p class="text-gray-600 mt-1">Dari: <strong>{{ $hubungi_kami->hubungi_kami_nama }}</strong></p>
        </div>
        <div class="flex gap-3">
            @if($hubungi_kami->hubungi_kami_status !== 'dibalas')
            <button type="button" class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded-lg font-semibold transition" onclick="document.getElementById('replySection').scrollIntoView({ behavior: 'smooth' })">
                Reply
            </button>
            @endif
            <form action="{{ route('contacts.destroy', $hubungi_kami) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg font-semibold transition" onclick="return confirm('Yakin ingin menghapus?')">
                    Hapus
                </button>
            </form>
        </div>
    </div>

    <!-- Content -->
    <div class="grid grid-cols-3 gap-6">
        <div class="col-span-2 space-y-6">
            <!-- Message -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                <h3 class="font-semibold text-gray-900 mb-4">Pesan</h3>
                <div class="prose max-w-none text-gray-700 whitespace-pre-wrap">
                    {{ $hubungi_kami->hubungi_kami_pesan }}
                </div>
            </div>

            <!-- Admin Reply (if exists) -->
            @if($hubungi_kami->hubungi_kami_balasan_admin)
            <div class="bg-green-50 rounded-xl shadow-sm border border-green-200 p-8">
                <h3 class="font-semibold text-green-900 mb-2">Balasan Admin</h3>
                <p class="text-xs text-green-600 mb-4">Dibalas pada: {{ $hubungi_kami->hubungi_kami_dibalas_pada->format('d M Y H:i') }}</p>
                <div class="prose max-w-none text-green-700 whitespace-pre-wrap">
                    {{ $hubungi_kami->hubungi_kami_balasan_admin }}
                </div>
            </div>
            @endif

            <!-- Reply Form -->
            @if($hubungi_kami->hubungi_kami_status !== 'dibalas')
            <div id="replySection" class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                <h3 class="font-semibold text-gray-900 mb-6">Balas Pesan</h3>
                <form action="{{ route('contacts.reply', $hubungi_kami) }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 mb-2">Pesan Balasan</label>
                            <textarea name="reply_message" rows="6" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 @error('reply_message') border-red-500 @enderror"
                                placeholder="Tulis balasan untuk pengunjung..."></textarea>
                            @error('reply_message')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white px-8 py-2 rounded-lg font-semibold transition">
                                Kirim Balasan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Contact Info -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Informasi Kontak</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-gray-600 font-semibold">NAMA</p>
                        <p class="text-gray-900">{{ $hubungi_kami->hubungi_kami_nama }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600 font-semibold">EMAIL</p>
                        <a href="mailto:{{ $hubungi_kami->hubungi_kami_email }}" class="text-blue-600 hover:text-blue-900">{{ $hubungi_kami->hubungi_kami_email }}</a>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600 font-semibold">STATUS</p>
                        <span class="text-xs font-semibold px-3 py-1 rounded-full
                            @if($hubungi_kami->hubungi_kami_status === 'baru') bg-blue-100 text-blue-800
                            @elseif($hubungi_kami->hubungi_kami_status === 'dibaca') bg-gray-100 text-gray-800
                            @elseif($hubungi_kami->hubungi_kami_status === 'dibalas') bg-green-100 text-green-800
                            @endif">
                            {{ ucfirst($hubungi_kami->hubungi_kami_status) }}
                        </span>
                    </div>
                    @if($hubungi_kami->hubungi_kami_ip_address)
                    <div>
                        <p class="text-xs text-gray-600 font-semibold">IP ADDRESS</p>
                        <p class="text-gray-900 font-mono text-sm">{{ $hubungi_kami->hubungi_kami_ip_address }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Dates -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Timeline</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-gray-600 font-semibold">DITERIMA</p>
                        <p class="text-gray-900">{{ $hubungi_kami->created_at->format('d M Y H:i') }}</p>
                    </div>
                    @if($hubungi_kami->hubungi_kami_dibalas_pada)
                    <div>
                        <p class="text-xs text-gray-600 font-semibold">DIBALAS</p>
                        <p class="text-gray-900">{{ $hubungi_kami->hubungi_kami_dibalas_pada->format('d M Y H:i') }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Back Button -->
    <div>
        <a href="{{ route('contacts.index') }}" class="text-teal-600 hover:text-teal-900 font-semibold">
            ← Kembali ke Pesan Kontak
        </a>
    </div>
</div>
@endsection
