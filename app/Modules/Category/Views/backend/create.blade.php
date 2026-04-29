@extends('core::dashboard-layout')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Buat Kategori</h1>
            <p class="text-gray-600 mt-1">Tambahkan kategori baru untuk {{ $type }}</p>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6">
        <form action="{{ route('categories.store') }}" method="POST" class="space-y-4">
            @csrf

            {{-- Name Field --}}
            {!! formField('kategori_nama', 'text', 'Nama', null, [], [
                'required' => true,
                'placeholder' => 'Nama kategori',
                'help' => 'Slug akan otomatis di-generate dari nama'
            ]) !!}

            {{-- Type (Hidden) --}}
            <input type="hidden" name="kategori_tipe" value="{{ $type }}">

            {{-- Description Field (Textarea) --}}
            {!! formField('kategori_deskripsi', 'textarea', 'Deskripsi', null, [], [
                'rows' => 4,
                'placeholder' => 'Deskripsi kategori'
            ]) !!}

            {{-- Sort Order Field --}}
            {!! formField('kategori_urutan', 'number', 'Urutan', null, [], [
                'min' => 0,
                'placeholder' => '0',
                'help' => 'Urutan tampilan kategori'
            ]) !!}

            {{-- Active Status --}}
            <div>
                <label class="flex items-center">
                    <input type="checkbox" name="kategori_aktif" value="1"
                        class="w-4 h-4 text-teal-600 rounded border-gray-300 focus:ring-2 focus:ring-teal-500">
                    <span class="ml-2 text-sm font-semibold text-gray-900">Aktif</span>
                </label>
            </div>

            {{-- Buttons --}}
            <div class="flex gap-4 pt-4 border-t">
                <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded-lg font-semibold transition flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    Simpan Kategori
                </button>
                <a href="{{ route('categories.index', ['type' => $type]) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-900 px-6 py-2 rounded-lg font-semibold transition flex items-center gap-2">
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
