@extends('frontend.layouts.app')

@section('title', 'Produk — ' . setting('site_name', config('app.name')))

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 pb-20">

    {{-- Header --}}
    <div class="mb-10" data-aos="fade-up">
        <p class="text-xs font-bold uppercase tracking-[0.3em] c-text-secondary mb-2">— Koleksi</p>
        <div class="flex items-end justify-between gap-4">
            <h1 class="font-black c-text-primary leading-none" style="font-size: clamp(1.75rem, 4vw, 3rem); letter-spacing:-0.02em;">
                Produk
            </h1>
            <span class="text-sm c-text-secondary opacity-50 mb-1">
                {{ $products->total() }} produk
            </span>
        </div>
    </div>

    {{-- Filter bar --}}
    <div class="flex flex-wrap items-center gap-2 mb-10" data-aos="fade-up" data-aos-delay="60">

        {{-- Search --}}
        <form method="GET" action="{{ route('frontend.products.index') }}" class="flex items-center" id="search-form">
            {{-- preserve other filters --}}
            @foreach(request()->except('search','page') as $k => $v)
                <input type="hidden" name="{{ $k }}" value="{{ $v }}">
            @endforeach
            <div class="relative">
                <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 opacity-40"></i>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari..."
                       class="pl-8 pr-4 py-2 rounded-full text-sm border focus:outline-none transition"
                       style="background:var(--color-bg-card); border-color:var(--color-border); color:var(--color-text-primary); width:160px;">
            </div>
        </form>

        {{-- Divider --}}
        <span class="w-px h-5 opacity-20" style="background:var(--color-text-primary);"></span>

        {{-- Kategori pills --}}
        <a href="{{ route('frontend.products.index', array_merge(request()->except(['category','page']), [])) }}"
           class="px-4 py-2 rounded-full text-sm font-semibold transition-all duration-200 border"
           style="{{ !request('category') ? 'background:var(--color-text-primary);color:var(--color-bg);border-color:var(--color-text-primary);' : 'background:transparent;color:var(--color-text-secondary);border-color:var(--color-border);' }}">
            Semua
        </a>
        @foreach($categories as $cat)
        <a href="{{ route('frontend.products.index', array_merge(request()->except(['category','page']), ['category' => $cat->kategori_id])) }}"
           class="px-4 py-2 rounded-full text-sm font-semibold transition-all duration-200 border"
           style="{{ request('category') == $cat->kategori_id ? 'background:var(--color-text-primary);color:var(--color-bg);border-color:var(--color-text-primary);' : 'background:transparent;color:var(--color-text-secondary);border-color:var(--color-border);' }}">
            {{ $cat->kategori_nama }}
        </a>
        @endforeach

        {{-- Divider --}}
        <span class="w-px h-5 opacity-20 hidden sm:block" style="background:var(--color-text-primary);"></span>

        {{-- Sort --}}
        <div class="relative" id="sort-wrapper">
            <button onclick="document.getElementById('sort-dd').classList.toggle('hidden')"
                    class="flex items-center gap-2 px-4 py-2 rounded-full text-sm font-semibold border transition-all duration-200"
                    style="background:transparent;color:var(--color-text-secondary);border-color:var(--color-border);">
                <i data-lucide="arrow-down-up" class="w-3.5 h-3.5"></i>
                @php $sortLabels = ['latest'=>'Terbaru','price_low'=>'Termurah','price_high'=>'Termahal','name'=>'A–Z']; @endphp
                {{ $sortLabels[request('sort','latest')] ?? 'Urutkan' }}
                <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </button>
            <div id="sort-dd" class="hidden absolute left-0 mt-2 py-1 rounded-2xl shadow-lg z-50 min-w-[150px] translate-dropdown-panel">
                @foreach(['latest'=>'Terbaru','price_low'=>'Harga Terendah','price_high'=>'Harga Tertinggi','name'=>'Nama A–Z'] as $val => $label)
                <a href="{{ route('frontend.products.index', array_merge(request()->except(['sort','page']), ['sort'=>$val])) }}"
                   class="flex items-center gap-2 px-4 py-2 text-sm transition rounded-xl {{ request('sort','latest') == $val ? 'font-bold' : '' }}"
                   style="color:var(--color-text-primary);">
                    @if(request('sort','latest') == $val)
                    <span class="w-1.5 h-1.5 rounded-full flex-shrink-0" style="background:var(--color-text-primary);"></span>
                    @else
                    <span class="w-1.5 h-1.5 rounded-full flex-shrink-0 opacity-0"></span>
                    @endif
                    {{ $label }}
                </a>
                @endforeach
            </div>
        </div>

        {{-- Reset --}}
        @if(request()->hasAny(['search','category','sort']))
        <a href="{{ route('frontend.products.index') }}"
           class="flex items-center gap-1.5 px-3 py-2 rounded-full text-xs font-semibold transition-all duration-200 opacity-50 hover:opacity-100"
           style="color:var(--color-text-secondary);">
            <i data-lucide="x" class="w-3 h-3"></i> Reset
        </a>
        @endif

    </div>

    {{-- Grid --}}
    @if($products->count() > 0)
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-x-5 gap-y-12">
        @foreach($products as $product)
        <div data-aos="fade-up" data-aos-delay="{{ ($loop->index % 4) * 70 }}">

            <a href="{{ route('frontend.products.show', $product->produk_slug) }}" class="group block">

                {{-- Gambar --}}
                <div class="overflow-hidden rounded-2xl mb-4" style="aspect-ratio: 4/5;">
                    @if($product->produk_gambar_utama)
                        <img src="{{ asset('storage/' . $product->produk_gambar_utama) }}"
                             alt="{{ $product->produk_nama }}"
                             class="w-full h-full object-cover"
                             style="transform:scale(1); transition:transform 0.7s cubic-bezier(0.22,1,0.36,1);"
                             onmouseenter="this.style.transform='scale(1.06)'"
                             onmouseleave="this.style.transform='scale(1)'">
                    @else
                        <div class="w-full h-full flex items-center justify-center" style="background:var(--color-bg-card);">
                            <i data-lucide="package" class="w-10 h-10 opacity-10"></i>
                        </div>
                    @endif
                </div>

                {{-- Info --}}
                <div class="px-0.5 pt-1">
                    @if($product->category)
                    <p class="text-[10px] font-semibold uppercase tracking-[0.15em] c-text-secondary opacity-40 mb-1">
                        {{ $product->category->kategori_nama }}
                    </p>
                    @endif
                    <div class="flex items-baseline justify-between gap-2">
                        <h3 class="font-semibold text-sm c-text-primary leading-snug line-clamp-1"
                            style="transition:opacity 0.3s;"
                            onmouseenter="this.style.opacity='0.55'"
                            onmouseleave="this.style.opacity='1'">
                            {{ $product->produk_nama }}
                        </h3>
                        <span class="text-sm font-bold c-text-primary flex-shrink-0" translate="no">
                            @if($product->produk_harga_diskon)
                                {{ $product->formatted_sale_price }}
                            @else
                                {{ $product->formatted_price }}
                            @endif
                        </span>
                    </div>
                    @if($product->produk_harga_diskon)
                    <p class="text-xs c-text-secondary line-through opacity-40 mt-1" translate="no">{{ $product->formatted_price }}</p>
                    @endif
                </div>

            </a>

        </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="flex justify-center mt-14">
        {{ $products->withQueryString()->links() }}
    </div>

    @else
    <div class="py-32 text-center" data-aos="fade-up">
        <i data-lucide="package" class="w-12 h-12 mx-auto mb-4 opacity-15"></i>
        <p class="font-semibold c-text-primary mb-1">Produk tidak ditemukan</p>
        <p class="text-sm c-text-secondary opacity-50 mb-6">
            @if(request('search'))Tidak ada produk untuk "{{ request('search') }}"
            @else Belum ada produk tersedia.
            @endif
        </p>
        @if(request()->hasAny(['search','category','sort']))
        <a href="{{ route('frontend.products.index') }}"
           class="text-sm font-semibold c-text-primary"
           style="border-bottom:1.5px solid currentColor; padding-bottom:2px;">
            Reset Filter
        </a>
        @endif
    </div>
    @endif

</div>

{{-- Close sort dropdown on outside click --}}
<script>
document.addEventListener('click', function(e) {
    const w = document.getElementById('sort-wrapper');
    if (w && !w.contains(e.target)) {
        document.getElementById('sort-dd').classList.add('hidden');
    }
});
</script>

<x-cart-script />

@endsection
