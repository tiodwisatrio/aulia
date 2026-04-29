@extends('core::dashboard-layout')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Edit Agenda</h1>
            <p class="text-gray-600 mt-1">{{ $agenda->agenda_judul }}</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
        <form action="{{ route('agendas.update', $agenda) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            {!! formField('agenda_judul', 'text', 'Judul', $agenda->agenda_judul, [], [
                'required' => true,
                'placeholder' => 'Masukkan judul agenda'
            ]) !!}

            {!! formField('agenda_deskripsi', 'textarea', 'Deskripsi', $agenda->agenda_deskripsi, [], [
                'rows' => 5,
                'placeholder' => 'Deskripsi agenda'
            ]) !!}

            <div class="grid grid-cols-2 gap-6">
                {!! formField('agenda_tanggal_mulai', 'date', 'Tanggal Mulai', $agenda->agenda_tanggal_mulai, [], ['required' => true]) !!}
                {!! formField('agenda_tanggal_selesai', 'date', 'Tanggal Selesai', $agenda->agenda_tanggal_selesai, [], []) !!}
            </div>

            {!! formField('agenda_lokasi', 'text', 'Lokasi', $agenda->agenda_lokasi, [], [
                'placeholder' => 'Masukkan lokasi agenda'
            ]) !!}

            <div>
                <label class="block text-sm font-semibold text-gray-900 mb-2">Gambar</label>
                @if($agenda->agenda_gambar)
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $agenda->agenda_gambar) }}" alt="{{ $agenda->agenda_judul }}" class="h-32 w-auto rounded-lg">
                        <p class="text-xs text-gray-600 mt-2">Gambar saat ini</p>
                    </div>
                @endif
                {!! formField('agenda_gambar', 'file', null, null, [], [
                    'accept' => 'image/*',
                    'help' => 'Format: JPG, PNG (Max 2MB)'
                ]) !!}
            </div>

            {!! formField('agenda_status', 'select', 'Status', $agenda->agenda_status, [
                '1' => 'Aktif',
                '0' => 'Nonaktif'
            ], [
                'required' => true,
                'placeholder' => 'Pilih Status'
            ]) !!}

            <div class="flex gap-4 pt-4 border-t">
                <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded-lg font-semibold transition flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i> Perbarui Agenda
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
