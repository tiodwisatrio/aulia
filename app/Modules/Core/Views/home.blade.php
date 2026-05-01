@extends('frontend.layouts.app')

@section('title', setting('site_name', config('app.name')))
@section('meta_description', setting('site_description', 'Selamat datang di ' . setting('site_name', config('app.name'))))

@section('no_navbar_spacer', true)

@section('content')

{{-- ═══════════════════════════════════════════════════════
    HERO — Full-viewport cinematic dengan teks di tengah
═══════════════════════════════════════════════════════ --}}
@if (isset($heros) && $heros && $heros->count() > 0)
@php $hero = $heros->first(); @endphp

<section class="relative w-full overflow-hidden" style="height: 100svh; min-height: 560px;">

    {{-- Background image --}}
    @if($hero->hero_image)
    <div class="absolute inset-0"
         style="background-image: url('{{ asset('storage/' . $hero->hero_image) }}');
                background-size: cover;
                background-position: center;
                background-attachment: fixed;">
        <div class="absolute inset-0" style="background: linear-gradient(to bottom, rgba(0,0,0,0.45) 0%, rgba(0,0,0,0.75) 100%);"></div>
    </div>
    @else
    <div class="absolute inset-0" style="background: var(--color-bg-card);"></div>
    @endif

    {{-- Content center --}}
    <div class="relative z-10 h-full flex flex-col items-center justify-center text-center px-6">
        <p class="text-xs font-bold uppercase tracking-[0.3em] mb-6" style="color:rgba(255,255,255,0.6);">
            — {{ setting('site_name', config('app.name')) }}
        </p>

        <h1 class="text-2xl md:text-4xl lg:text-6xl font-black leading-none text-white mb-6 hero-fade-up"
            style="text-shadow: 0 2px 32px rgba(0,0,0,0.4); max-width: 900px; animation-delay:0s;">
            {{ $hero->hero_title }}
        </h1>

        <p class="text-base md:text-lg leading-relaxed mb-10 hero-fade-up max-w-xl"
           style="color:rgba(255,255,255,0.8); animation-delay:0.15s;">
            {{ $hero->hero_keterangan }}
        </p>

        <div class="hero-fade-up" style="animation-delay:0.3s;">
            <a href="{{ route('frontend.products.index') }}"
               class="inline-flex items-center gap-3 px-8 py-4 rounded-full font-bold text-sm tracking-wide transition-all duration-300 hover:gap-5"
               style="background:#fff; color:#000;">
                Lihat Produk
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>
    </div>

    {{-- Scroll indicator --}}
    <!-- <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 z-10" style="color:rgba(255,255,255,0.5);">
        <span class="text-xs tracking-widest uppercase">Scroll</span>
        <div class="w-px h-12" style="background: linear-gradient(to bottom, rgba(255,255,255,0.5), transparent);"></div>
    </div> -->

</section>


@endif


{{-- ═══════════════════════════════════════════════════════
    ABOUT — Teks besar di kiri, image melayang di kanan
═══════════════════════════════════════════════════════ --}}
@php $headerAbout = DB::table('header')->where('header_section', 'about')->first(); @endphp

@if($abouts && $abouts->count() > 0)
@php
    $aboutStats = collect([
        ['value' => $abouts->first()->tentang_jumlah_origin,      'label' => 'Origin Kopi'],
        ['value' => $abouts->first()->tentang_jumlah_pelanggan,   'label' => 'Pelanggan'],
        ['value' => $abouts->first()->tentang_jumlah_fresh_roast, 'label' => 'Fresh Roast'],
    ])->filter(fn($s) => !empty($s['value']))->values();
@endphp

