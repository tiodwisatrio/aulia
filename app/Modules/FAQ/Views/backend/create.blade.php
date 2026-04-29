@extends('core::dashboard-layout')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Buat Faq</h1>
            <p class="text-gray-600 mt-1">Tambahkan Faq baru</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
        <form action="{{ route('faqs.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- Question Field --}}
            {!! formField('faq_pertanyaan', 'text', 'Pertanyaan', null, [], [
                'required' => true,
                'placeholder' => 'Masukkan Pertanyaan'
            ]) !!}

            {{-- Answer Field --}}
            {!! formField('faq_jawaban', 'text', 'Jawaban', null, [], [
                'required' => true,
                'placeholder' => 'Masukkan Jawaban'
            ]) !!}


            {{-- Order Field --}}
            {!! formField('faq_urutan', 'number', 'Urutan', null, [], [
                'min' => 0,
                'placeholder' => '0',
                'help' => 'Urutan tampilan'
            ]) !!}

            {{-- Status Field --}}
            {!! formField('faq_status', 'select', 'Status', null, [
                '1' => 'Active',
                '0' => 'Inactive'
            ], [
                'required' => true,
                'placeholder' => 'Pilih Status'
            ]) !!}

            <div class="flex gap-4 pt-4 border-t">
                <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded-lg font-semibold transition flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    Simpan Faq
                </button>
                <a href="{{ route('faqs.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-900 px-6 py-2 rounded-lg font-semibold transition flex items-center gap-2">
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
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
</script>
@endpush

@endsection
