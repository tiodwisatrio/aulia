@extends('frontend.layouts.app')

@section('title', 'Koleksi Roast Beans — Sektor 21')

@section('content')

{{-- MOBILE FILTER BUTTON --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 pb-4 lg:hidden">
    <div class="flex items-center justify-end">
        @php $activeFilters = collect(['search','category','origin','sort'])->filter(fn($k) => request()->has($k) && request($k) != '')->count(); @endphp
        <button id="mobile-filter-toggle"
                class="flex items-center gap-2 px-4 py-2 rounded-full border border-current border-opacity-30 text-sm font-semibold transition-opacity hover:opacity-70">
            <i data-lucide="sliders-horizontal" class="w-4 h-4"></i>
            Filter
            @if($activeFilters > 0)
                <span class="w-5 h-5 rounded-full text-xs font-bold flex items-center justify-center text-white" style="background:var(--color-accent);">{{ $activeFilters }}</span>
            @endif
        </button>
    </div>
</div>

{{-- MAIN LAYOUT: SIDEBAR + GRID --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
    <div class="flex flex-col lg:flex-row gap-10 lg:gap-12">

        {{-- ===== SIDEBAR DESKTOP ===== --}}
        <aside class="hidden lg:block lg:w-72 flex-shrink-0">
            <div class="sticky top-24">
                <form method="GET" action="{{ route('frontend.products.index') }}" id="filter-form-desktop" class="space-y-4">
                    {{-- Search --}}
                    <div class="relative group">
                        <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 opacity-40 group-focus-within:opacity-70 transition"></i>
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Cari produk..."
                               class="w-full pl-12 pr-4 py-3.5 rounded-2xl border-2 border-current border-opacity-15 focus:outline-none focus:border-opacity-30 focus:ring-3 focus:ring-current focus:ring-opacity-10 text-sm transition font-medium" style="background:var(--color-bg); color:var(--color-text-primary);">
                    </div>

                    {{-- Sort --}}
                    <div class="rounded-xl border-2 border-current border-opacity-10 p-4 transition hover:border-opacity-20" style="background:var(--color-bg-card);">
                        <div class="flex items-center gap-2 mb-3">
                            <i data-lucide="arrow-down-up" class="w-4 h-4 opacity-60"></i>
                            <h4 class="text-xs font-bold c-text-primary uppercase tracking-wide">Urutkan</h4>
                        </div>
                        <div class="space-y-2.5">
                            @foreach(['latest' => 'Terbaru', 'price_low' => 'Harga Terendah', 'price_high' => 'Harga Tertinggi', 'name' => 'Nama A–Z'] as $val => $label)
                            <label class="flex items-center gap-3 cursor-pointer group/item">
                                <input type="radio" name="sort" value="{{ $val }}"
                                       {{ request('sort', 'latest') == $val ? 'checked' : '' }}
                                       onchange="this.form.submit()"
                                       style="accent-color: var(--color-accent);" class="w-4 h-4 cursor-pointer">
                                <span class="text-sm opacity-70 group-hover/item:opacity-100 transition-opacity">{{ $label }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Kategori --}}
                    @if($categories->count() > 0)
                    <div class="rounded-xl border-2 border-current border-opacity-10 p-4 transition hover:border-opacity-20" style="background:var(--color-bg-card);">
                        <div class="flex items-center gap-2 mb-3">
                            <i data-lucide="coffee" class="w-4 h-4 opacity-60"></i>
                            <h4 class="text-xs font-bold c-text-primary uppercase tracking-wide">Jenis Kopi</h4>
                        </div>
                        <div class="space-y-2.5">
                            @foreach($categories as $category)
                            <label class="flex items-center gap-3 cursor-pointer group/item">
                                <input type="radio" name="category" value="{{ $category->kategori_id }}"
                                       {{ request('category') == $category->kategori_id ? 'checked' : '' }}
                                       onchange="this.form.submit()"
                                       style="accent-color: var(--color-accent);" class="w-4 h-4 cursor-pointer">
                                <span class="text-sm opacity-70 group-hover/item:opacity-100 transition-opacity">{{ $category->kategori_nama }}</span>
                            </label>
                            @endforeach
                            @if(request('category'))
                            <button type="button" onclick="clearDesktop('category')" class="text-xs opacity-50 hover:opacity-90 transition-opacity mt-4 font-semibold text-red-600">× Hapus filter</button>
                            @endif
                        </div>
                    </div>
                    @endif

                    {{-- Reset --}}
                    @if(request()->hasAny(['search', 'category', 'sort']))
                    <a href="{{ route('frontend.products.index') }}" class="flex items-center justify-center w-full gap-2 text-sm font-bold text-white c-btn-primary rounded-2xl py-3.5 transition hover:opacity-90 active:scale-95">
                        <i data-lucide="refresh-ccw" class="w-4 h-4"></i>
                        Reset Filter
                    </a>
                    @endif
                </form>
            </div>
        </aside>

        {{-- ===== PRODUK GRID ===== --}}
        <div class="flex-1 min-w-0">
            @if($products->count() > 0)
                <div class="mb-8 flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold c-text-primary">Koleksi Produk</h2>
                        <p class="text-sm opacity-60 mt-1">{{ $products->count() }} produk tersedia</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6 mb-14">
                    @foreach($products as $product)
                        <div data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                            <x-product-card :product="$product" />
                        </div>
                    @endforeach
                </div>
                <div class="flex justify-center">
                    {{ $products->withQueryString()->links() }}
                </div>
            @else
                <div class="text-center py-24">
                    <i data-lucide="coffee" class="w-16 h-16 mx-auto mb-5 opacity-20"></i>
                    <h3 class="text-xl font-bold mb-2">Produk tidak ditemukan</h3>
                    <p class="opacity-50 mb-8 text-sm">
                        @if(request('search'))
                            Tidak ada produk yang cocok dengan "{{ request('search') }}"
                        @else
                            Belum ada produk tersedia saat ini.
                        @endif
                    </p>
                    @if(request()->hasAny(['search', 'category', 'origin']))
                        <a href="{{ route('frontend.products.index') }}" class="inline-flex items-center gap-2 font-semibold border-b-2 border-current pb-1 hover:opacity-70 transition-opacity">
                            <i data-lucide="refresh-ccw" class="w-4 h-4"></i>
                            Reset Filter
                        </a>
                    @endif
                </div>
            @endif
        </div>

    </div>
</div>

{{-- ===== FILTER MODAL MOBILE ===== --}}
{{-- Overlay --}}
<div id="fm-overlay"
     onclick="closeFilterModal()"
     style="display:none; position:fixed; inset:0; z-index:998; background:rgba(0,0,0,0); transition:background 0.3s ease;"></div>

{{-- Modal Panel (slide up dari bawah) --}}
<div id="fm-panel"
     style="display:none; position:fixed; bottom:0; left:0; right:0; z-index:999;
            transform:translateY(100%); transition:transform 0.35s cubic-bezier(0.32,0.72,0,1);
            background:var(--color-bg); border-radius:1.25rem 1.25rem 0 0;
            max-height:85vh; overflow:hidden; flex-direction:column;
            border-top: 1px solid var(--color-border);">

    {{-- Handle bar --}}
    <div class="flex justify-center pt-3 pb-1">
        <div style="width:2.5rem; height:4px; border-radius:2px; background:var(--color-border);"></div>
    </div>

    {{-- Header --}}
    <div class="flex items-center justify-between px-6 py-3 border-b border-current border-opacity-10">
        <h3 class="text-base font-bold">Filter Produk</h3>
        <button onclick="closeFilterModal()" class="w-8 h-8 flex items-center justify-center rounded-full hover:opacity-50 transition-opacity">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    {{-- Scrollable content --}}
    <div style="overflow-y:auto; flex:1; padding:1.5rem;">
        <form method="GET" action="{{ route('frontend.products.index') }}" id="fm-form">

            {{-- Search --}}
            <div class="mb-6">
                <div class="relative">
                    <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 opacity-40"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari produk..."
                           class="w-full pl-9 pr-3 py-2.5 rounded-xl border border-current border-opacity-20 bg-transparent focus:outline-none focus:border-opacity-60 text-sm">
                </div>
            </div>

            {{-- Sort --}}
            <div class="mb-6">
                <p class="text-xs font-bold uppercase tracking-widest opacity-40 mb-3">Urutkan</p>
                <div class="space-y-3">
                    @foreach(['latest' => 'Terbaru', 'price_low' => 'Harga Terendah', 'price_high' => 'Harga Tertinggi', 'name' => 'Nama A–Z'] as $val => $label)
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="radio" name="sort" value="{{ $val }}"
                               {{ request('sort', 'latest') == $val ? 'checked' : '' }}
                               class="accent-[#893800] w-4 h-4">
                        <span class="text-sm">{{ $label }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- Kategori --}}
            @if($categories->count() > 0)
            <div class="mb-6">
                <p class="text-xs font-bold uppercase tracking-widest opacity-40 mb-3">Jenis Kopi</p>
                <div class="space-y-3">
                    @foreach($categories as $category)
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="radio" name="category" value="{{ $category->kategori_id }}"
                               {{ request('category') == $category->kategori_id ? 'checked' : '' }}
                               class="accent-[#893800] w-4 h-4">
                        <span class="text-sm">{{ $category->kategori_nama }}</span>
                    </label>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Tombol aksi --}}
            <div class="flex gap-3 pt-2 pb-4">
                <button type="submit" class="flex-1 py-3 rounded-xl text-sm font-bold text-white transition-opacity hover:opacity-80" style="background:var(--color-accent);">
                    Terapkan Filter
                </button>
                @if(request()->hasAny(['search', 'category', 'sort']))
                <a href="{{ route('frontend.products.index') }}" class="flex-1 py-3 rounded-xl text-sm font-bold text-center border-2 border-current border-opacity-20 hover:opacity-70 transition-opacity">
                    Reset
                </a>
                @endif
            </div>

        </form>
    </div>
