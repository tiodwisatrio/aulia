@extends('core::dashboard-layout')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Tambah Menu Navigasi</h1>
            <p class="text-gray-600 mt-1">Tambahkan menu baru</p>
        </div>
        <div>
            <a href="{{ route('navigations.index') }}" class="text-teal-600 hover:text-teal-900 font-semibold">← Kembali ke Menu</a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
        <form action="{{ route('navigations.store') }}" method="POST" class="space-y-6">
            @csrf

            {!! formField('menu_label', 'text', 'Label', null, [], [
                'required' => true,
                'placeholder' => 'Nama menu'
            ]) !!}

            {!! formField('menu_route', 'text', 'Route/URL', null, [], [
                'placeholder' => 'dashboard.index'
            ]) !!}

            {!! formField('menu_ikon', 'text', 'Icon', null, [], [
                'placeholder' => 'home, settings, users...'
            ]) !!}

            {!! formField('menu_urutan', 'number', 'Urutan', null, [], [
                'min' => 0,
                'placeholder' => '0'
            ]) !!}

            {!! formField('menu_status', 'select', 'Status', null, [
                '1' => 'Aktif',
                '0' => 'Nonaktif'
            ], [
                'required' => true,
                'placeholder' => 'Pilih Status'
            ]) !!}

            <div class="flex gap-4 pt-4 border-t">
                <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded-lg font-semibold transition flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i> Simpan Menu
                </button>
                <a href="{{ route('navigations.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-900 px-6 py-2 rounded-lg font-semibold transition flex items-center gap-2">
                    <i data-lucide="x" class="w-4 h-4"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') lucide.createIcons();
    });
</script>
@endpush
@endsection
