@extends('frontend.layouts.app')

@section('title', 'Blog')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-r from-green-600 to-blue-600 text-white py-16">
    <div class="container mx-auto px-4">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Our Blog</h1>
            <p class="text-xl opacity-90">Discover amazing articles and insights</p>
        </div>
    </div>
</div>

<!-- Search & Filter Section -->
<div class="bg-gray-50 py-8">
    <div class="container mx-auto px-4">
        <form method="GET" action="{{ route('frontend.blog.index') }}" class="flex flex-col md:flex-row gap-4">
            <!-- Search Input -->
            <div class="flex-1">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}"
                    placeholder="Search articles..." 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                >
            </div>
            
            <!-- Category Filter -->
            <div class="md:w-48">
                <select 
                    name="category" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                >
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <!-- Search Button -->
            <button 
                type="submit"
                class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
            >
                Search
            </button>
            
            @if(request('search') || request('category'))
                <a 
                    href="{{ route('frontend.blog.index') }}"
                    class="px-6 py-3 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors"
                >
                    Clear
                </a>
            @endif
        </form>
    </div>
</div>

<!-- Blog Posts Grid -->
<div class="py-16">
    <div class="container mx-auto px-4">
        @if($posts->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                @foreach($posts as $post)
                    <article class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                        <!-- Featured Image -->
                        <div class="h-48 bg-gray-300 relative">
                            @if($post->featured_image)
                                <img 
                                    src="{{ asset('storage/' . $post->featured_image) }}" 
                                    alt="{{ $post->title }}"
                                    class="w-full h-full object-cover"
                                >
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center">
                                    <i data-lucide="image" class="w-16 h-16 text-white opacity-50"></i>
                                </div>
                            @endif
                            
                            <!-- Category Badge -->
                            @if($post->category)
                                <div class="absolute top-3 left-3">
                                    <span class="px-2 py-1 bg-blue-600 text-white text-xs font-medium rounded-full shadow-lg">
                                        {{ $post->category->name }}
                                    </span>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Content -->
                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-2 line-clamp-2">
                                <a href="{{ route('frontend.blog.show', $post->slug) }}" class="hover:text-blue-600 transition-colors">
                                    {{ $post->title }}
                                </a>
                            </h3>
                            
                            <!-- Meta Info -->
                            <div class="flex items-center text-gray-500 text-sm mb-3">
                                <i data-lucide="user" class="w-4 h-4 mr-1"></i>
                                <span class="mr-4">{{ $post->user->name }}</span>
                                <i data-lucide="calendar" class="w-4 h-4 mr-1"></i>
                                <span>{{ $post->created_at->format('M d, Y') }}</span>
                            </div>
                            
                            <!-- Excerpt -->
                            <p class="text-gray-600 mb-4 line-clamp-3">
                                {{ Str::limit(strip_tags($post->content), 150) }}
                            </p>
                            
                            <!-- Read More Link -->
                            <a 
                                href="{{ route('frontend.blog.show', $post->slug) }}"
                                class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium"
                            >
                                Read More
                                <i data-lucide="arrow-right" class="w-4 h-4 ml-1"></i>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="flex justify-center">
                {{ $posts->withQueryString()->links() }}
            </div>
        @else
            <!-- No Posts Found -->
            <div class="text-center py-16">
                <div class="max-w-md mx-auto">
                    <i data-lucide="search-x" class="w-16 h-16 text-gray-400 mx-auto mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">No posts found</h3>
                    <p class="text-gray-500 mb-6">
                        @if(request('search'))
                            No posts match your search for "{{ request('search') }}"
                        @else
                            No blog posts available at the moment.
                        @endif
                    </p>
                    @if(request('search') || request('category'))
                        <a 
                            href="{{ route('frontend.blog.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
                        >
                            <i data-lucide="refresh-ccw" class="w-4 h-4 mr-2"></i>
                            Clear Filters
                        </a>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
@endsection