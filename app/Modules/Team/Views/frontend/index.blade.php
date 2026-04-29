@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12">
    <!-- Header -->
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Blog</h1>
        <p class="text-xl text-gray-600">Artikel dan tips terbaru dari kami</p>
    </div>

    <!-- Posts Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
        @forelse($posts as $post)
        <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition">
            @if($post->featured_image)
            <div class="relative h-48 overflow-hidden bg-gray-200">
                <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover hover:scale-105 transition duration-300">
            </div>
            @else
            <div class="h-48 bg-gradient-to-br from-teal-500 to-blue-600"></div>
            @endif

            <div class="p-6">
                <div class="flex items-center gap-2 mb-3">
                    <span class="text-xs font-semibold text-teal-600 bg-teal-50 px-3 py-1 rounded-full">
                        {{ $post->category?->name ?? 'Uncategorized' }}
                    </span>
                </div>

                <h2 class="text-xl font-bold text-gray-900 mb-2 line-clamp-2">{{ $post->title }}</h2>

                <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                    {{ $post->excerpt ?? substr(strip_tags($post->content), 0, 150) . '...' }}
                </p>

                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full bg-teal-600 flex items-center justify-center text-white text-sm font-bold">
                            {{ substr($post->user->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-xs text-gray-600">{{ $post->user->name }}</p>
                            <p class="text-xs text-gray-500">{{ $post->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                    <a href="{{ route('posts.show', $post) }}" class="text-teal-600 hover:text-teal-900 font-semibold text-sm">
                        Baca →
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12">
            <p class="text-gray-600 text-lg">Belum ada posts</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="flex justify-center">
        {{ $posts->links() }}
    </div>
</div>
@endsection
