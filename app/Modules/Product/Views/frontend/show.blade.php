@extends('frontend.layouts.app')

@section('title', $product->produk_nama)
@section('meta_description', Str::limit(strip_tags($product->produk_deskripsi ?? ''), 155))
@section('meta_image', $product->produk_gambar_utama ? asset('storage/' . $product->produk_gambar_utama) : '')
@section('og_type', 'product')
@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-10 pb-20">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-xs c-text-secondary opacity-50 mb-10" data-aos="fade-up">
        <a href="{{ route('frontend.products.index') }}" class="hover:opacity-100 transition">Produk</a>
        <span>/</span>
        @if($product->category)
            <span>{{ $product->category->kategori_nama }}</span>
            <span>/</span>
        @endif
        <span class="c-text-primary opacity-100">{{ $product->produk_nama }}</span>
    </nav>

    {{-- Product layout --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-24">

        {{-- LEFT: Image --}}
        <div data-aos="fade-up">
            <div class="overflow-hidden rounded-3xl" style="aspect-ratio:3/4;">
                @if($product->produk_gambar_utama)
                    <img id="main-image"
                         src="{{ asset('storage/' . $product->produk_gambar_utama) }}"
                         alt="{{ $product->produk_nama }}"
                         class="w-full h-full object-cover"
                         style="transform:scale(1); transition:transform 0.9s cubic-bezier(0.22,1,0.36,1);"
                         onmouseenter="this.style.transform='scale(1.04)'"
                         onmouseleave="this.style.transform='scale(1)'">
                @else
                    <div class="w-full h-full flex items-center justify-center" style="background:var(--color-bg-card);">
                        <i data-lucide="coffee" class="w-16 h-16 opacity-10"></i>
                    </div>
                @endif
            </div>

            {{-- Gallery thumbs --}}
            @if($product->produk_galeri && count($product->produk_galeri) > 0)
                <div class="flex gap-2 mt-3 overflow-x-auto pb-1">
                    @if($product->produk_gambar_utama)
                        <button class="gallery-thumb flex-shrink-0 w-16 h-16 rounded-xl overflow-hidden opacity-60 hover:opacity-100 transition"
                                data-image="{{ asset('storage/' . $product->produk_gambar_utama) }}">
                            <img src="{{ asset('storage/' . $product->produk_gambar_utama) }}" class="w-full h-full object-cover">
                        </button>
                    @endif
                    @foreach($product->produk_galeri as $img)
                        <button class="gallery-thumb flex-shrink-0 w-16 h-16 rounded-xl overflow-hidden opacity-60 hover:opacity-100 transition"
                                data-image="{{ asset('storage/' . $img) }}">
                            <img src="{{ asset('storage/' . $img) }}" class="w-full h-full object-cover">
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- RIGHT: Info --}}
        <div class="flex flex-col gap-8 lg:pt-4" data-aos="fade-up" data-aos-delay="80">

            {{-- Category + Name --}}
            <div>
                @if($product->category)
                    <p class="text-[10px] font-bold uppercase tracking-[0.3em] c-text-secondary opacity-50 mb-2">
                        {{ $product->category->kategori_nama }}
                    </p>
                @endif
                <h1 class="font-black c-text-primary leading-none mb-5"
                    style="font-size: clamp(2rem, 5vw, 3.5rem); letter-spacing:-0.03em;">
                    {{ $product->produk_nama }}
                </h1>
                @if($product->produk_harga)
                    <div class="flex items-baseline gap-3" translate="no">
                        @if($product->produk_harga_diskon)
                            <span class="font-black c-text-primary" style="font-size:clamp(1.5rem,3vw,2rem);">{{ $product->formatted_sale_price }}</span>
                            <span class="text-base line-through opacity-30 c-text-secondary">{{ $product->formatted_price }}</span>
                        @else
                            <span class="font-black c-text-primary" style="font-size:clamp(1.5rem,3vw,2rem);">{{ $product->formatted_price }}</span>
                        @endif
                    </div>
                @endif
            </div>

            {{-- Specs --}}
            @php
                $specs = [];
                if ($product->produk_origin)           $specs[] = ['icon' => 'map-pin',  'label' => 'Origin',           'value' => $product->produk_origin];
                if ($product->produk_profile_roasting) $specs[] = ['icon' => 'flame',    'label' => 'Roasting',         'value' => $product->produk_profile_roasting];
                if ($product->produk_ketinggian)       $specs[] = ['icon' => 'mountain', 'label' => 'Ketinggian',       'value' => $product->produk_ketinggian];
                if ($product->produk_varietas)         $specs[] = ['icon' => 'leaf',     'label' => 'Varietas',         'value' => $product->produk_varietas];
                if ($product->produk_process)          $specs[] = ['icon' => 'droplets', 'label' => 'Process',          'value' => $product->produk_process];
                if ($product->produk_roast_date)       $specs[] = ['icon' => 'calendar', 'label' => 'Roast Date',       'value' => $product->produk_roast_date->format('d M Y')];
                if ($product->produk_ukuran)           $specs[] = ['icon' => 'package',  'label' => 'Berat',            'value' => $product->produk_ukuran . ' gram'];
            @endphp

            @if(count($specs) > 0)
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-x-6 gap-y-5">
                    @foreach($specs as $spec)
                        <div>
                            <p class="text-[10px] font-bold uppercase tracking-[0.2em] opacity-40 c-text-secondary mb-0.5">{{ $spec['label'] }}</p>
                            <p class="text-sm font-semibold c-text-primary">{{ $spec['value'] }}</p>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Description --}}
            @if($product->produk_deskripsi)
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.2em] opacity-40 c-text-secondary mb-2">Deskripsi</p>
                    <div class="text-sm leading-relaxed opacity-60 c-text-primary prose prose-sm max-w-none">
                        {!! $product->produk_deskripsi !!}
                    </div>
                </div>
            @endif

            {{-- Extra specs --}}
            @if($product->produk_spesifikasi && count($product->produk_spesifikasi) > 0)
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.2em] opacity-40 c-text-secondary mb-3">Spesifikasi</p>
                    <div class="space-y-2">
                        @foreach($product->produk_spesifikasi as $spec)
                            <div class="flex gap-4 text-sm">
                                <span class="font-semibold opacity-40 w-28 flex-shrink-0">{{ $spec['key'] ?? '' }}</span>
                                <span class="opacity-70">{{ $spec['value'] ?? '' }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Quantity --}}
            <div class="flex items-center gap-4">
                <div class="inline-flex items-center rounded-full border"
                     style="border-color:var(--color-border); background:var(--color-bg-card);">
                    <button onclick="decrementQty()" class="w-10 h-10 flex items-center justify-center rounded-full c-text-secondary transition hover:c-text-primary">
                        <i data-lucide="minus" class="w-4 h-4"></i>
                    </button>
                    <input type="number" id="qty-input" value="1" min="1" readonly
                           class="w-12 text-center bg-transparent font-bold border-0 outline-none c-text-primary text-sm"
                           style="border:none !important;">
                    <button onclick="incrementQty()" class="w-10 h-10 flex items-center justify-center rounded-full c-text-secondary transition hover:c-text-primary">
                        <i data-lucide="plus" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>

            {{-- CTA --}}
            <div class="flex gap-3">
                <button onclick="addToCart()"
                        class="flex-1 flex items-center justify-center gap-2 py-4 rounded-full font-bold transition-all duration-200 hover:opacity-90 active:scale-95 c-btn-primary"
                        style="color:var(--color-accent-text);">
                    <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                    <span id="btn-text">Tambahkan ke Keranjang</span>
                </button>
                <button onclick="orderWhatsApp()"
                        class="px-5 py-4 rounded-full flex items-center justify-center transition hover:opacity-90 active:scale-95"
                        style="background:#25D366;" title="Order via WhatsApp">
                    <svg class="w-5 h-5" fill="white" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                    </svg>
                </button>
            </div>

        </div>
    </div>

    {{-- Related Products --}}
    @if($relatedProducts->count() > 0)
    <div class="mt-24" data-aos="fade-up">
        <p class="text-xs font-bold uppercase tracking-[0.3em] c-text-secondary opacity-40 mb-2">Lainnya</p>
        <h2 class="font-black c-text-primary mb-10" style="font-size:clamp(1.5rem,3vw,2rem); letter-spacing:-0.02em;">Produk Serupa</h2>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-x-6 gap-y-14">
            @foreach($relatedProducts as $related)
            <div data-aos="fade-up" data-aos-delay="{{ ($loop->index % 4) * 70 }}">
                <x-product-card :product="$related" />
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Back link --}}
    <div class="mt-16 pt-10" style="border-top: 1px solid var(--color-border);">
        <a href="{{ route('frontend.products.index') }}"
           class="inline-flex items-center gap-2 text-sm font-semibold opacity-40 hover:opacity-100 transition c-text-primary">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Kembali ke Produk
        </a>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const mainImage = document.getElementById('main-image');
    document.querySelectorAll('.gallery-thumb').forEach(thumb => {
        thumb.addEventListener('click', function () {
            if (mainImage) mainImage.src = this.dataset.image;
        });
    });
});

