@props(['product', 'compact' => false])

@if($compact)
{{-- ── Compact: gambar penuh + overlay nama/harga, tanpa konten bawah ── --}}
<a href="{{ route('frontend.products.show', $product->produk_slug) }}"
   class="group block relative rounded-2xl overflow-hidden w-full h-full c-card cursor-pointer transition-all duration-300 hover:scale-[1.03] hover:shadow-xl"
   style="box-shadow:0 4px 16px rgba(0,0,0,0.06);">

    @if($product->produk_gambar_utama)
        <img src="{{ asset('storage/' . $product->produk_gambar_utama) }}"
             alt="{{ $product->produk_nama }}"
             class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
    @else
        <div class="w-full h-full flex items-center justify-center" style="background:var(--color-bg-card);">
            <i data-lucide="coffee" class="w-10 h-10 opacity-15"></i>
        </div>
    @endif

    {{-- Gradient bawah --}}
    <div class="absolute inset-0" style="background:linear-gradient(to top, rgba(0,0,0,0.6) 0%, transparent 50%);"></div>

    {{-- Category badge --}}
    @if($product->category)
        <span class="absolute top-3 left-3 px-2 py-1 rounded-lg text-[10px] font-bold"
              style="background:rgba(255,255,255,0.88);backdrop-filter:blur(8px);color:#111;border:1px solid rgba(255,255,255,0.6);">
            {{ $product->category->kategori_nama }}
        </span>
    @endif

    {{-- Nama + harga overlay bawah --}}
    <div class="absolute bottom-0 left-0 right-0 p-3">
        <p class="text-white font-bold text-xs leading-snug line-clamp-1 mb-0.5">{{ $product->produk_nama }}</p>
        @if($product->produk_harga)
            <p class="text-xs font-black" style="color:rgba(255,255,255,0.85);" translate="no">{{ $product->formatted_price }}</p>
        @endif
    </div>
</a>

@else
{{-- ── Default card — minimalist editorial ── --}}
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
    <div class="px-0.5">
        @if($product->category)
        <p class="text-[10px] font-semibold uppercase tracking-[0.15em] c-text-secondary opacity-50 mb-0.5">
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
            @if($product->produk_harga)
            <span class="text-sm font-bold c-text-primary flex-shrink-0" translate="no">
                {{ $product->produk_harga_diskon ? $product->formatted_sale_price : $product->formatted_price }}
            </span>
            @endif
        </div>
        @if($product->produk_harga_diskon)
        <p class="text-xs c-text-secondary line-through opacity-40 mt-0.5" translate="no">{{ $product->formatted_price }}</p>
        @endif
    </div>

</a>
@endif
