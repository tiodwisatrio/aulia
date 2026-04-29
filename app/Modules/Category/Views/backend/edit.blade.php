@extends('core::dashboard-layout')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Edit Kategori</h1>
            <p class="text-gray-600 mt-1">{{ $category->kategori_nama }}</p>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6">
        <form action="{{ route('categories.update', $category) }}" method="POST" class="space-y-4">
            @csrf
            @method('PATCH')

            {{-- Name Field --}}
            {!! formField('kategori_nama', 'text', 'Nama', $category->kategori_nama, [], [
                'required' => true,
                'placeholder' => 'Nama kategori',
                'help' => 'Slug akan otomatis di-generate dari nama'
            ]) !!}

            {{-- Type (Hidden) --}}
            <input type="hidden" name="kategori_tipe" value="{{ $category->kategori_tipe }}">

            {{-- Description Field (Textarea) --}}
            {!! formField('kategori_deskripsi', 'textarea', 'Deskripsi', $category->kategori_deskripsi, [], [
                'rows' => 4,
                'placeholder' => 'Deskripsi kategori'
            ]) !!}

            {{-- Sort Order Field --}}
            {!! formField('kategori_urutan', 'number', 'Urutan', $category->kategori_urutan, [], [
                'min' => 0,
                'placeholder' => '0',
                'help' => 'Urutan tampilan kategori'
            ]) !!}

            {{-- Active Status --}}
            <div>
                <label class="flex items-center">
                    <input type="checkbox" name="kategori_aktif" value="1" {{ $category->kategori_aktif ? 'checked' : '' }}
                        class="w-4 h-4 text-teal-600 rounded border-gray-300 focus:ring-2 focus:ring-teal-500">
                    <span class="ml-2 text-sm font-semibold text-gray-900">Aktif</span>
                </label>
            </div>

            {{-- Buttons --}}
            <div class="flex gap-4 pt-4 border-t">
                <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded-lg font-semibold transition flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    Perbarui Kategori
                </button>
                <a href="{{ route('categories.index', ['type' => $category->kategori_tipe]) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-900 px-6 py-2 rounded-lg font-semibold transition flex items-center gap-2">
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