<section id="about" class="py-20 lg:py-28" style="border-top: 1px solid var(--color-border);">
    <div class="max-w-6xl mx-auto px-8 md:px-14">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-24 items-center">

            {{-- Kiri: Gambar bersih --}}
            <div class="relative" data-aos="fade-right">
                <div class="overflow-hidden" style="aspect-ratio: 4/5;">
                    @if($abouts->first()->tentang_gambar)
                        <img src="{{ asset('storage/' . $abouts->first()->tentang_gambar) }}"
                             alt="{{ $abouts->first()->tentang_judul }}"
                             class="w-full h-full object-cover transition-transform duration-700 hover:scale-105">
                    @else
                        <div class="w-full h-full flex items-center justify-center" style="background: var(--color-bg-card);">
                            <i data-lucide="coffee" class="w-12 h-12 opacity-10"></i>
                        </div>
                    @endif
                </div>

                {{-- Tahun — tipis, di bawah gambar --}}
                @if($abouts->first()->tentang_tahun_berdiri)
                <p class="text-xs tracking-[0.2em] uppercase c-text-secondary mt-4">
                    Est. {{ $abouts->first()->tentang_tahun_berdiri }}
                </p>
                @endif
            </div>

            {{-- Kanan: Konten --}}
            <div data-aos="fade-left" data-aos-delay="80">

                <p class="text-xs tracking-[0.25em] uppercase c-text-secondary mb-8">— Tentang Kami</p>

                <h2 class="font-bold c-text-primary leading-tight mb-6"
                    style="font-size: clamp(1.75rem, 3.5vw, 2.75rem);">
                    {{ $abouts->first()->tentang_judul ?? ($headerAbout->header_title ?? 'Bukan Sekadar Kopi Biasa') }}
                </h2>

                <p class="text-sm leading-loose c-text-secondary mb-10" style="max-width: 400px;">
                    {!! Str::limit(strip_tags($abouts->first()->tentang_konten), 240) !!}...
                </p>

                {{-- Stats: hanya angka + label, tanpa box --}}
                @if($aboutStats->count() > 0)
                <div class="flex items-start gap-10 mb-10" style="border-top: 1px solid var(--color-border); padding-top: 28px;">
                    @foreach($aboutStats as $stat)
                    <div data-aos="fade-up" data-aos-delay="{{ $loop->index * 70 }}">
                        <span class="block text-3xl font-black c-text-primary leading-none mb-1">{{ $stat['value'] }}</span>
                        <span class="block text-xs uppercase tracking-widest c-text-secondary">{{ $stat['label'] }}</span>
                    </div>
                    @endforeach
                </div>
                @endif

                <a href="{{ route('frontend.abouts.index') }}"
                   class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-widest c-text-primary group">
                    <span style="border-bottom: 1px solid currentColor; padding-bottom: 2px;">Cerita Selengkapnya</span>
                    <i data-lucide="arrow-right" class="w-3.5 h-3.5 transition-transform duration-300 group-hover:translate-x-1"></i>
                </a>

            </div>
        </div>

    </div>
</section>
@endif


{{-- ═══════════════════════════════════════════════════════
    SERVICES — Numbered list dengan divider, bukan card grid
═══════════════════════════════════════════════════════ --}}
@php $headerServices = DB::table('header')->where('header_section', 'services')->first(); @endphp

