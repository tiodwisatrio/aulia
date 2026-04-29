@extends('frontend.layouts.app')

@section('title', setting('site_name', config('app.name')))

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-r from-green-600 to-blue-600 text-white py-16">
    <div class="container mx-auto px-4">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Welcome To CMS Gue</h1>
            <p class="text-xl opacity-90">Discover amazing products and services</p>
        </div>
    </div>
</div>

<!-- About Section -->
<section id="about" class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">About Us</h2>
            <p class="text-gray-600">Learn more about our mission and values</p>
        </div>

        @if($abouts && $abouts->count() > 0)
        <div class="bg-white rounded-lg shadow-md overflow-hidden md:flex md:items-stretch">
            {{-- Gambar di kiri --}}
            @if($abouts->first()->image)
            <div class="md:w-1/2 h-80 md:h-auto flex-shrink-0">
                <img src="{{ asset('storage/' . $abouts->first()->image) }}" 
                     alt="{{ $abouts->first()->title }}" 
                     class="w-full h-full object-cover rounded-t-lg md:rounded-l-lg md:rounded-tr-none">
            </div>
            @endif

            {{-- Konten di kanan --}}
            <div class="md:w-1/2 p-6 flex flex-col justify-center">
                <h3 class="text-2xl font-semibold text-gray-900 mb-4">{{ $abouts->first()->title }}</h3>
                <p class="text-gray-700 leading-relaxed">{{ $abouts->first()->content }}</p>
            </div>
        </div>
        @else
        <div class="text-center py-12">
            <i data-lucide="info" class="w-16 h-16 text-gray-400 mx-auto mb-4"></i>
            <p class="text-gray-600">About section is not available at the moment.</p>
        </div>
        @endif
    </div>
</section>

<!-- Services Section -->
<section id="services" class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Our Services</h2>
            <p class="text-gray-600">Explore the services we offer to our customers</p>
        </div>

        @if($services && $services->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($services as $service)
            <div class="bg-white rounded-lg shadow-sm p-6 hover:shadow-lg transition-shadow">
                <!-- Ambil image service -->
                @if($service->image)
                    <div class="h-40 bg-gray-200 mb-4 flex items-center justify-center">
                        <img src="{{ asset('storage/' . $service->image) }}" 
                             alt="{{ $service->name }}" 
                             class="w-full h-full object-cover rounded-lg">
                    </div>
                @endif
                <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $service->name }}</h3>
                <p class="text-gray-600">{{ Str::limit($service->description, 120) }}</p>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-12">
            <i data-lucide="settings" class="w-16 h-16 text-gray-400 mx-auto mb-4"></i>
            <p class="text-gray-600">No services available at the moment.</p>
        </div>
        @endif
    </div>
</section>



<!-- Latest Posts Section -->
<section id="blog" class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Latest Articles</h2>
            <p class="text-gray-600">Stay updated with our latest blog posts</p>
        </div>
        
        @if($latestPosts->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($latestPosts as $post)
            <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                <div class="h-48 bg-gray-200 flex items-center justify-center">
                    @if($post->featured_image)
                        <img src="{{ asset('storage/' . $post->featured_image) }}" 
                             alt="{{ $post->title }}" 
                             class="w-full h-full object-cover">
                    @else
                        <i data-lucide="image" class="w-12 h-12 text-gray-400"></i>
                    @endif
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-2">
                        @if($post->category)
                            <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">
                                {{ $post->category->name }}
                            </span>
                        @endif
                        <span class="text-gray-500 text-sm ml-auto">
                            {{ $post->created_at->format('M d, Y') }}
                        </span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $post->title }}</h3>
                    <p class="text-gray-600 mb-4">{{ Str::limit($post->description, 100) }}</p>
                    <a href="{{ route('frontend.blog.show', $post) }}" class="text-blue-600 font-medium hover:text-blue-700">
                        Read More →
                    </a>
                </div>
            </article>
            @endforeach
        </div>
        @else
        <div class="text-center py-12">
            <i data-lucide="file-text" class="w-16 h-16 text-gray-400 mx-auto mb-4"></i>
            <p class="text-gray-600">No articles published yet.</p>
        </div>
        @endif
    </div>
