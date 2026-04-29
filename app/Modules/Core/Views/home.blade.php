@extends('frontend.layouts.app')

@section('title', setting('site_name', config('app.name')))
@section('meta_description', setting('site_description', 'Selamat datang di ' . setting('site_name', config('app.name'))))

@section('content')
<!-- Hero Section -->
@if (isset($heros) && $heros && $heros->count() > 0)
    @php $hero = $heros->first(); @endphp
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-8">
        <div class="bungkus_home grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-20 items-center hero-wrapper">

            <!-- Left: Text Content -->
            <div class="flex flex-col justify-center order-2 lg:order-1">
                <h1 class="c-text-primary text-3xl md:text-4xl lg:text-5xl font-bold leading-tight mb-6 hero-fade-up" style="animation-delay:0s">
                    {{ $hero->hero_title }}
                </h1>
                <p class="c-text-secondary text-lg md:text-xl leading-relaxed mb-10 hero-fade-up" style="animation-delay:0.12s">
                    {{ $hero->hero_keterangan }}
                </p>
                <div class="hero-fade-up" style="animation-delay:0.24s">
                    <a href="{{ route('frontend.products.index') }}"
                       class="c-btn-primary inline-block px-8 py-3 rounded-full font-semibold text-sm transition-all hover:opacity-90 hover:scale-105">
                        Lihat Produk
                    </a>
                </div>
            </div>

            <!-- Right: Image -->
            <div class="rounded-3xl overflow-hidden bg-gray-200 order-1 lg:order-2 h-96 lg:h-full hero-fade-right" style="min-height: 350px;">
                @if($hero->hero_image)
                    <img src="{{ asset('storage/' . $hero->hero_image) }}"
                         alt="{{ $hero->hero_title }}"
                         class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center" style="background-color: var(--color-bg-card);">
                        <i data-lucide="image" class="w-16 h-16 opacity-20"></i>
                    </div>
                @endif
            </div>

        </div>
    </div>
@endif

<!-- About Section -->
@php $headerAbout = DB::table('header')->where('header_section', 'about')->first(); @endphp
<section id="about" class="about-section py-12 lg:py-16">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        @if($abouts && $abouts->count() > 0)
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16 items-center">

            <!-- Kiri: Image stack -->
            <div class="about-image-wrap relative" data-aos="fade-right">
                <!-- Gambar utama -->
                <div class="relative rounded-3xl overflow-hidden" style="aspect-ratio: 4/5;">
                    @if($abouts->first()->tentang_gambar)
                        <img src="{{ asset('storage/' . $abouts->first()->tentang_gambar) }}"
                             alt="{{ $abouts->first()->tentang_judul }}"
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center" style="background:#f0ebe4;">
                            <i data-lucide="coffee" class="w-16 h-16 opacity-20"></i>
                        </div>
                    @endif
                    <!-- Overlay gradient bawah -->
                    <div class="absolute inset-0" style="background: linear-gradient(to top, rgba(0,0,0,0.35) 0%, transparent 50%);"></div>
                </div>

                <!-- Badge float — tahun berdiri -->
                @if($abouts->first()->tentang_tahun_berdiri)
                <div class="about-badge-year" data-aos="fade-up" data-aos-delay="200">
                    <span class="block text-2xl font-bold c-text-primary">{{ $abouts->first()->tentang_tahun_berdiri }}</span>
                    <span class="block text-xs c-text-muted uppercase tracking-widest">Berdiri</span>
                </div>
                @endif

                <!-- Badge float — origin -->
                <!-- @if($abouts->first()->tentang_jumlah_origin)
                <div class="about-badge-origin" data-aos="fade-up" data-aos-delay="300">
                    <i data-lucide="map-pin" class="w-3.5 h-3.5 c-text-accent flex-shrink-0"></i>
                    <span class="text-xs font-semibold c-text-primary">{{ $abouts->first()->tentang_jumlah_origin }} Origins</span>
                </div>
                @endif -->
            </div>

            <!-- Kanan: Content -->
            <div data-aos="fade-left">
                <!-- Label -->
                <p class="about-label">— Tentang Kami</p>

                <!-- Heading -->
                <h2 class="text-4xl lg:text-5xl font-bold leading-tight mb-6 c-text-primary">
                    {{ $abouts->first()->tentang_judul ?? ($headerAbout->header_title ?? 'Bukan Sekadar Kopi Biasa') }}
                </h2>

                <!-- Body text -->
                <p class="text-base leading-relaxed mb-8 c-text-secondary">
                    {!! Str::limit(strip_tags($abouts->first()->tentang_konten), 280) !!}...
                </p>

                <!-- Stats row -->
                @php
                    $aboutStats = collect([
                        ['value' => $abouts->first()->tentang_jumlah_origin,      'label' => 'Origin Kopi'],
                        ['value' => $abouts->first()->tentang_jumlah_pelanggan,   'label' => 'Pelanggan'],
                        ['value' => $abouts->first()->tentang_jumlah_fresh_roast, 'label' => 'Fresh Roast'],
                    ])->filter(fn($s) => !empty($s['value']))->values();
                @endphp
                @if($aboutStats->count() > 0)
                <div class="about-stats">
                    @foreach($aboutStats as $i => $stat)
                        @if($i > 0)
                        <div class="about-stat-divider"></div>
                        @endif
                        <div class="about-stat" data-aos="fade-up" data-aos-delay="{{ ($i + 1) * 100 }}">
                            <span class="about-stat-num">{{ $stat['value'] }}</span>
                            <span class="about-stat-label">{{ $stat['label'] }}</span>
                        </div>
                    @endforeach
                </div>
                @endif

                <!-- CTA -->
                <a href="{{ route('frontend.abouts.index') }}" class="about-cta-link">
                    Baca Cerita Lengkap
                    <i data-lucide="arrow-right" class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1"></i>
                </a>
            </div>

        </div>
        @else
        <div class="py-12 text-center">
            <i data-lucide="info" class="w-10 h-10 mx-auto mb-3 opacity-20"></i>
            <p class="text-sm opacity-50">Informasi tentang kami sedang dipersiapkan.</p>
        </div>
        @endif

    </div>