const CART_KEY = 'sektor21_cart';

function getCart() {
    const c = localStorage.getItem(CART_KEY);
    return c ? JSON.parse(c) : [];
}

function saveCart(cart) {
    localStorage.setItem(CART_KEY, JSON.stringify(cart));
    updateCartBadge();
}

function addToCart() {
    const product = {
        id: '{{ $product->produk_id }}',
        slug: '{{ $product->produk_slug }}',
        name: '{{ $product->produk_nama }}',
        price: {{ $product->produk_harga ?? 0 }},
        image: '{{ $product->produk_gambar_utama ? asset("storage/" . $product->produk_gambar_utama) : "" }}',
        qty: parseInt(document.getElementById('qty-input').value)
    };

    let cart = getCart();
    const existing = cart.find(i => i.id === product.id);
    if (existing) existing.qty += product.qty;
    else cart.push(product);
    saveCart(cart);

    const btnText = document.getElementById('btn-text');
    const btn = btnText.closest('button');
    btnText.textContent = '✓ Ditambahkan!';
    btn.style.opacity = '0.75';
    setTimeout(() => { btnText.textContent = 'Tambahkan ke Keranjang'; btn.style.opacity = '1'; }, 2000);
}

function incrementQty() {
    const i = document.getElementById('qty-input');
    i.value = parseInt(i.value) + 1;
}

function decrementQty() {
    const i = document.getElementById('qty-input');
    if (parseInt(i.value) > 1) i.value = parseInt(i.value) - 1;
}

function updateCartBadge() {
    const cart = getCart();
    const total = cart.reduce((s, i) => s + i.qty, 0);
    const badge = document.getElementById('cart-badge');
    if (badge) {
        badge.textContent = total;
        badge.style.display = total > 0 ? 'inline-flex' : 'none';
    }
}

function orderWhatsApp() {
    const name = '{{ $product->produk_nama }}';
    const price = '{{ $product->formatted_price }}';
    const qty = document.getElementById('qty-input').value;
    const url = window.location.href;
    const wa = '{{ setting("site_whatsapp") }}';
    if (!wa) { alert('Nomor WhatsApp tidak tersedia'); return; }
    const msg = `Halo, saya ingin memesan:\n\n*${name}*\nHarga: ${price}\nJumlah: ${qty}\nLink: ${url}\n\nApakah stok tersedia?`;
    window.open(`https://wa.me/${wa}?text=${encodeURIComponent(msg)}`, '_blank');
}

document.addEventListener('DOMContentLoaded', updateCartBadge);
</script>

<x-cart-script />

@endsection
