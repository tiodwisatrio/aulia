@extends('core::dashboard-layout')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Edit Our Values</h1>
            <p class="text-gray-600 mt-1">{{ $ourvalue->nilai_kami_nama }}</p>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6">
        <form action="{{ route('ourvalues.update', $ourvalue) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            {{-- Name Field --}}
            {!! formField('nilai_kami_nama', 'text', 'Nama', $ourvalue->nilai_kami_nama, [], [
                'required' => true,
                'placeholder' => 'Masukkan nama nilai'
            ]) !!}

            {{-- Description Field (Textarea) --}}
            {!! formField('nilai_kami_deskripsi', 'textarea', 'Deskripsi', $ourvalue->nilai_kami_deskripsi, [], [
                'rows' => 5,
                'placeholder' => 'Masukkan deskripsi lengkap nilai'
            ]) !!}

            {{-- Image Field --}}
            <div>
                <label class="block text-sm font-semibold text-gray-900 mb-2">Gambar</label>
                @if($ourvalue->nilai_kami_gambar)
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $ourvalue->nilai_kami_gambar) }}" alt="{{ $ourvalue->nilai_kami_nama }}" class="h-32 w-auto rounded-lg">
                        <p class="text-xs text-gray-600 mt-2">Gambar saat ini</p>
                    </div>
                @endif
                {!! formField('nilai_kami_gambar', 'file', null, null, [], [
                    'accept' => 'image/*',
                    'help' => 'Format: JPG, PNG (Max 2MB)'
                ]) !!}
            </div>

            {{-- Order Field --}}
            {!! formField('nilai_kami_urutan', 'number', 'Urutan', $ourvalue->nilai_kami_urutan, [], [
                'min' => 0,
                'placeholder' => '0',
                'required' => true
            ]) !!}

            {{-- Status Field --}}
            {!! formField('nilai_kami_status', 'select', 'Status', $ourvalue->nilai_kami_status, [
                '1' => 'Aktif',
                '0' => 'Nonaktif'
            ], [
                'required' => true
            ]) !!}

            {{-- Buttons --}}
            <div class="flex gap-4 pt-4 border-t">
                <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded-lg font-semibold transition flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    Perbarui Our Values
                </button>
                <a href="{{ route('ourvalues.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-900 px-6 py-2 rounded-lg font-semibold transition flex items-center gap-2">
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
