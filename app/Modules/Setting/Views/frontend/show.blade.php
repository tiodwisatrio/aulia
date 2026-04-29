@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="max-w-3xl mx-auto">
        <!-- Back Button -->
        <a href="{{ route('posts.index') }}" class="text-teal-600 hover:text-teal-900 font-semibold mb-8 inline-block">
            ← Kembali ke Blog
        </a>

        <!-- Post Header -->
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-4">
                <span class="text-sm font-semibold text-teal-600 bg-teal-50 px-3 py-1 rounded-full">
                    {{ $post->category?->name ?? 'Uncategorized' }}
                </span>
                <span class="text-sm text-gray-600">{{ $post->created_at->format('d M Y') }}</span>
            </div>

            <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $post->title }}</h1>

            <!-- Author Info -->
            <div class="flex items-center gap-4 py-4 border-t border-b border-gray-200">
                <div class="w-12 h-12 rounded-full bg-teal-600 flex items-center justify-center text-white font-bold text-lg">
                    {{ substr($post->user->name, 0, 1) }}
                </div>
                <div>
                    <p class="font-semibold text-gray-900">{{ $post->user->name }}</p>
                    <p class="text-sm text-gray-600">{{ $post->created_at->format('d F Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Featured Image -->
        @if($post->featured_image)
        <div class="mb-8 rounded-xl overflow-hidden shadow-lg">
            <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-96 object-cover">
        </div>
        @endif

        <!-- Post Content -->
        <div class="prose prose-lg max-w-none mb-12 text-gray-700">
            {!! nl2br(e($post->content)) !!}
        </div>

        <!-- Divider -->
        <div class="border-t border-gray-200 py-8">
            <!-- Related Posts Section (Optional) -->
            <div class="text-center">
                <a href="{{ route('posts.index') }}" class="text-teal-600 hover:text-teal-900 font-semibold">
                    ← Lihat semua posts
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
