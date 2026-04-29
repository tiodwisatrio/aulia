@extends('core::dashboard-layout')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Edit Menu Navigasi</h1>
            <p class="text-gray-600 mt-1">{{ $navigation->menu_label }}</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
        <form action="{{ route('navigations.update', $navigation) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {!! formField('menu_label', 'text', 'Label', $navigation->menu_label, [], [
                'required' => true,
                'placeholder' => 'Nama menu'
            ]) !!}

            {!! formField('menu_route', 'text', 'Route/URL', $navigation->menu_route, [], [
                'placeholder' => 'dashboard.index'
            ]) !!}

            {!! formField('menu_ikon', 'text', 'Icon', $navigation->menu_ikon, [], [
                'placeholder' => 'home, settings, users...'
            ]) !!}

            {!! formField('menu_urutan', 'number', 'Urutan', $navigation->menu_urutan, [], [
                'min' => 0,
                'placeholder' => '0'
            ]) !!}

            {!! formField('menu_status', 'select', 'Status', $navigation->menu_status, [
                '1' => 'Aktif',
                '0' => 'Nonaktif'
            ], [
                'required' => true,
                'placeholder' => 'Pilih Status'
            ]) !!}

            <div class="flex gap-4 pt-4 border-t">
                <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded-lg font-semibold transition flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i> Perbarui Menu
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
