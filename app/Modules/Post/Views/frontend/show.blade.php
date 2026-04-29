@extends('frontend.layouts.app')

@section('title', $post->posts_judul)

@section('content')
<!-- Article Header -->
<div class="bg-gray-50 py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Breadcrumb -->
            <!-- <nav class="mb-6">
                <ol class="flex items-center space-x-2 text-sm text-gray-500">
                    <li><a href="{{ route('frontend.home') }}" class="hover:text-blue-600">Home</a></li>
                    <li><i data-lucide="chevron-right" class="w-4 h-4"></i></li>
                    <li><a href="{{ route('frontend.blog.index') }}" class="hover:text-blue-600">Blog</a></li>
                    <li><i data-lucide="chevron-right" class="w-4 h-4"></i></li>
                    <li class="text-gray-700">{{ Str::limit($post->title, 50) }}</li>
                </ol>
            </nav> -->
            
            <!-- Article Meta -->
            <div class="text-center">
                <!-- Category -->
                @if($post->category)
                    <div class="mb-4">
                        <span class="inline-block px-3 py-1 bg-blue-600 text-white text-sm rounded-full">
                            {{ ucfirst($post->category->kategori_nama) }}
                        </span>
                    </div>
                @endif

                <!-- Title -->
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-6">
                    {{ $post->posts_judul }}
                </h1>

                <!-- Meta Info -->
                <div class="flex flex-col md:flex-row items-center justify-center gap-4 text-gray-600">
                    <div class="flex items-center">
                        <i data-lucide="calendar" class="w-4 h-4 mr-2"></i>
                        <span>{{ $post->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="hidden md:block w-1 h-1 bg-gray-400 rounded-full"></div>
                    <div class="flex items-center">
                        <i data-lucide="clock" class="w-4 h-4 mr-2"></i>
                        <span>{{ ceil(str_word_count(strip_tags($post->posts_konten)) / 200) }} min read</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Article Content -->
<article class="py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Featured Image -->
            @if($post->posts_gambar_utama)
                <div class="mb-12">
                    <img
                        src="{{ asset('storage/' . $post->posts_gambar_utama) }}"
                        alt="{{ $post->posts_judul }}"
                        class="w-full h-64 md:h-96 object-cover rounded-lg shadow-lg"
                    >
                </div>
            @endif

            <!-- Article Body -->
            <div class="[&>ul]:list-disc [&>ul]:ms-6 [&>ol]:list-decimal [&>ol]:ms-6 [&>li]:mb-1">
                {!! $post->posts_konten !!}
            </div>
        </div>
    </div>
</article>

<!-- Related Posts -->
@if($relatedPosts->count() > 0)
<section class="bg-gray-50 py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-3xl font-bold text-center mb-12">Related Articles</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($relatedPosts as $relatedPost)
                    <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <!-- Image -->
                        <div class="h-40 bg-gray-300 relative">
                            @if($relatedPost->posts_gambar_utama)
                                <img
                                    src="{{ asset('storage/' . $relatedPost->posts_gambar_utama) }}"
                                    alt="{{ $relatedPost->posts_judul }}"
                                    class="w-full h-full object-cover"
                                >
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center">
                                    <i data-lucide="image" class="w-12 h-12 text-white opacity-50"></i>
                                </div>
                            @endif
                        </div>

                        <!-- Content -->
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-2 line-clamp-2">
                                <a href="{{ route('frontend.blog.show', $relatedPost->posts_slug) }}" class="hover:text-blue-600 transition-colors">
                                    {{ $relatedPost->posts_judul }}
                                </a>
                            </h3>

                            <div class="text-gray-500 text-sm mb-3">
                                {{ $relatedPost->created_at->format('M d, Y') }}
                            </div>

                            <p class="text-gray-600 text-sm line-clamp-2">
                                {{ Str::limit(strip_tags($relatedPost->posts_deskripsi ?: $relatedPost->posts_konten), 100) }}
                            </p>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

<!-- Back to Blog -->
<div class="py-8 text-center">
    <a 
        href="{{ route('frontend.blog.index') }}"
        class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
    >
        <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
        Back to Blog
    </a>
</div>
@endsection