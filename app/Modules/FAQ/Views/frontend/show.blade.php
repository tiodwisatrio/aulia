@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <a href="{{ route('frontend.faqs.index') }}" class="text-teal-600 hover:text-teal-900 font-semibold">
            &larr; Kembali ke Faq
        </a>

        <h1 class="text-3xl font-bold text-gray-900 mt-4 mb-6">{{ $faq->question }}</h1>

        <div class="mb-4">
            <span class="text-sm text-gray-500">Question</span>
            <p class="text-gray-900">{{ $faq->question }}</p>
        </div>
        <div class="mb-4">
            <span class="text-sm text-gray-500">Answer</span>
            <p class="text-gray-900">{{ $faq->answer }}</p>
        </div>
    </div>
</div>
@endsection