</section>

<!-- Services Section -->
@php $headerServices = DB::table('header')->where('header_section', 'services')->first(); @endphp
<section id="services" class="services-section py-12 lg:py-16">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-4" data-aos="fade-up">
            <div>
                <p class="about-label">— Layanan</p>
                <h2 class="text-4xl lg:text-5xl font-bold c-text-primary leading-tight">
                    {{ $headerServices->header_title ?? 'Layanan Kami' }}
                </h2>
            </div>
            @if(!empty($headerServices->header_subtitle))
                <p class="c-text-secondary text-sm max-w-xs leading-relaxed md:text-right">{{ $headerServices->header_subtitle }}</p>
            @endif
        </div>

        @if($services && $services->count() > 0)
        <div class="svc-showcase">
            @foreach($services as $service)
            <div class="svc-showcase-item" data-aos="fade-up" data-aos-delay="{{ $loop->index * 150 }}">

                <!-- Full bleed image -->
                <div class="svc-showcase-img">
                    @if($service->layanan_gambar)
                        <img src="{{ asset('storage/' . $service->layanan_gambar) }}"
                             alt="{{ $service->layanan_nama }}"
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center" style="background:#1a1a1a;">
                            <i data-lucide="coffee" class="w-12 h-12 opacity-20" style="color:#fff;"></i>
                        </div>
                    @endif

                    <!-- Gradient overlay -->
                    <div class="svc-showcase-overlay"></div>

                    <!-- Nomor -->
                    <span class="svc-showcase-num">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                </div>

                <!-- Teks di bawah gambar -->
                <div class="svc-showcase-body">
                    <h3 class="svc-showcase-title">{{ $service->layanan_nama }}</h3>
                    <p class="svc-showcase-desc">{{ Str::limit($service->layanan_deskripsi, 200) }}</p>
                </div>

            </div>
            @endforeach
        </div>
        @else
        <div class="py-12 text-center">
            <i data-lucide="settings" class="w-10 h-10 mx-auto mb-3 opacity-20"></i>
            <p class="text-sm opacity-50">Layanan sedang dipersiapkan.</p>
        </div>
        @endif

    </div>
</section>

