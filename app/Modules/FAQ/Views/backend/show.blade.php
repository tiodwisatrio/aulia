@extends('core::dashboard-layout')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ $faq->faq_pertanyaan }}</h1>
            <p class="text-gray-600 mt-1">{{ $faq->created_at->format('d M Y H:i') }}</p>
        </div>
        <div>
            <a href="{{ route('faqs.index') }}" class="text-teal-600 hover:text-teal-900 font-semibold">
                &larr; Kembali ke Faq
            </a>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-6">
        <div class="col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                <h3 class="font-semibold text-gray-900 mb-2">Question</h3>
                <p class="text-gray-700">{{ $faq->faq_pertanyaan }}</p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                <h3 class="font-semibold text-gray-900 mb-2">Answer</h3>
                <p class="text-gray-700">{{ $faq->faq_jawaban }}</p>
            </div>

        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Informasi</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-gray-600 font-semibold">STATUS</p>
                        <span class="text-xs font-semibold px-3 py-1 rounded-full
                            @if($faq->status == 1) bg-green-100 text-green-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ $faq->status == 1 ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    @if($faq->order !== null)
                    <div>
                        <p class="text-xs text-gray-600 font-semibold">URUTAN</p>
                        <p class="text-gray-900">{{ $faq->order }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Timeline</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-gray-600 font-semibold">DIBUAT</p>
                        <p class="text-gray-900">{{ $faq->created_at->format('d M Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600 font-semibold">DIPERBARUI</p>
                        <p class="text-gray-900">{{ $faq->updated_at->format('d M Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
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
