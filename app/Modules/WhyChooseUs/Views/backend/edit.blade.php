@extends('core::dashboard-layout')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Edit Why Choose Us</h1>
            <p class="text-gray-600 mt-1">{{ $whychooseus->mengapa_kami_judul }}</p>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
        <form action="{{ route('whychooseus.update', $whychooseus) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Title Field --}}
            {!! formField('mengapa_kami_judul', 'text', 'Judul', $whychooseus->mengapa_kami_judul, [], [
                'required' => true,
                'placeholder' => 'Masukkan judul alasan'
            ]) !!}

            {{-- Description Field (Textarea) --}}
            {!! formField('mengapa_kami_deskripsi', 'textarea', 'Deskripsi', $whychooseus->mengapa_kami_deskripsi, [], [
                'rows' => 5,
                'placeholder' => 'Masukkan deskripsi lengkap alasan'
            ]) !!}

            {{-- Image Field --}}
            <div>
                <label class="block text-sm font-semibold text-gray-900 mb-2">Gambar</label>
                @if($whychooseus->mengapa_kami_gambar)
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $whychooseus->mengapa_kami_gambar) }}" alt="{{ $whychooseus->mengapa_kami_judul }}" class="h-32 w-auto rounded-lg">
                        <p class="text-xs text-gray-600 mt-2">Gambar saat ini</p>
                    </div>
                @endif
                {!! formField('mengapa_kami_gambar', 'file', null, null, [], [
                    'accept' => 'image/*',
                    'help' => 'Format: JPG, PNG (Max 2MB)'
                ]) !!}
            </div>

            {{-- Status Field --}}
            {!! formField('mengapa_kami_status', 'select', 'Status', $whychooseus->mengapa_kami_status, [
                '1' => 'Aktif',
                '0' => 'Nonaktif'
            ], [
                'required' => true
            ]) !!}

            {{-- Buttons --}}
            <div class="flex gap-4 pt-4 border-t">
                <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded-lg font-semibold transition flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    Perbarui Why Choose Us
                </button>
                <a href="{{ route('whychooseus.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-900 px-6 py-2 rounded-lg font-semibold transition flex items-center gap-2">
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
