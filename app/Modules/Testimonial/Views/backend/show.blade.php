@extends('core::dashboard-layout')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ $testimonial->testimoni_nama }}</h1>
            <p class="text-gray-600 mt-1">{{ $testimonial->created_at->format('d M Y H:i') }}</p>
        </div>

        <div>
            <a href="{{ route('testimonials.index') }}" class="text-teal-600 hover:text-teal-900 font-semibold">
                ← Kembali ke Testimonials
            </a>
        </div>
    </div>

    <!-- Content -->
    <div class="grid grid-cols-3 gap-6">
        <div class="col-span-2 space-y-6">
            <!-- Image -->
            @if($testimonial->testimoni_gambar)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <img src="{{ asset('storage/' . $testimonial->testimoni_gambar) }}" alt="{{ $testimonial->testimoni_nama }}" class="w-full h-96 object-cover">
            </div>
            @endif

            <!-- Content -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                <div class="prose max-w-none">
                    {!! nl2br(e($testimonial->testimoni_isi)) !!}
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
                        <p class="text-xs text-gray-600 font-semibold">STATUS</p>
                        <span class="text-xs font-semibold px-3 py-1 rounded-full
                            @if($testimonial->testimoni_status == '1') bg-green-100 text-green-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ $testimonial->testimoni_status == '1' ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </div>
                    @if($testimonial->testimoni_urutan !== null)
                    <div>
                        <p class="text-xs text-gray-600 font-semibold">URUTAN</p>
                        <p class="text-gray-900">{{ $testimonial->testimoni_urutan }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Timeline -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Timeline</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-gray-600 font-semibold">DIBUAT</p>
                        <p class="text-gray-900">{{ $testimonial->created_at->format('d M Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600 font-semibold">DIPERBARUI</p>
                        <p class="text-gray-900">{{ $testimonial->updated_at->format('d M Y H:i') }}</p>
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
