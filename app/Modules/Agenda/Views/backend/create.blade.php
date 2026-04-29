@extends('core::dashboard-layout')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Buat Agenda</h1>
            <p class="text-gray-600 mt-1">Tambahkan agenda atau acara baru</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
        <form action="{{ route('agendas.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {!! formField('agenda_judul', 'text', 'Judul', null, [], [
                'required' => true,
                'placeholder' => 'Masukkan judul agenda'
            ]) !!}

            {!! formField('agenda_deskripsi', 'textarea', 'Deskripsi', null, [], [
                'rows' => 5,
                'placeholder' => 'Deskripsi agenda'
            ]) !!}

            <div class="grid grid-cols-2 gap-6">
                {!! formField('agenda_tanggal_mulai', 'date', 'Tanggal Mulai', null, [], ['required' => true]) !!}
                {!! formField('agenda_tanggal_selesai', 'date', 'Tanggal Selesai', null, [], []) !!}
            </div>

            {!! formField('agenda_lokasi', 'text', 'Lokasi', null, [], [
                'placeholder' => 'Masukkan lokasi agenda'
            ]) !!}

            {!! formField('agenda_gambar', 'file', 'Gambar', null, [], [
                'accept' => 'image/*',
                'help' => 'Format: JPG, PNG (Max 2MB)'
            ]) !!}

            {!! formField('agenda_status', 'select', 'Status', null, [
                '1' => 'Aktif',
                '0' => 'Nonaktif'
            ], [
                'required' => true,
                'placeholder' => 'Pilih Status'
            ]) !!}

            <div class="flex gap-4 pt-4 border-t">
                <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded-lg font-semibold transition flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i> Simpan Agenda
                </button>
                <a href="{{ route('agendas.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-900 px-6 py-2 rounded-lg font-semibold transition flex items-center gap-2">
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
