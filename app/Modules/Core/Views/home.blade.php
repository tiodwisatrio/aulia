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

<section id="about" class="py-16 sm:py-20 lg:py-24">
    <div class="max-w-6xl mx-auto px-8 md:px-14">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-20 items-center">

            {{-- Kiri: Gambar oval + Est --}}
            <div class="relative flex flex-col items-start" data-aos="fade-right">

                {{-- Frame oval --}}
                <div class="relative w-full" style="max-width: 420px;">
                    {{-- Border oval dekoratif --}}
                    <div class="absolute inset-0 rounded-full"
                         style="border: 1px solid var(--color-border); transform: scale(1.06); border-radius: 50%;"></div>

                    {{-- Gambar oval --}}
                    <div class="relative overflow-hidden w-full"
                         style="aspect-ratio: 4/5; border-radius: 50%;">
                        @if($abouts->first()->tentang_gambar)
                            <img src="{{ asset('storage/' . $abouts->first()->tentang_gambar) }}"
                                 alt="{{ $abouts->first()->tentang_judul }}"
                                 class="w-full h-full object-cover transition-transform duration-700 hover:scale-105">
                        @else
                            <div class="w-full h-full flex items-center justify-center"
                                 style="background: var(--color-bg-card);">
                                <i data-lucide="coffee" class="w-12 h-12 opacity-10"></i>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Est. di bawah --}}
                @if($abouts->first()->tentang_tahun_berdiri)
                <p class="text-xs tracking-[0.25em] uppercase c-text-secondary mt-6">
                    Est. {{ $abouts->first()->tentang_tahun_berdiri }}
                </p>
                @endif
            </div>

            {{-- Kanan: Konten --}}
            <div data-aos="fade-left" data-aos-delay="80">

                <p class="text-xs tracking-[0.3em] uppercase c-text-secondary mb-6">— Tentang Kami</p>

                <h2 class="font-black c-text-primary leading-tight mb-8"
                    style="font-size: clamp(2rem, 4vw, 3.25rem); letter-spacing: -0.02em;">
                    {{ $abouts->first()->tentang_judul ?? ($headerAbout->header_title ?? 'Bukan Sekadar Kopi Biasa') }}
                </h2>

                <p class="leading-relaxed c-text-secondary mb-10"
                   style="font-size: 0.9375rem; max-width: 420px; line-height: 1.85;">
                    {!! Str::limit(strip_tags($abouts->first()->tentang_konten), 260) !!}...
                </p>

                {{-- Stats --}}
                @if($aboutStats->count() > 0)
                <div class="flex items-start gap-12 mb-10"
                     style="border-top: 1px solid var(--color-border); padding-top: 32px;">
                    @foreach($aboutStats as $stat)
                    <div data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}">
                        <span class="block font-black c-text-primary leading-none mb-1.5"
                              style="font-size: clamp(1.75rem, 3vw, 2.5rem); letter-spacing:-0.02em;"
                              translate="no">
                            {{ $stat['value'] }}
                        </span>
                        <span class="block text-[11px] uppercase tracking-[0.2em] c-text-secondary">
                            {{ $stat['label'] }}
                        </span>
                    </div>
                    @endforeach
                </div>
                @endif

                {{-- CTA --}}
                <!-- <a href="{{ route('frontend.abouts.index') }}"
                   class="inline-flex items-center gap-3 text-xs font-bold uppercase tracking-[0.2em] c-text-primary group transition-all duration-300">
                    <span style="border-bottom: 1.5px solid currentColor; padding-bottom: 2px;">
                        Cerita Selengkapnya
                    </span>
                    <i data-lucide="arrow-right" class="w-3.5 h-3.5 transition-transform duration-300 group-hover:translate-x-1.5"></i>
                </a> -->

            </div>
        </div>

    </div>
</section>
@endif


{{-- ═══════════════════════════════════════════════════════
    SERVICES — Numbered list dengan divider, bukan card grid
═══════════════════════════════════════════════════════ --}}
@php $headerServices = DB::table('header')->where('header_section', 'services')->first(); @endphp