<!-- Latest Posts Section -->
<!-- <section id="blog" class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold mb-4">Latest Articles</h2>
            <p>Stay updated with our latest blog posts</p>
        </div>

        @if($latestPosts->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($latestPosts as $post)
            <article class="rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow border border-current border-opacity-10">
                <div class="h-48 flex items-center justify-center">
                    @if($post->posts_gambar_utama)
                        <img src="{{ asset('storage/' . $post->posts_gambar_utama) }}"
                             alt="{{ $post->posts_judul }}"
                             class="w-full h-full object-cover">
                    @else
                        <i data-lucide="image" class="w-12 h-12 opacity-40"></i>
                    @endif
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-2">
                        @if($post->category)
                            <span class="text-xs px-2 py-1 rounded border border-current border-opacity-30">
                                {{ $post->category->kategori_nama }}
                            </span>
                        @endif
                        <span class="text-sm ml-auto opacity-60">
                            {{ $post->created_at->format('M d, Y') }}
                        </span>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">{{ $post->posts_judul }}</h3>
                    <p class="mb-4 opacity-80">{{ Str::limit($post->posts_deskripsi ?: strip_tags($post->posts_konten), 100) }}</p>
                    <a href="{{ route('frontend.blog.show', $post->posts_slug) }}" class="font-medium underline">
                        Read More &rarr;
                    </a>
                </div>
            </article>
            @endforeach
        </div>
        @else
        <div class="text-center py-12">
            <i data-lucide="file-text" class="w-16 h-16 mx-auto mb-4 opacity-40"></i>
            <p>No articles published yet.</p>
        </div>
        @endif
    </div>
</section> -->

<!-- Featured Products Section -->
@php $headerProducts = DB::table('header')->where('header_section', 'products')->first(); @endphp
<section id="products" class="py-12 lg:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-10" data-aos="fade-up">
            <p class="text-xs font-bold uppercase tracking-widest opacity-40 mb-2">— Pilihan Unggulan</p>
            <div class="flex items-end justify-between items-center">
                <h2 class="text-3xl font-bold">{{ $headerProducts->header_title ?? 'Produk Unggulan' }}</h2>
                <a href="{{ route('frontend.products.index') }}" class="text-sm font-semibold opacity-60 hover:opacity-100 transition inline-flex items-center gap-1">
                    Lihat Semua <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>
            @if(!empty($headerProducts->header_subtitle))
                <p class="text-sm opacity-60 mt-2">{{ $headerProducts->header_subtitle }}</p>
            @endif
        </div>

        @if($featuredProducts->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($featuredProducts as $product)
                    <div data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <x-product-card :product="$product" />
                    </div>
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
<section id="projects" class="py-12 lg:py-16" style="border-top:1px solid var(--color-border);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-10" data-aos="fade-up">
            <p class="text-xs font-bold uppercase tracking-widest opacity-40 mb-2">— Our Work</p>
            <div class="flex items-center justify-between">
                <h2 class="text-3xl font-bold c-text-primary">Projects</h2>
                <a href="{{ route('frontend.reels.index') }}"
                   class="text-sm font-semibold opacity-60 hover:opacity-100 transition inline-flex items-center gap-1 c-text-primary">
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
                            <span class="text-xs font-semibold uppercase tracking-wider truncate mx-3 c-text-primary" style="opacity:0.4;">
                                {{ $reel->reel_judul }}
                            </span>
                        @endif
                        <svg class="w-3.5 h-3.5 flex-shrink-0 transition-transform group-hover:translate-x-0.5 group-hover:-translate-y-0.5 c-text-primary"
                             style="opacity:0.4;"
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
                <p class="opacity-50 text-sm">Belum ada project.</p>
            </div>
        @endif
    </div>
</section>

<!-- Section Teams -->
<!-- <section id="teams" class="py-16">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-10 text-center">
            <p class="text-xs font-bold uppercase tracking-widest opacity-40 mb-2">— Tim Kami</p>
            <h2 class="text-3xl font-bold" class="c-text-primary">{{ $headerTeams->header_title ?? 'Tim Kami' }}</h2>
            @if(!empty($headerTeams->header_subtitle))
                <p class="text-sm opacity-60 mt-2">{{ $headerTeams->header_subtitle }}</p>
            @endif
        </div>

        @if($teams && $teams->count() > 0)
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            @foreach($teams as $team)
            <div class="text-center">
                <div class="w-24 h-24 mx-auto mb-4 rounded-full overflow-hidden bg-stone-100">
                    @if($team->tim_gambar)
                        <img src="{{ asset('storage/' . $team->tim_gambar) }}"
                             alt="{{ $team->tim_nama }}"
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center opacity-30">
                            <i data-lucide="user" class="w-10 h-10"></i>
                        </div>
                    @endif
                </div>
                <h3 class="text-sm font-bold" class="c-text-primary">{{ $team->tim_nama }}</h3>
                @if($team->category)
                    <p class="text-xs opacity-50 mt-1">{{ $team->category->kategori_nama }}</p>
                @endif
            </div>
            @endforeach
        </div>
        @else
        <div class="py-12 text-center">
            <i data-lucide="users" class="w-10 h-10 mx-auto mb-3 opacity-20"></i>
            <p class="text-sm opacity-50">Informasi tim sedang dipersiapkan.</p>
        </div>
        @endif
    </div>
</section> -->

<!-- Our Clients / Partners -->
<section id="our-clients" class="py-12 lg:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <p class="text-xs font-bold uppercase tracking-widest opacity-40 mb-3">— Mitra</p>
            <h2 class="text-4xl lg:text-5xl font-bold c-text-primary mb-4">{{ $headerClients->header_title ?? 'Mitra Kami' }}</h2>
            @if(!empty($headerClients->header_subtitle))
                <p class="text-base opacity-70 max-w-2xl mx-auto">{{ $headerClients->header_subtitle }}</p>
            @endif
        </div>

        @if($ourClients && $ourClients->count() > 0)
        @php
            $cardW = 220; // px
            $gap   = 24;  // px
        @endphp
        <!-- Slider wrapper -->
        <div class="overflow-hidden py-6">
            <div id="client-track" class="flex items-center" style="gap: {{ $gap }}px; will-change: transform;">
                @foreach([...$ourClients, ...$ourClients] as $i => $client)
                <div class="flex-shrink-0 group transition-all duration-300"
                     style="width: {{ $cardW }}px; height: 110px;">
                    <!-- Simple Clean Card -->
                    <div class="w-full h-full rounded-xl flex items-center justify-center p-6 transition-all duration-300"
                         style="background: #ffffff;
                                border: 1px solid var(--color-border);
                                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);"
                         onmouseover="this.style.boxShadow='0 6px 16px rgba(0, 0, 0, 0.08)'; this.style.borderColor='rgba(0,0,0,0.12)'"
                         onmouseout="this.style.boxShadow='0 4px 12px rgba(0, 0, 0, 0.05)'; this.style.borderColor='var(--color-border)'">
                        @if($client->klien_gambar)
                            <img src="{{ asset('storage/' . $client->klien_gambar) }}"
                                 alt="{{ $client->klien_nama }}"
                                 class="w-full h-full object-contain transition-all duration-300"
                                 style="filter: grayscale(100%); opacity: 0.8;"
                                 onmouseover="this.style.filter='grayscale(0%)'; this.style.opacity='1'"
                                 onmouseout="this.style.filter='grayscale(100%)'; this.style.opacity='0.8'">
                        @else
                            <span class="text-xs font-semibold c-text-secondary text-center line-clamp-2">{{ $client->klien_nama }}</span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <script>
        (function() {
            const track   = document.getElementById('client-track');
            const total   = {{ $ourClients->count() }};
            const cardW   = {{ $cardW }};
            const gap     = {{ $gap }};
            const halfW   = (cardW + gap) * total;
            let x = 0;
            function animate() {
                x -= 0.5;
                if (Math.abs(x) >= halfW) x = 0;
                track.style.transform = 'translateX(' + x + 'px)';
                requestAnimationFrame(animate);
            }
            animate();
        })();
        </script>
        @else
        <div class="py-16 text-center rounded-2xl" style="background:rgba(0,0,0,0.02);">
            <i data-lucide="briefcase" class="w-12 h-12 mx-auto mb-4 opacity-20"></i>
            <p class="text-sm opacity-60">Informasi mitra sedang dipersiapkan.</p>
        </div>
        @endif
    </div>
</section>

<!-- Testimonials -->
<!-- <section class="py-16">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-10 text-center">
            <p class="text-xs font-bold uppercase tracking-widest opacity-40 mb-2">— Testimoni</p>
            <h2 class="text-3xl font-bold" class="c-text-primary">{{ $headerTestimonials->header_title ?? 'Kata Mereka' }}</h2>
            @if(!empty($headerTestimonials->header_subtitle))
                <p class="text-sm opacity-60 mt-2">{{ $headerTestimonials->header_subtitle }}</p>
            @endif
        </div>

        @if($testimonials && $testimonials->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($testimonials as $testimonial)
            <div class="border border-stone-200 rounded-2xl p-6">
                <p class="text-sm leading-relaxed opacity-75 mb-6 italic">"{{ $testimonial->testimoni_isi }}"</p>
                <div class="flex items-center gap-3">
                    @if($testimonial->testimoni_gambar)
                        <img src="{{ asset('storage/' . $testimonial->testimoni_gambar) }}"
                             alt="{{ $testimonial->testimoni_nama }}"
                             class="w-10 h-10 rounded-full object-cover">
                    @else
                        <div class="w-10 h-10 rounded-full bg-stone-100 flex items-center justify-center">
                            <i data-lucide="user" class="w-5 h-5 opacity-30"></i>
                        </div>
                    @endif
                    <span class="text-sm font-bold" class="c-text-primary">{{ $testimonial->testimoni_nama }}</span>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="py-12 text-center">
            <i data-lucide="message-square" class="w-10 h-10 mx-auto mb-3 opacity-20"></i>
            <p class="text-sm opacity-50">Belum ada testimoni.</p>
        </div>
        @endif
    </div>
</section> -->

@endsection