<section id="services" class="py-20 lg:py-32" style="border-top:1px solid var(--color-border);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-16" data-aos="fade-up">
            <div>
                <p class="about-label mb-2">— Layanan</p>
                <h2 class="text-2xl lg:text-4xl font-black c-text-primary leading-none">
                    {{ $headerServices->header_title ?? 'Layanan Kami' }}
                </h2>
            </div>
            @if(!empty($headerServices->header_subtitle))
            <p class="c-text-secondary text-sm max-w-xs md:text-right leading-relaxed">{{ $headerServices->header_subtitle }}</p>
            @endif
        </div>

        @if($services && $services->count() > 0)
        <div>
            @foreach($services as $service)
            <div class="svc-list-item group py-8 flex flex-col sm:flex-row sm:items-center gap-6 cursor-default"
                 style="border-top: 1px solid var(--color-border);"
                 data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}">

                {{-- Nomor --}}
                <span class="text-xs font-black tracking-widest c-text-secondary flex-shrink-0" style="min-width:36px;">
                    {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                </span>

                {{-- Thumbnail kecil --}}
                @if($service->layanan_gambar)
                <div class="flex-shrink-0 w-16 h-16 rounded-xl overflow-hidden">
                    <img src="{{ asset('storage/' . $service->layanan_gambar) }}"
                         alt="{{ $service->layanan_nama }}"
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                </div>
                @endif

                {{-- Nama + desc --}}
                <div class="flex-1 min-w-0">
                    <h3 class="text-xl lg:text-2xl font-bold c-text-primary mb-1 transition-all duration-300 group-hover:translate-x-1">
                        {{ $service->layanan_nama }}
                    </h3>
                    <p class="text-sm c-text-secondary leading-relaxed max-w-lg">
                        {{ Str::limit($service->layanan_deskripsi, 160) }}
                    </p>
                </div>

                {{-- Arrow --}}
                <div class="flex-shrink-0 opacity-0 group-hover:opacity-100 transition-all duration-300 -translate-x-2 group-hover:translate-x-0">
                    <i data-lucide="arrow-right" class="w-5 h-5 c-text-primary"></i>
                </div>

            </div>
            @endforeach
            <div style="border-top: 1px solid var(--color-border);"></div>
        </div>
        @else
        <div class="py-20 text-center">
            <i data-lucide="settings" class="w-10 h-10 mx-auto mb-3 opacity-20"></i>
            <p class="text-sm opacity-50">Layanan sedang dipersiapkan.</p>
        </div>
        @endif

    </div>
</section>


{{-- ═══════════════════════════════════════════════════════
    PRODUCTS — Featured besar + grid kecil di bawah
═══════════════════════════════════════════════════════ --}}
@php $headerProducts = DB::table('header')->where('header_section', 'products')->first(); @endphp

<section id="products" class="py-20 lg:py-32" style="border-top:1px solid var(--color-border);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex items-end justify-between mb-12" data-aos="fade-up">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.3em] c-text-secondary mb-2">— Pilihan Unggulan</p>
                <h2 class="text-2xl lg:text-4xl font-black c-text-primary leading-none">
                    {{ $headerProducts->header_title ?? 'Produk Unggulan' }}
                </h2>
            </div>
            <a href="{{ route('frontend.products.index') }}"
               class="hidden sm:inline-flex items-center gap-2 text-sm font-bold uppercase tracking-widest c-text-secondary hover:c-text-primary transition-all duration-300 hover:gap-4">
                Lihat Semua <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>

        @if($featuredProducts->count() > 0)
        @php $first = $featuredProducts->first(); $rest = $featuredProducts->skip(1); @endphp

        <div class="mb-4" style="display:grid; grid-template-columns: 3fr 2fr; grid-template-rows: 260px 260px; gap: 12px;">

            {{-- Featured card besar kiri, span 2 baris --}}
            <div data-aos="fade-right" style="grid-row: 1 / 3;">
                <a href="{{ route('frontend.products.show', $first->produk_slug) }}"
                   class="group block relative rounded-3xl overflow-hidden w-full h-full">
                    @if($first->produk_gambar_utama)
                    <img src="{{ asset('storage/' . $first->produk_gambar_utama) }}"
                         alt="{{ $first->produk_nama }}"
                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                    @else
                    <div class="w-full h-full flex items-center justify-center" style="background:var(--color-bg-card);">
                        <i data-lucide="coffee" class="w-16 h-16 opacity-20"></i>
                    </div>
                    @endif
                    <div class="absolute inset-0" style="background:linear-gradient(to top, rgba(0,0,0,0.65) 0%, transparent 55%);"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-6">
                        <p class="text-xs font-bold uppercase tracking-widest mb-2" style="color:rgba(255,255,255,0.5);">Featured</p>
                        <h3 class="text-2xl font-black text-white mb-1">{{ $first->produk_nama }}</h3>
                        @if($first->produk_harga)
                        <span class="text-sm font-bold" style="color:rgba(255,255,255,0.8);">
                            {{ formatYen($first->produk_harga) }}
                        </span>
                        @endif
                    </div>
                </a>
            </div>

            {{-- 4 card compact, masing-masing 1 cell --}}
            @foreach($rest->take(2) as $product)
            <div data-aos="fade-up" data-aos-delay="{{ $loop->index * 60 }}" class="h-full">
                <x-product-card :product="$product" :compact="true" />
            </div>
            @endforeach

        </div>

        {{-- Mobile: stack biasa --}}

        <a href="{{ route('frontend.products.index') }}"
           class="sm:hidden inline-flex items-center gap-2 text-sm font-bold uppercase tracking-widest c-text-secondary mt-4">
            Lihat Semua <i data-lucide="arrow-right" class="w-4 h-4"></i>
        </a>

        @else
        <div class="py-20 text-center">
            <i data-lucide="coffee" class="w-12 h-12 mx-auto mb-4 opacity-20"></i>
            <p class="opacity-50 text-sm">Belum ada produk unggulan.</p>
        </div>
        @endif

    </div>
</section>

<x-cart-script />


