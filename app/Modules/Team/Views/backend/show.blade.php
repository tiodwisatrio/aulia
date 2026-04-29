@extends('core::dashboard-layout')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ $team->tim_nama }}</h1>
            <p class="text-gray-600 mt-1">{{ $team->created_at->format('d M Y H:i') }}</p>
        </div>

        <div>
            <a href="{{ route('teams.index') }}" class="text-teal-600 hover:text-teal-900 font-semibold">
                ← Kembali ke Team
            </a>
        </div>
    </div>

    <!-- Content -->
    <div class="grid grid-cols-3 gap-6">
        <div class="col-span-2 space-y-6">
            <!-- Image -->
            @if($team->tim_gambar)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <img src="{{ asset('storage/' . $team->tim_gambar) }}" alt="{{ $team->tim_nama }}" class="w-full h-96 object-cover">
            </div>
            @endif

            <!-- Description -->
            @if($team->tim_deskripsi)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                <div class="prose max-w-none">
                    {!! nl2br(e($team->tim_deskripsi)) !!}
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Meta Info -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Informasi</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-gray-600 font-semibold">KATEGORI</p>
                        <p class="text-gray-900">{{ $team->category?->kategori_nama ?? 'Tidak ada' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600 font-semibold">STATUS</p>
                        <span class="text-xs font-semibold px-3 py-1 rounded-full
                            @if($team->tim_status == '1') bg-green-100 text-green-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ $team->tim_status == '1' ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Timeline -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Timeline</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-gray-600 font-semibold">DIBUAT</p>
                        <p class="text-gray-900">{{ $team->created_at->format('d M Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600 font-semibold">DIPERBARUI</p>
                        <p class="text-gray-900">{{ $team->updated_at->format('d M Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
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
