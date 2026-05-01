@extends('frontend.layouts.app')

@section('title', 'Menu — ' . setting('site_name', config('app.name')))

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 pb-20">

    {{-- Header --}}
    <div class="mb-10" data-aos="fade-up">
        <p class="text-xs font-bold uppercase tracking-[0.3em] c-text-secondary mb-2">— Pilihan Kami</p>
        <h1 class="font-black c-text-primary leading-none" style="font-size: clamp(1.75rem, 4vw, 3rem); letter-spacing:-0.02em;">
            Menu
        </h1>
    </div>

    @if($categories->count() > 0)

    {{-- Category filter pills --}}
    @if($categories->count() > 1)
    <div class="flex flex-wrap items-center gap-2 mb-12" data-aos="fade-up" data-aos-delay="60">
        <button onclick="switchTab(-1)" id="tab-all"
                class="px-4 py-2 rounded-full text-sm font-semibold transition-all duration-200 border"
                style="background:var(--color-text-primary);color:var(--color-bg);border-color:var(--color-text-primary);">
            Semua
        </button>
        @foreach($categories as $i => $cat)
        <button onclick="switchTab({{ $i }})" id="tab-{{ $i }}"
                class="px-4 py-2 rounded-full text-sm font-semibold transition-all duration-200 border"
                style="background:transparent;color:var(--color-text-secondary);border-color:var(--color-border);">
            {{ $cat->kategori_nama }}
        </button>
        @endforeach
    </div>
    @endif

    {{-- All items in one flat grid (default: all visible) --}}
    <div id="menu-grid" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-x-5 gap-y-12">
        @foreach($categories as $i => $cat)
            @foreach($cat->menus as $j => $item)
            <div class="menu-item" data-cat="{{ $i }}"
                 data-aos="fade-up" data-aos-delay="{{ ($loop->index % 4) * 70 }}">

                <a href="#" class="group block">
                    {{-- Gambar --}}
                    <div class="overflow-hidden rounded-2xl mb-4" style="aspect-ratio: 4/5;">
                        @if($item->menu_image)
                            <img src="{{ asset('storage/' . $item->menu_image) }}"
                                 alt="{{ $item->menu_nama }}"
                                 class="w-full h-full object-cover"
                                 style="transform:scale(1); transition:transform 0.7s cubic-bezier(0.22,1,0.36,1);"
                                 onmouseenter="this.style.transform='scale(1.06)'"
                                 onmouseleave="this.style.transform='scale(1)'">
                        @else
                            <div class="w-full h-full flex items-center justify-center" style="background:var(--color-bg-card);">
                                <i data-lucide="coffee" class="w-10 h-10 opacity-10"></i>
                            </div>
                        @endif
                    </div>

                    {{-- Info --}}
                    <div class="px-0.5 pt-1">
                        <p class="text-[10px] font-semibold uppercase tracking-[0.15em] c-text-secondary opacity-40 mb-1">
                            {{ $cat->kategori_nama }}
                        </p>
                        <div class="flex items-baseline justify-between gap-2">
                            <h3 class="font-semibold text-sm c-text-primary leading-snug line-clamp-1"
                                style="transition:opacity 0.3s;"
                                onmouseenter="this.style.opacity='0.55'"
                                onmouseleave="this.style.opacity='1'">
                                {{ $item->menu_nama }}
                            </h3>
                            @if($item->menu_harga)
                            <span class="text-sm font-bold c-text-primary flex-shrink-0" translate="no">
                                {{ $item->formatted_price }}
                            </span>
                            @endif
                        </div>
                        @if($item->menu_deskripsi)
                        <p class="text-xs c-text-secondary opacity-50 mt-1 line-clamp-1">{{ $item->menu_deskripsi }}</p>
                        @endif
                    </div>
                </a>

            </div>
            @endforeach
        @endforeach
    </div>

    @else
    <div class="py-32 text-center" data-aos="fade-up">
        <i data-lucide="coffee" class="w-12 h-12 mx-auto mb-4 opacity-15"></i>
        <p class="font-semibold c-text-primary mb-1">Menu sedang dipersiapkan</p>
        <p class="text-sm c-text-secondary opacity-50">Silakan kunjungi kembali nanti.</p>
    </div>
    @endif

</div>

<script>
const TOTAL_CATS = {{ $categories->count() }};

function switchTab(index) {
    const allBtn = document.getElementById('tab-all');
    const items  = document.querySelectorAll('.menu-item');

    // Reset all tab styles
    if (allBtn) {
        allBtn.style.background  = 'transparent';
        allBtn.style.color       = 'var(--color-text-secondary)';
        allBtn.style.borderColor = 'var(--color-border)';
    }
    for (let i = 0; i < TOTAL_CATS; i++) {
        const t = document.getElementById('tab-' + i);
        if (t) {
            t.style.background  = 'transparent';
            t.style.color       = 'var(--color-text-secondary)';
            t.style.borderColor = 'var(--color-border)';
        }
    }

    // Activate selected tab
    if (index === -1) {
        if (allBtn) {
            allBtn.style.background  = 'var(--color-text-primary)';
            allBtn.style.color       = 'var(--color-bg)';
            allBtn.style.borderColor = 'var(--color-text-primary)';
        }
        items.forEach(el => el.style.display = '');
    } else {
        const t = document.getElementById('tab-' + index);
        if (t) {
            t.style.background  = 'var(--color-text-primary)';
            t.style.color       = 'var(--color-bg)';
            t.style.borderColor = 'var(--color-text-primary)';
        }
        items.forEach(el => {
            el.style.display = el.dataset.cat == index ? '' : 'none';
        });
    }

    if (window.AOS) AOS.refresh();
}
</script>

@endsection
