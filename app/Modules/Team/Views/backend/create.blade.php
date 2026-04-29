@extends('core::dashboard-layout')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Buat Team Member</h1>
            <p class="text-gray-600 mt-1">Tambahkan anggota tim baru</p>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
        <form action="{{ route('teams.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- Name Field --}}
            {!! formField('tim_nama', 'text', 'Nama', null, [], [
                'required' => true,
                'placeholder' => 'Masukkan nama anggota tim',
                'help' => 'Nama akan ditampilkan di halaman tim'
            ]) !!}

            {{-- Category Field --}}
            {!! formField('tim_kategori_id', 'select', 'Kategori', null, $categories->pluck('kategori_nama', 'kategori_id')->toArray(), [
                'required' => true,
                'placeholder' => 'Pilih Kategori'
            ]) !!}

            {{-- Description Field (Textarea) --}}
            {!! formField('tim_deskripsi', 'textarea', 'Deskripsi', null, [], [
                'rows' => 5,
                'placeholder' => 'Masukkan deskripsi anggota tim',
                'help' => 'Deskripsi akan ditampilkan di halaman detail tim'
            ]) !!}

            {{-- Image Field --}}
            {!! formField('tim_gambar', 'file', 'Gambar', null, [], [
                'accept' => 'image/*',
                'help' => 'Format: JPG, PNG (Max 2MB)'
            ]) !!}

            {{-- Status Field --}}
            {!! formField('tim_status', 'select', 'Status', null, [
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
                    Simpan Team Member
                </button>
                <a href="{{ route('teams.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-900 px-6 py-2 rounded-lg font-semibold transition flex items-center gap-2">
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