</div>

<x-cart-script />

<script>
function clearDesktop(name) {
    document.querySelectorAll(`#filter-form-desktop input[name="${name}"]`).forEach(r => r.checked = false);
    document.getElementById('filter-form-desktop').submit();
}

function openFilterModal() {
    const overlay = document.getElementById('fm-overlay');
    const panel = document.getElementById('fm-panel');

    overlay.style.display = 'block';
    panel.style.display = 'flex';

    // Trigger animation
    requestAnimationFrame(() => {
        requestAnimationFrame(() => {
            panel.style.transform = 'translateY(0)';
            overlay.style.background = 'rgba(0,0,0,0.5)';
        });
    });

    document.body.style.overflow = 'hidden';
}

function closeFilterModal() {
    const overlay = document.getElementById('fm-overlay');
    const panel = document.getElementById('fm-panel');

    panel.style.transform = 'translateY(100%)';
    overlay.style.background = 'rgba(0,0,0,0)';

    setTimeout(() => {
        overlay.style.display = 'none';
        panel.style.display = 'none';
        document.body.style.overflow = '';
    }, 350);
}

document.addEventListener('DOMContentLoaded', function () {
    const btn = document.getElementById('mobile-filter-toggle');
    if (btn) btn.addEventListener('click', openFilterModal);
});
</script>

@endsection
