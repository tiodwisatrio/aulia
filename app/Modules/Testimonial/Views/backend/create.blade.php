@extends('core::dashboard-layout')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Buat Testimonial</h1>
            <p class="text-gray-600 mt-1">Tambahkan testimonial pelanggan</p>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
        <form action="{{ route('testimonials.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- Name Field --}}
            {!! formField('testimoni_nama', 'text', 'Nama', null, [], [
                'required' => true,
                'placeholder' => 'Masukkan nama',
                'help' => 'Nama akan ditampilkan di halaman testimonial'
            ]) !!}

            {{-- Content Field (Textarea) --}}
            {!! formField('testimoni_isi', 'textarea', 'Isi Testimoni', null, [], [
                'required' => true,
                'rows' => 5,
                'placeholder' => 'Masukkan konten testimonial',
                'help' => 'Konten akan ditampilkan di halaman detail testimonial'
            ]) !!}

            {{-- Image Field --}}
            {!! formField('testimoni_gambar', 'file', 'Gambar', null, [], [
                'accept' => 'image/*',
                'help' => 'Format: JPG, PNG (Max 2MB)'
            ]) !!}

            {{-- Order Field --}}
            {!! formField('testimoni_urutan', 'number', 'Urutan', null, [], [
                'min' => 0,
                'placeholder' => '0',
                'help' => 'Urutan tampilan testimonial',
                'required' => true
            ]) !!}

            {{-- Status Field --}}
            {!! formField('testimoni_status', 'select', 'Status', null, [
                '1' => 'Aktif',
                '0' => 'Nonaktif'
            ], [
                'required' => true,
                'placeholder' => 'Pilih Status'
            ]) !!}

            {{-- Buttons --}}
            <div class="flex gap-4 pt-4 border-t">
                <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded-lg font-semibold transition flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    Simpan Testimonial
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