<section id="services" class="py-16 sm:py-20 lg:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="flex items-end justify-between mb-12" data-aos="fade-up">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.3em] c-text-secondary mb-2">— Layanan</p>
                <h2 class="text-2xl lg:text-4xl font-black c-text-primary leading-none">
                    {{ $headerServices->header_title ?? 'Layanan Kami' }}
                </h2>
            </div>
            @if(!empty($headerServices->header_subtitle))
            <p class="hidden md:block c-text-secondary text-sm max-w-xs text-right leading-relaxed opacity-60">
                {{ $headerServices->header_subtitle }}
            </p>
            @endif
        </div>

        @if($services && $services->count() > 0)

        <div>
            @foreach($services as $service)
            <div class="group relative flex items-center gap-8 py-8 cursor-default"
                 style="border-top: 1px solid var(--color-border);"
                 data-aos="fade-up" data-aos-delay="{{ $loop->index * 150 }}"
                 onmouseenter="svcHover(this,true)" onmouseleave="svcHover(this,false)">

                {{-- Nomor besar —— ghosted, jadi solid on hover --}}
                <span class="svc-num flex-shrink-0 font-black c-text-primary select-none"
                      style="font-size: clamp(2rem,4vw,3rem); letter-spacing:-0.04em; line-height:1; opacity:0.15; transition: opacity 0.4s cubic-bezier(0.22,1,0.36,1); min-width:60px;">
                    {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                </span>

                {{-- Teks --}}
                <div class="flex-1 min-w-0">
                    <h3 class="font-bold c-text-primary leading-tight mb-2"
                        style="font-size: clamp(1.1rem, 2.2vw, 1.5rem);">
                        {{ $service->layanan_nama }}
                    </h3>
                    @if($service->layanan_deskripsi)
                    <p class="text-sm c-text-secondary leading-relaxed max-w-xl opacity-60">
                        {{ Str::limit($service->layanan_deskripsi, 140) }}
                    </p>
                    @endif
                </div>

                {{-- Gambar —— muncul on hover di kanan --}}
                @if($service->layanan_gambar)
                <div class="svc-img-wrap flex-shrink-0 overflow-hidden rounded-xl hidden lg:block"
                     style="width:120px; height:90px; opacity:0; transition: opacity 0.5s cubic-bezier(0.22,1,0.36,1);">
                    <img src="{{ asset('storage/' . $service->layanan_gambar) }}"
                         alt="{{ $service->layanan_nama }}"
                         class="w-full h-full object-cover"
                         style="transform:scale(1.05);">
                </div>
                @endif

                {{-- Arrow kanan --}}
                <i data-lucide="arrow-right"
                   class="svc-arrow flex-shrink-0 w-4 h-4 c-text-primary hidden lg:block"
                   style="opacity:0; transition: opacity 0.35s cubic-bezier(0.22,1,0.36,1), transform 0.35s cubic-bezier(0.22,1,0.36,1); transform: translateX(-6px);"></i>

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
    MENU — Tab kategori + card grid
═══════════════════════════════════════════════════════ --}}
@php
    $menuCats = isset($menuCategories) ? $menuCategories->values() : collect();
    if ($menuCats->isEmpty()) {
        $allMenusRaw = \App\Modules\Menu\Models\Menu::with('category')->where('menu_status', 'aktif')->orderBy('id')->get();
        if ($allMenusRaw->isNotEmpty()) {
            $menuCats = $allMenusRaw->groupBy(fn($m) => optional($m->category)->kategori_nama ?? 'Lainnya')
                ->map(fn($items, $nama) => (object)['kategori_nama' => $nama, 'menus' => $items])
                ->values();
        }
    }
    // Flatten semua menu untuk tab "Semua"
    $allMenuItems = $menuCats->flatMap(fn($c) => collect($c->menus));
@endphp
@if($allMenuItems->count() > 0)

