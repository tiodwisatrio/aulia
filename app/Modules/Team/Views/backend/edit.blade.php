@extends('core::dashboard-layout')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Edit Team Member</h1>
            <p class="text-gray-600 mt-1">{{ $team->tim_nama }}</p>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
        <form action="{{ route('teams.update', $team) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Name Field --}}
            {!! formField('tim_nama', 'text', 'Nama', $team->tim_nama, [], [
                'required' => true,
                'placeholder' => 'Masukkan nama anggota tim',
                'help' => 'Nama akan ditampilkan di halaman tim'
            ]) !!}

            {{-- Category Field --}}
            {!! formField('tim_kategori_id', 'select', 'Kategori', $team->tim_kategori_id, $categories->pluck('kategori_nama', 'kategori_id')->toArray(), [
                'required' => true,
                'placeholder' => 'Pilih Kategori'
            ]) !!}

            {{-- Description Field (Textarea) --}}
            {!! formField('tim_deskripsi', 'textarea', 'Deskripsi', $team->tim_deskripsi, [], [
                'rows' => 5,
                'placeholder' => 'Masukkan deskripsi anggota tim',
                'help' => 'Deskripsi akan ditampilkan di halaman detail tim'
            ]) !!}

            {{-- Image Field --}}
            <div>
                <label class="block text-sm font-semibold text-gray-900 mb-2">Gambar</label>
                @if($team->tim_gambar)
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $team->tim_gambar) }}" alt="{{ $team->tim_nama }}" class="h-32 w-auto rounded-lg">
                        <p class="text-xs text-gray-600 mt-2">Gambar saat ini</p>
                    </div>
                @endif
                {!! formField('tim_gambar', 'file', null, null, [], [
                    'accept' => 'image/*',
                    'help' => 'Format: JPG, PNG (Max 2MB)'
                ]) !!}
            </div>

            {{-- Status Field --}}
            {!! formField('tim_status', 'select', 'Status', $team->tim_status, [
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
                    Perbarui Team Member
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
