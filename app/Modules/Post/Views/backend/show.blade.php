@extends('core::dashboard-layout')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ $post->posts_judul }}</h1>
            <p class="text-gray-600 mt-1">{{ $post->created_at->format('d M Y H:i') }}</p>
        </div>
           <div>
        <a href="{{ route('posts.index') }}" class="text-teal-600 hover:text-teal-900 font-semibold">
            ← Kembali ke Posts
        </a>
    </div>

    </div>

    <!-- Content -->
    <div class="grid grid-cols-3 gap-6">
        <div class="col-span-2 space-y-6">
            <!-- Featured Image -->
            @if($post->posts_gambar_utama)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <img src="{{ asset('storage/' . $post->posts_gambar_utama) }}" alt="{{ $post->posts_judul }}" class="w-full h-96 object-cover">
            </div>
            @endif

            <!-- Post Content -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                <div class="prose max-w-none">
                    {!! displayHtml($post->posts_konten) !!}
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Meta Info -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Informasi</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-gray-600 font-semibold">PENULIS</p>
                        <p class="text-gray-900">{{ $post->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600 font-semibold">KATEGORI</p>
                        <p class="text-gray-900">{{ $post->category?->kategori_nama ?? 'Tidak ada' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600 font-semibold">STATUS</p>
                        <span class="text-xs font-semibold px-3 py-1 rounded-full
                            @if($post->posts_status === 'aktif') bg-green-100 text-green-800
                            @else bg-yellow-100 text-yellow-800
                            @endif">
                            {{ $post->posts_status === 'aktif' ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600 font-semibold">UNGGULAN</p>
                        <p class="text-gray-900">{{ $post->posts_unggulan ? 'Ya' : 'Tidak' }}</p>
                    </div>
                </div>
            </div>

            <!-- Dates -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Timeline</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-gray-600 font-semibold">DIBUAT</p>
                        <p class="text-gray-900">{{ $post->created_at->format('d M Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600 font-semibold">DIPERBARUI</p>
                        <p class="text-gray-900">{{ $post->updated_at->format('d M Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Back Button -->
 
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
