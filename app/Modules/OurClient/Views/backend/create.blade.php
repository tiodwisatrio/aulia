@extends('core::dashboard-layout')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Buat Our Clients</h1>
            <p class="text-gray-600 mt-1">Tambahkan klien baru</p>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6">
        <form action="{{ route('ourclient.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            {{-- Name Field --}}
            {!! formField('klien_nama', 'text', 'Nama', null, [], [
                'required' => true,
                'placeholder' => 'Masukkan nama klien',
                'help' => 'Nama akan ditampilkan di halaman our clients'
            ]) !!}

            {{-- Image Field --}}
            {!! formField('klien_gambar', 'file', 'Logo', null, [], [
                'accept' => 'image/*',
                'help' => 'Format: JPG, PNG (Max 2MB)'
            ]) !!}

            {{-- Order Field --}}
            {!! formField('klien_urutan', 'number', 'Urutan', null, [], [
                'min' => 0,
                'placeholder' => '0',
                'help' => 'Urutan tampilan klien',
                'required' => true
            ]) !!}

            {{-- Status Field --}}
            {!! formField('klien_status', 'select', 'Status', null, [
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
                    Simpan Our Clients
                </button>
                <a href="{{ route('ourclient.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-900 px-6 py-2 rounded-lg font-semibold transition flex items-center gap-2">
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