</section>

<!-- Featured Products Section -->
<section id="products" class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-10">
            <p class="text-xs font-bold uppercase tracking-widest opacity-40 mb-2">— Pilihan Unggulan</p>
            <div class="flex items-end justify-between">
                <h2 class="text-3xl font-bold">Produk Unggulan</h2>
                <a href="{{ route('frontend.products.index') }}" class="text-sm font-semibold opacity-60 hover:opacity-100 transition inline-flex items-center gap-1">
                    Lihat Semua <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>
        </div>

        @if($featuredProducts->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($featuredProducts as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <i data-lucide="coffee" class="w-12 h-12 mx-auto mb-4 opacity-20"></i>
                <p class="opacity-50 text-sm">Belum ada produk unggulan.</p>
            </div>
        @endif
    </div>
</section>

<x-cart-script />

<!-- Projects / Reels Section -->
<section id="projects" class="py-16" style="border-top:1px solid var(--color-border);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-10">
            <p class="text-xs font-bold uppercase tracking-widest opacity-40 mb-2" style="color:var(--color-text-muted);">— Our Work</p>
            <div class="flex items-end justify-between">
                <h2 class="text-3xl font-bold" style="color:var(--color-text-primary);">Projects</h2>
                <a href="{{ route('frontend.reels.index') }}"
                   class="text-sm font-semibold transition inline-flex items-center gap-1 hover:opacity-100"
                   style="color:var(--color-text-muted);">
                    Lihat Semua <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>
        </div>

        @if($reels->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($reels as $reel)
                @php $idx = $loop->index + 1; @endphp
                <a href="{{ $reel->reel_url }}" target="_blank" rel="noopener"
                   class="group block rounded-2xl overflow-hidden"
                   style="background:var(--color-bg-card); border:1px solid var(--color-border);"
                   data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 80 }}">

                    <div class="relative aspect-[3/2] overflow-hidden" style="background:var(--color-bg-card);">
                        @if($reel->reel_thumbnail)
                            <img src="{{ asset('storage/' . $reel->reel_thumbnail) }}"
                                 alt="{{ $reel->reel_judul ?? 'Project' }}"
                                 class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-110">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <span class="text-7xl font-black select-none" style="color:var(--color-border);">
                                    {{ str_pad($idx, 2, '0', STR_PAD_LEFT) }}
                                </span>
                            </div>
                        @endif

                        <div class="absolute inset-0 flex flex-col justify-between p-5 opacity-0 group-hover:opacity-100 transition-all duration-300"
                             style="background:rgba(0,0,0,0.55);">
                            <span class="text-xs font-bold tracking-widest" style="color:rgba(255,255,255,0.4);">
                                {{ str_pad($idx, 2, '0', STR_PAD_LEFT) }}
                            </span>
                            <div>
                                @if($reel->reel_judul)
                                    <p class="font-black text-lg uppercase leading-tight mb-3 tracking-tight" style="color:#fff;">
                                        {{ $reel->reel_judul }}
                                    </p>
                                @endif
                                <span class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-widest pb-0.5"
                                      style="color:rgba(255,255,255,0.8); border-bottom:1px solid rgba(255,255,255,0.3);">
                                    <svg class="w-3.5 h-3.5 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                    </svg>
                                    Lihat di Instagram
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between px-4 py-3" style="border-top:1px solid var(--color-border);">
                        <span class="text-xs font-black tracking-widest" style="color:var(--color-border);">
                            {{ str_pad($idx, 2, '0', STR_PAD_LEFT) }}
                        </span>
                        @if($reel->reel_judul)
                            <span class="text-xs font-semibold uppercase tracking-wider truncate mx-3" style="color:var(--color-text-muted);">
                                {{ $reel->reel_judul }}
                            </span>
                        @endif
                        <svg class="w-3.5 h-3.5 flex-shrink-0 transition-transform group-hover:translate-x-0.5 group-hover:-translate-y-0.5"
                             style="color:var(--color-text-muted);"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path d="M7 17L17 7M17 7H7M17 7v10"/>
                        </svg>
                    </div>
                </a>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <i data-lucide="video" class="w-12 h-12 mx-auto mb-4 opacity-20"></i>
                <p class="text-sm opacity-50">Belum ada project.</p>
            </div>
        @endif
    </div>
</section>

<!-- Section Teams -->
 <section id="teams" class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Meet Our Team</h2>
            <p class="text-gray-600">The people behind our success</p>
        </div>

        @if($teams && $teams->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($teams as $team)
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                @if($team->image)
                    <div class="h-40 w-40 mx-auto mb-4">
                        <img src="{{ asset('storage/' . $team->image) }}" 
                             alt="{{ $team->name }}" 
                             class="w-full h-full object-cover rounded-full">
                    </div>
                @endif
                <h3 class="text-xl font-semibold text-gray-900 mb-2 text-center">{{ $team->name }}</h3>
                <p class="text-gray-500 text-center">{{ $team->position }}</p>
                <span class="text-gray-700 text-center">{{ $team->category ? $team->category->name : '' }}</span>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-12">
            <i data-lucide="users" class="w-16 h-16 text-gray-400 mx-auto mb-4"></i>
            <p class="text-gray-600">No team members to display at the moment.</p>
        </div>
        @endif
    </div>
 </section>

<section id="our-clients" class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Our Clients</h2>
            <p class="text-gray-600">Trusted by these amazing companies</p>
        </div>

        @if($ourClients && $ourClients->count() > 0)
        <div class="flex items-center justify-center space-x-8 overflow-x-auto py-4">
            @foreach($ourClients as $client)
            <div class="flex-shrink-0 w-32 h-32 flex items-center justify-center bg-white rounded-lg shadow-md p-4">
                @if($client->image)
                    <img src="{{ asset('storage/' . $client->image) }}" 
                         alt="{{ $client->name }}" 
                         class="max-w-full max-h-full object-contain">
                @else
                    <i data-lucide="users" class="w-12 h-12 text-gray-400"></i>
                @endif
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-12">
            <i data-lucide="users" class="w-16 h-16 text-gray-400 mx-auto mb-4"></i>
            <p class="text-gray-600">No clients to display at the moment.</p>
        </div>
        @endif
    </div>
</section>

<!-- Testimonials -->
 <section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">What Our Clients Say</h2>
            <p class="text-gray-600">Testimonials from our valued clients</p>
        </div>

        @if($testimonials && $testimonials->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($testimonials as $testimonial)
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                <div class="mb-4">
                    <i data-lucide="quote" class="w-8 h-8 text-blue-600"></i>
                </div>
                <p class="text-gray-700 italic mb-4">"{{ $testimonial->content }}"</p>
                <div class="flex items-center">
                    @if($testimonial->image)
                        <img src="{{ asset('storage/' . $testimonial->image) }}" 
                             alt="{{ $testimonial->name }}" 
                             class="w-12 h-12 rounded-full object-cover mr-4">
                    @else
                        <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center mr-4">
                            <i data-lucide="user" class="w-6 h-6 text-gray-400"></i>
                        </div>
                    @endif
                    <div>
                        <h4 class="text-gray-900 font-semibold">{{ $testimonial->name }}</h4>
                        <span class="text-gray-500 text-sm">{{ $testimonial->position }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-12">
            <i data-lucide="message-square" class="w-16 h-16 text-gray-400 mx-auto mb-4"></i>
            <p class="text-gray-600">No testimonials available at the moment.</p>
        </div>
        @endif
    </div>
</section>

@endsection