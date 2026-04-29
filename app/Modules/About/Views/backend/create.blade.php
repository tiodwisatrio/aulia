@extends('core::dashboard-layout')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Buat About</h1>
            <p class="text-gray-600 mt-1">Tambahkan informasi tentang perusahaan</p>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6">
        <form action="{{ route('abouts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            {{-- Title Field --}}
            {!! formField('tentang_judul', 'text', 'Judul', null, [], [
                'required' => true,
                'placeholder' => 'Masukkan judul tentang perusahaan',
                'help' => 'Judul akan ditampilkan di halaman about'
            ]) !!}

            {{-- Content Field (Textarea) --}}
            {!! formField('tentang_konten', 'textarea', 'Konten', null, [], [
                'required' => true,
                'rows' => 8,
                'placeholder' => 'Masukkan konten lengkap tentang perusahaan',
                'help' => ''
            ]) !!}

            {{-- Image Field --}}
            {!! formField('tentang_gambar', 'file', 'Gambar', null, [], [
                'accept' => 'image/*',
                'help' => 'Format: JPG, PNG (Max 5MB)'
            ]) !!}

            {{-- Stats --}}
            <div>
                <h3 class="text-sm font-semibold text-gray-700 mb-3 uppercase tracking-wide">Statistik (Opsional)</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {!! formField('tentang_jumlah_origin', 'text', 'Jumlah Origin', null, [], [
                        'placeholder' => 'cth: 20+',
                        'help' => 'Jumlah daerah asal kopi'
                    ]) !!}
                    {!! formField('tentang_jumlah_pelanggan', 'text', 'Jumlah Pelanggan', null, [], [
                        'placeholder' => 'cth: 500+',
                        'help' => 'Jumlah pelanggan aktif'
                    ]) !!}
                    {!! formField('tentang_jumlah_fresh_roast', 'text', '100% Fresh Roast', null, [], [
                        'placeholder' => 'cth: 100%',
                        'help' => 'Label kualitas fresh roast'
                    ]) !!}
                    {!! formField('tentang_tahun_berdiri', 'text', 'Tahun Berdiri', null, [], [
                        'placeholder' => 'cth: 2018',
                        'help' => 'Tahun usaha berdiri'
                    ]) !!}
                </div>
            </div>

            {{-- Status Field --}}
            {!! formField('tentang_status', 'select', 'Status', '1', [
                '1' => 'Aktif',
                '0' => 'Nonaktif'
            ], [
                'required' => true
            ]) !!}

            {{-- Buttons --}}
            <div class="flex gap-4 pt-4 border-t">
                <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded-lg font-semibold transition flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    Simpan About
                </button>
                <a href="{{ route('abouts.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-900 px-6 py-2 rounded-lg font-semibold transition flex items-center gap-2">
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
