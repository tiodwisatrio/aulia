@extends('core::dashboard-layout')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Edit Our Clients</h1>
            <p class="text-gray-600 mt-1">{{ $ourclient->klien_nama }}</p>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6">
        <form action="{{ route('ourclient.update', $ourclient) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            {{-- Name Field --}}
            {!! formField('klien_nama', 'text', 'Nama', $ourclient->klien_nama, [], [
                'required' => true,
                'placeholder' => 'Masukkan nama klien'
            ]) !!}

            {{-- Image Field --}}
            <div>
                <label class="block text-sm font-semibold text-gray-900 mb-2">Logo</label>
                @if($ourclient->klien_gambar)
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $ourclient->klien_gambar) }}" alt="{{ $ourclient->klien_nama }}" class="h-32 w-auto rounded-lg">
                        <p class="text-xs text-gray-600 mt-2">Logo saat ini</p>
                    </div>
                @endif
                {!! formField('klien_gambar', 'file', null, null, [], [
                    'accept' => 'image/*',
                    'help' => 'Format: JPG, PNG (Max 2MB)'
                ]) !!}
            </div>

            {{-- Order Field --}}
            {!! formField('klien_urutan', 'number', 'Urutan', $ourclient->klien_urutan, [], [
                'min' => 0,
                'placeholder' => '0'
            ]) !!}

            {{-- Status Field --}}
            <div>
                <label class="flex items-center">
                    <input type="checkbox" name="klien_status" value="1" {{ $ourclient->klien_status ? 'checked' : '' }}
                        class="w-4 h-4 text-teal-600 rounded border-gray-300 focus:ring-2 focus:ring-teal-500">
                    <span class="ml-2 text-sm font-semibold text-gray-900">Aktif</span>
                </label>
            </div>

            {{-- Buttons --}}
            <div class="flex gap-4 pt-4 border-t">
                <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded-lg font-semibold transition flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    Perbarui Our Clients
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
