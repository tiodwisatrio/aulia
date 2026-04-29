@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <a href="{{ route('frontend.catalogs.index') }}" class="text-teal-600 hover:text-teal-900 font-semibold">
            &larr; Kembali ke Catalog
        </a>

        <h1 class="text-3xl font-bold text-gray-900 mt-4 mb-6">{{ $catalog->title }}</h1>

        <div class="mb-4">
            <span class="text-sm text-gray-500">Title</span>
            <p class="text-gray-900">{{ $catalog->title }}</p>
        </div>
        <div class="prose max-w-none mb-6">
            {!! nl2br(e($catalog->description)) !!}
        </div>
        <div class="mb-4">
            <span class="text-sm text-gray-500">Images</span>
            <p class="text-gray-900">{{ $catalog->images }}</p>
        </div>
    </div>
</div>
@endsection