{{-- ═══════════════════════════════════════════════════════
    PROJECTS — Masonry 2 kolom: 1 besar + grid kecil
═══════════════════════════════════════════════════════ --}}
<section id="projects" class="py-16 lg:py-20" style="border-top: 1px solid var(--color-border);">
    <div class="max-w-6xl mx-auto px-8 md:px-14">

        <div class="flex items-center justify-between mb-8" data-aos="fade-up">
            <div>
                <p class="text-xs tracking-[0.25em] uppercase c-text-secondary mb-2">— Our Work</p>
                <h2 class="text-3xl font-bold c-text-primary">Projects</h2>
            </div>
            <a href="{{ route('frontend.reels.index') }}"
               class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-widest c-text-secondary hover:c-text-primary transition-all duration-300 group">
                <span style="border-bottom: 1px solid currentColor; padding-bottom: 1px;">Semua</span>
                <i data-lucide="arrow-right" class="w-3.5 h-3.5 transition-transform duration-300 group-hover:translate-x-1"></i>
            </a>
        </div>

        @if($reels->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
            @foreach($reels->take(6) as $reel)
            @php $idx = $loop->index + 1; @endphp

            <a href="{{ $reel->reel_url }}" target="_blank" rel="noopener"
               class="group block overflow-hidden"
               style="border: 1px solid var(--color-border);"
               data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 60 }}">

                {{-- Thumbnail --}}
                <div class="relative overflow-hidden" style="aspect-ratio: 4/3;">
                    @if($reel->reel_thumbnail)
                        <img src="{{ asset('storage/' . $reel->reel_thumbnail) }}"
                             alt="{{ $reel->reel_judul ?? 'Project' }}"
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    @else
                        <div class="w-full h-full flex items-center justify-center" style="background: var(--color-bg-card);">
                            <span class="text-2xl font-black select-none" style="opacity: 0.08;">
                                {{ str_pad($idx, 2, '0', STR_PAD_LEFT) }}
                            </span>
                        </div>
                    @endif

                    {{-- Hover overlay --}}
                    <div class="absolute inset-0 flex items-end p-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                         style="background: rgba(0,0,0,0.45);">
                        <span class="text-xs tracking-widest uppercase text-white/70">Lihat di Instagram</span>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="flex items-center justify-between px-4 py-2.5" style="border-top: 1px solid var(--color-border);">
                    <span class="text-xs tracking-widest c-text-secondary">{{ str_pad($idx, 2, '0', STR_PAD_LEFT) }}</span>
                    @if($reel->reel_judul)
                    <span class="text-xs c-text-secondary truncate mx-3" style="max-width: 120px;">{{ $reel->reel_judul }}</span>
                    @endif
                    <i data-lucide="arrow-up-right" class="w-3 h-3 c-text-secondary flex-shrink-0 transition-transform duration-300 group-hover:translate-x-0.5 group-hover:-translate-y-0.5"></i>
                </div>

            </a>
            @endforeach
        </div>

        @else
        <div class="py-16 text-center">
            <i data-lucide="video" class="w-8 h-8 mx-auto mb-3 opacity-10"></i>
            <p class="text-sm c-text-secondary opacity-60">Belum ada project.</p>
        </div>
        @endif

    </div>
</section>


{{-- ═══════════════════════════════════════════════════════
    CLIENTS — Marquee strip full-width
═══════════════════════════════════════════════════════ --}}
<section id="our-clients" class="py-20 lg:py-28" style="border-top:1px solid var(--color-border);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center mb-12" data-aos="fade-up">
        <p class="text-xs font-bold uppercase tracking-[0.3em] c-text-secondary mb-3">— Dipercaya Oleh</p>
        <h2 class="text-2xl lg:text-4xl font-black c-text-primary">{{ $headerClients->header_title ?? 'Mitra Kami' }}</h2>
        @if(!empty($headerClients->header_subtitle))
        <p class="text-sm c-text-secondary mt-3 max-w-lg mx-auto leading-relaxed">{{ $headerClients->header_subtitle }}</p>
        @endif
    </div>

    @if($ourClients && $ourClients->count() > 0)
    @php $cardW = 200; $gap = 20; @endphp

    {{-- Garis dekoratif atas --}}
    <div class="w-full overflow-hidden py-6">
        <div id="client-track" class="flex items-center" style="gap:{{ $gap }}px; will-change:transform;">
            @foreach([...$ourClients, ...$ourClients] as $client)
            <div class="flex-shrink-0 rounded-2xl flex items-center justify-center p-5 transition-all duration-300"
                 style="width:{{ $cardW }}px; height:90px; background:var(--color-bg-card); border:1px solid var(--color-border);">
                @if($client->klien_gambar)
                <img src="{{ asset('storage/' . $client->klien_gambar) }}"
                     alt="{{ $client->klien_nama }}"
                     class="max-w-full max-h-full object-contain"
                     style="filter:grayscale(100%); opacity:0.6; transition:all .3s;"
                     onmouseover="this.style.filter='grayscale(0%)'; this.style.opacity='1'"
                     onmouseout="this.style.filter='grayscale(100%)'; this.style.opacity='0.6'">
                @else
                <span class="text-xs font-bold c-text-secondary text-center line-clamp-2">{{ $client->klien_nama }}</span>
                @endif
            </div>
            @endforeach
        </div>
    </div>

    <script>
    (function() {
        const track = document.getElementById('client-track');
        const total = {{ $ourClients->count() }};
        const half  = ({{ $cardW }} + {{ $gap }}) * total;
        let x = 0;
        function tick() {
            x -= 0.4;
            if (Math.abs(x) >= half) x = 0;
            track.style.transform = 'translateX(' + x + 'px)';
            requestAnimationFrame(tick);
        }
        tick();
    })();
    </script>

    @else
    <div class="py-16 text-center">
        <i data-lucide="briefcase" class="w-12 h-12 mx-auto mb-4 opacity-20"></i>
        <p class="text-sm opacity-50">Informasi mitra sedang dipersiapkan.</p>
    </div>
    @endif

</section>

@endsection
