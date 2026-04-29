@extends('core::dashboard-layout')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ $category->kategori_nama }}</h1>
            <p class="text-gray-600 mt-1">{{ $category->created_at->format('d M Y H:i') }}</p>
        </div>

        <div>
            <a href="{{ route('categories.index', ['type' => $category->kategori_tipe]) }}" class="text-teal-600 hover:text-teal-900 font-semibold">
                ← Kembali ke Kategori
            </a>
        </div>
    </div>

    <!-- Content -->
    <div class="grid grid-cols-3 gap-6">
        <div class="col-span-2 space-y-6">
            <!-- Description -->
            @if($category->kategori_deskripsi)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                <div class="prose max-w-none">
                    {!! nl2br(e($category->kategori_deskripsi)) !!}
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
                        <p class="text-xs text-gray-600 font-semibold">TYPE</p>
                        <p class="text-gray-900 capitalize">{{ $category->kategori_tipe }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600 font-semibold">SLUG</p>
                        <p class="text-gray-900 font-mono text-sm">{{ $category->kategori_slug }}</p>
                    </div>
                    @if($category->kategori_urutan !== null)
                    <div>
                        <p class="text-xs text-gray-600 font-semibold">URUTAN</p>
                        <p class="text-gray-900">{{ $category->kategori_urutan }}</p>
                    </div>
                    @endif
                    <div>
                        <p class="text-xs text-gray-600 font-semibold">STATUS</p>
                        <span class="text-xs font-semibold px-3 py-1 rounded-full
                            @if($category->kategori_aktif) bg-green-100 text-green-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ $category->kategori_aktif ? 'Aktif' : 'Nonaktif' }}
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
                        <p class="text-gray-900">{{ $category->created_at->format('d M Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600 font-semibold">DIPERBARUI</p>
                        <p class="text-gray-900">{{ $category->updated_at->format('d M Y H:i') }}</p>
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
