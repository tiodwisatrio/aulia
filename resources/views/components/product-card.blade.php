@props(['product'])

<article class="group flex flex-col h-full rounded-2xl overflow-hidden cursor-pointer transition-all duration-300 hover:scale-105 hover:shadow-2xl hover-lift c-card"
         style="box-shadow: 0 8px 32px rgba(0, 0, 0, 0.06);">

    <!-- Image Container -->
    <div class="relative h-64 overflow-hidden bg-gray-100 flex-shrink-0">
        <a href="{{ route('frontend.products.show', $product->produk_slug) }}" class="block w-full h-full">
            @if($product->produk_gambar_utama)
                <img src="{{ asset('storage/' . $product->produk_gambar_utama) }}"
                     alt="{{ $product->produk_nama }}"
                     class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
            @else
                <div class="w-full h-full flex items-center justify-center" style="background:linear-gradient(135deg, rgba(17,17,17,0.05), rgba(0,0,0,0.02));">
                    <i data-lucide="coffee" class="w-16 h-16 opacity-15"></i>
                </div>
            @endif
        </a>

        <!-- Gradient Overlay (hover reveal) -->
        <div class="absolute inset-0 bg-gradient-to-t from-black/30 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-300"></div>

        <!-- Category Badge -->
        @if($product->category)
            <span class="absolute top-4 left-4 px-3 py-1.5 rounded-lg text-xs font-bold shadow-sm transform group-hover:scale-105 transition duration-300"
                  style="background: rgba(255,255,255,0.88);
                         backdrop-filter: blur(8px);
                         -webkit-backdrop-filter: blur(8px);
                         color: #111111;
                         border: 1px solid rgba(255,255,255,0.6);">
                {{ $product->category->kategori_nama }}
            </span>
        @endif

        <!-- Floating Action (appears on hover) -->
        <div class="absolute bottom-4 right-4 opacity-0 group-hover:opacity-100 transform translate-y-2 group-hover:translate-y-0 transition duration-300">
            <button
                onclick="addToCartCard('{{ $product->produk_id }}', '{{ addslashes($product->produk_nama) }}', {{ $product->produk_harga }}, '{{ $product->produk_slug }}', '{{ $product->produk_gambar_utama ? asset('storage/' . $product->produk_gambar_utama) : '' }}')"
                class="flex items-center justify-center w-12 h-12 rounded-full c-btn-primary shadow-lg hover:shadow-xl transition duration-200"
                title="Tambahkan ke Keranjang">
                <i data-lucide="plus" class="w-5 h-5"></i>
            </button>
        </div>
    </div>

    <!-- Content -->
    <div class="p-5 flex-1 flex flex-col justify-between gap-4">
        <!-- Top Content -->
        <div>
            <!-- Title -->
            <h3 class="font-bold text-base leading-snug line-clamp-2 mb-3 c-text-primary group-hover:c-text-accent transition duration-200">
                <a href="{{ route('frontend.products.show', $product->produk_slug) }}">
                    {{ $product->produk_nama }}
                </a>
            </h3>

            <!-- Description -->
            <!-- @if($product->produk_deskripsi)
                <p class="text-xs c-text-secondary leading-relaxed line-clamp-2 mb-3 opacity-75">
                    {{ Str::limit(strip_tags($product->produk_deskripsi), 70) }}
                </p>
            @endif -->

            <!-- Info Badges -->
            <div class="flex flex-wrap gap-2">
                @if($product->produk_origin)
                    <span class="inline-flex items-center gap-1 text-xs px-3 py-1.5 rounded-full" style="background:var(--color-bg-card); color:var(--color-text-secondary);">
                        <i data-lucide="map-pin" class="w-3 h-3 flex-shrink-0"></i>
                        <span class="font-medium">{{ $product->produk_origin }}</span>
                    </span>
                @endif
                @if($product->produk_ukuran)
                    <span class="inline-flex items-center gap-1 text-xs px-3 py-1.5 rounded-full" style="background:var(--color-bg-card); color:var(--color-text-secondary);">
                        <i data-lucide="package" class="w-3 h-3 flex-shrink-0"></i>
                        <span class="font-medium">{{ $product->produk_ukuran }}g</span>
                    </span>
                @endif
            </div>
        </div>

        <!-- Price + Action -->
        <div class="flex flex-col gap-3 pt-2 border-t border-current border-opacity-5">
            <!-- Price -->
            @if($product->produk_harga)
                <div>
                    @if($product->produk_harga_diskon)
                        <div class="text-lg font-bold c-text-accent">{{ $product->formatted_sale_price }}</div>
                        <div class="text-xs line-through c-text-muted">{{ $product->formatted_price }}</div>
                    @else
                        <div class="text-lg font-bold c-text-accent">{{ $product->formatted_price }}</div>
                    @endif
                </div>
            @endif

            <!-- Buy Button -->
            <a href="{{ route('frontend.products.show', $product->produk_slug) }}"
               class="w-full flex items-center justify-center gap-2 py-3 rounded-lg text-sm font-bold c-btn-primary hover:opacity-90 transition duration-200 group/btn">
                <span>Lihat Detail</span>
                <i data-lucide="arrow-right" class="w-4 h-4 group-hover/btn:translate-x-1 transition duration-200"></i>
            </a>
        </div>
    </div>
</article>
