@extends('core::dashboard-layout')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Edit About</h1>
            <p class="text-gray-600 mt-1">{{ $about->tentang_judul }}</p>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6">
        <form action="{{ route('abouts.update', $about) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            {{-- Title Field --}}
            {!! formField('tentang_judul', 'text', 'Judul', $about->tentang_judul, [], [
                'required' => true,
                'placeholder' => 'Masukkan judul tentang perusahaan',
                'help' => 'Judul akan ditampilkan di halaman about'
            ]) !!}

            {{-- Content Field (Textarea) --}}
            {!! formField('tentang_konten', 'textarea', 'Konten', $about->tentang_konten, [], [
                'required' => true,
                'rows' => 8,
                'placeholder' => 'Masukkan konten lengkap tentang perusahaan'
            ]) !!}

            {{-- Image Field --}}
            <div>
                <label class="block text-sm font-semibold text-gray-900 mb-2">Gambar</label>
                @if($about->tentang_gambar)
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $about->tentang_gambar) }}" alt="{{ $about->tentang_judul }}" class="h-32 w-auto rounded-lg">
                        <p class="text-xs text-gray-600 mt-2">Gambar saat ini</p>
                    </div>
                @endif
                {!! formField('tentang_gambar', 'file', null, null, [], [
                    'accept' => 'image/*',
                    'help' => 'Format: JPG, PNG (Max 2MB)'
                ]) !!}
            </div>

            {{-- Stats --}}
            <div>
                <h3 class="text-sm font-semibold text-gray-700 mb-3 uppercase tracking-wide">Statistik (Opsional)</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {!! formField('tentang_jumlah_origin', 'text', 'Jumlah Origin', $about->tentang_jumlah_origin, [], [
                        'placeholder' => 'cth: 20+',
                        'help' => 'Jumlah daerah asal kopi'
                    ]) !!}
                    {!! formField('tentang_jumlah_pelanggan', 'text', 'Jumlah Pelanggan', $about->tentang_jumlah_pelanggan, [], [
                        'placeholder' => 'cth: 500+',
                        'help' => 'Jumlah pelanggan aktif'
                    ]) !!}
                    {!! formField('tentang_jumlah_fresh_roast', 'text', '100% Fresh Roast', $about->tentang_jumlah_fresh_roast, [], [
                        'placeholder' => 'cth: 100%',
                        'help' => 'Label kualitas fresh roast'
                    ]) !!}
                    {!! formField('tentang_tahun_berdiri', 'text', 'Tahun Berdiri', $about->tentang_tahun_berdiri, [], [
                        'placeholder' => 'cth: 2018',
                        'help' => 'Tahun usaha berdiri'
                    ]) !!}
                </div>
            </div>

            {{-- Status Field --}}
            {!! formField('tentang_status', 'select', 'Status', $about->tentang_status ? '1' : '0', [
                '1' => 'Aktif',
                '0' => 'Nonaktif'
            ], [
                'required' => true
            ]) !!}

            {{-- Buttons --}}
            <div class="flex gap-4 pt-4 border-t">
                <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded-lg font-semibold transition flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    Perbarui About
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
