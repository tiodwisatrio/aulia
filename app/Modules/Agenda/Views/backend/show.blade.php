@extends('core::dashboard-layout')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ $agenda->agenda_judul }}</h1>
            <p class="text-gray-600 mt-1">{{ $agenda->created_at->format('d M Y H:i') }}</p>
        </div>
        <div>
            <a href="{{ route('agendas.index') }}" class="text-teal-600 hover:text-teal-900 font-semibold">← Kembali ke Agenda</a>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-6">
        <div class="col-span-2 space-y-6">
            @if($agenda->agenda_gambar)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <img src="{{ asset('storage/' . $agenda->agenda_gambar) }}" alt="{{ $agenda->agenda_judul }}" class="w-full h-96 object-cover">
            </div>
            @endif
            @if($agenda->agenda_deskripsi)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                <div class="prose max-w-none">{!! nl2br(e($agenda->agenda_deskripsi)) !!}</div>
            </div>
            @endif
        </div>
        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Informasi</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-gray-600 font-semibold">TANGGAL MULAI</p>
                        <p class="text-gray-900">{{ $agenda->agenda_tanggal_mulai ? \Carbon\Carbon::parse($agenda->agenda_tanggal_mulai)->format('d M Y') : '-' }}</p>
                    </div>
                    @if($agenda->agenda_tanggal_selesai)
                    <div>
                        <p class="text-xs text-gray-600 font-semibold">TANGGAL SELESAI</p>
                        <p class="text-gray-900">{{ \Carbon\Carbon::parse($agenda->agenda_tanggal_selesai)->format('d M Y') }}</p>
                    </div>
                    @endif
                    @if($agenda->agenda_lokasi)
                    <div>
                        <p class="text-xs text-gray-600 font-semibold">LOKASI</p>
                        <p class="text-gray-900">{{ $agenda->agenda_lokasi }}</p>
                    </div>
                    @endif
                    <div>
                        <p class="text-xs text-gray-600 font-semibold">STATUS</p>
                        <span class="text-xs font-semibold px-3 py-1 rounded-full
                            @if($agenda->agenda_status == '1') bg-green-100 text-green-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ $agenda->agenda_status == '1' ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Timeline</h3>
                <div class="space-y-4">
                    <div><p class="text-xs text-gray-600 font-semibold">DIBUAT</p><p class="text-gray-900">{{ $agenda->created_at->format('d M Y H:i') }}</p></div>
                    <div><p class="text-xs text-gray-600 font-semibold">DIPERBARUI</p><p class="text-gray-900">{{ $agenda->updated_at->format('d M Y H:i') }}</p></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