<section id="menu" class="py-16 sm:py-20 lg:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="flex items-end justify-between mb-10" data-aos="fade-up">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.3em] c-text-secondary mb-2">— Pilihan Kami</p>
                <h2 class="text-2xl lg:text-4xl font-black c-text-primary leading-none">Menu</h2>
            </div>
            <a href="{{ route('frontend.menu.index') }}"
               class="hidden sm:inline-flex items-center gap-2 text-sm font-bold uppercase tracking-widest c-text-secondary hover:c-text-primary transition-all duration-300 hover:gap-4">
                Lihat Semua <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>

        {{-- Filter Tab --}}
        <div class="flex flex-wrap gap-2 mb-10" data-aos="fade-up" data-aos-delay="40">
            {{-- Tab Semua --}}
            <button onclick="filterMenu('semua')" id="menu-tab-semua"
                    class="menu-filter-btn px-5 py-2 rounded-full text-sm font-semibold transition-all duration-200"
                    style="background:var(--color-text-primary);color:var(--color-bg);">
                Semua
            </button>
            @foreach($menuCats as $cat)
            <button onclick="filterMenu('{{ Str::slug($cat->kategori_nama) }}')"
                    id="menu-tab-{{ Str::slug($cat->kategori_nama) }}"
                    class="menu-filter-btn px-5 py-2 rounded-full text-sm font-semibold transition-all duration-200 border"
                    style="background:transparent;color:var(--color-text-secondary);border-color:var(--color-border);">
                {{ $cat->kategori_nama }}
            </button>
            @endforeach
        </div>

        {{-- Grid Menu --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="menu-grid">
            @foreach($allMenuItems as $item)
            <div class="menu-card group rounded-2xl overflow-hidden c-card cursor-pointer"
                 data-cat="{{ Str::slug(optional($item->category)->kategori_nama ?? 'lainnya') }}"
                 data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}"
                 style="box-shadow: 0 2px 16px rgba(0,0,0,0.06); transform: translateY(0); transition: transform 0.4s cubic-bezier(0.25,0.46,0.45,0.94), box-shadow 0.4s cubic-bezier(0.25,0.46,0.45,0.94); will-change: transform;"
                 onmouseenter="this.style.transform='translateY(-6px)';this.style.boxShadow='0 16px 40px rgba(0,0,0,0.13)'"
                 onmouseleave="this.style.transform='translateY(0)';this.style.boxShadow='0 2px 16px rgba(0,0,0,0.06)'">

                {{-- Gambar --}}
                <div class="relative overflow-hidden" style="aspect-ratio: 3/2;">
                    @if($item->menu_image)
                        <img src="{{ asset("storage/{$item->menu_image}") }}"
                             alt="{{ $item->menu_nama }}"
                             class="w-full h-full object-cover"
                             style="transform:scale(1); transition:transform 0.7s cubic-bezier(0.22,1,0.36,1);"
                             onmouseenter="this.style.transform='scale(1.07)'"
                             onmouseleave="this.style.transform='scale(1)'">
                    @else
                        <div class="w-full h-full flex items-center justify-center"
                             style="background:var(--color-bg-card);">
                            <i data-lucide="utensils" class="w-8 h-8 opacity-15"></i>
                        </div>
                    @endif

                    {{-- Badge kategori --}}
                    @if($item->category)
                    <span class="absolute top-3 left-3 px-2 py-0.5 rounded-md text-[8px] font-semibold capitalize"
                          style="background:rgba(255,255,255,0.88);backdrop-filter:blur(8px);color:#111;border:1px solid rgba(255,255,255,0.5);">
                        {{ $item->category->kategori_nama }}
                    </span>
                    @endif
                </div>

                {{-- Info --}}
                <div class="p-4">
                    <h3 class="font-bold text-base c-text-primary leading-snug line-clamp-1 mb-1">
                        {{ $item->menu_nama }}
                    </h3>
                    @if($item->menu_deskripsi)
                    <p class="text-xs c-text-secondary line-clamp-1 opacity-70 mb-2">
                        {{ $item->menu_deskripsi }}
                    </p>
                    @endif
                    @if($item->menu_harga)
                    <span class="text-base font-black c-text-accent" translate="no">{{ $item->formatted_price }}</span>
                    @endif
                </div>

            </div>
            @endforeach
        </div>

    </div>
</section>

<script>
function svcHover(el, enter) {
    var num = el.querySelector('.svc-num');
    var iw  = el.querySelector('.svc-img-wrap');
    var ar  = el.querySelector('.svc-arrow');
    if (num) num.style.opacity = enter ? '1' : '0.15';
    if (iw)  iw.style.opacity  = enter ? '1' : '0';
    if (ar) {
        ar.style.opacity   = enter ? '1' : '0';
        ar.style.transform = enter ? 'translateX(0)' : 'translateX(-6px)';
    }
}

function filterMenu(cat) {
    // Update tab aktif
    document.querySelectorAll('.menu-filter-btn').forEach(btn => {
        const isActive = btn.id === 'menu-tab-' + cat;
        btn.style.background  = isActive ? 'var(--color-text-primary)' : 'transparent';
        btn.style.color       = isActive ? 'var(--color-bg)' : 'var(--color-text-secondary)';
        btn.style.borderColor = isActive ? 'var(--color-text-primary)' : 'var(--color-border)';
        if (isActive) btn.style.border = 'none';
        else btn.style.border = '1px solid var(--color-border)';
    });

    // Filter card
    document.querySelectorAll('.menu-card').forEach(card => {
        const show = cat === 'semua' || card.dataset.cat === cat;
        card.style.display = show ? '' : 'none';
    });
}
</script>
@endif


{{-- ═══════════════════════════════════════════════════════
    PRODUCTS — Featured besar + grid kecil di bawah
═══════════════════════════════════════════════════════ --}}
@php $headerProducts = DB::table('header')->where('header_section', 'products')->first(); @endphp

<section id="products" class="py-16 sm:py-20 lg:py-24">
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
                        <span class="text-sm font-bold" style="color:rgba(255,255,255,0.8);" translate="no">
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
<!-- <section id="projects" class="py-16 lg:py-20" style="border-top: 1px solid var(--color-border);">
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
</section> -->


{{-- ═══════════════════════════════════════════════════════
    CLIENTS — Marquee strip full-width
═══════════════════════════════════════════════════════ --}}
<!-- <section id="our-clients" class="py-20 lg:py-28" style="border-top:1px solid var(--color-border);">
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
