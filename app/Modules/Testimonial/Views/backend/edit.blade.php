@extends('core::dashboard-layout')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Edit Testimonial</h1>
            <p class="text-gray-600 mt-1">{{ $testimonial->testimoni_nama }}</p>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
        <form action="{{ route('testimonials.update', $testimonial) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Name Field --}}
            {!! formField('testimoni_nama', 'text', 'Nama', $testimonial->testimoni_nama, [], [
                'required' => true,
                'placeholder' => 'Masukkan nama'
            ]) !!}

            {{-- Content Field (Textarea) --}}
            {!! formField('testimoni_isi', 'textarea', 'Konten', $testimonial->testimoni_isi, [], [
                'required' => true,
                'rows' => 5,
                'placeholder' => 'Masukkan konten testimonial'
            ]) !!}

            {{-- Image Field --}}
            <div>
                <label class="block text-sm font-semibold text-gray-900 mb-2">Gambar</label>
                @if($testimonial->testimoni_gambar)
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $testimonial->testimoni_gambar) }}" alt="{{ $testimonial->testimoni_nama }}" class="h-32 w-auto rounded-lg">
                        <p class="text-xs text-gray-600 mt-2">Gambar saat ini</p>
                    </div>
                @endif
                {!! formField('testimoni_gambar', 'file', null, null, [], [
                    'accept' => 'image/*',
                    'help' => 'Format: JPG, PNG (Max 2MB)'
                ]) !!}
            </div>

            {{-- Order Field --}}
            {!! formField('testimoni_urutan', 'number', 'Urutan', $testimonial->testimoni_urutan, [], [
                'min' => 0,
                'placeholder' => '0'
            ]) !!}

            {{-- Status Field --}}
            <div>
                <label class="flex items-center">
                    <input type="checkbox" name="testimoni_status" value="1" {{ $testimonial->testimoni_status ? 'checked' : '' }}
                        class="w-4 h-4 text-teal-600 rounded border-gray-300 focus:ring-2 focus:ring-teal-500">
                    <span class="ml-2 text-sm font-semibold text-gray-900">Aktif</span>
                </label>
            </div>

            {{-- Buttons --}}
            <div class="flex gap-4 pt-4 border-t">
                <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded-lg font-semibold transition flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    Perbarui Testimonial
                </button>
                <a href="{{ route('testimonials.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-900 px-6 py-2 rounded-lg font-semibold transition flex items-center gap-2">
                    <i data-lucide="x" class="w-4 h-4"></i>
                    Batal
                </a>
            </div>
        </form>
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
