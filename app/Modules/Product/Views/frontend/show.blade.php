@extends('frontend.layouts.app')

@section('title', $product->produk_nama)
@section('meta_description', Str::limit(strip_tags($product->description), 155))
@section('meta_image', $product->featured_image ? asset('storage/' . $product->featured_image) : '')
@section('og_type', 'product')
@section('content')


<!-- Main Product Section -->
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

        <!-- LEFT: GAMBAR -->
        <div class="space-y-4">
            <div class="aspect-square rounded-xl overflow-hidden relative" style="background:var(--color-bg-card);">
                @if($product->produk_gambar_utama)
                    <img id="main-image"
                         src="{{ asset('storage/' . $product->produk_gambar_utama) }}"
                         alt="{{ $product->produk_nama }}"
                         class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-stone-300 to-stone-400">
                        <i data-lucide="coffee" class="w-20 h-20 text-white opacity-20"></i>
                    </div>
                @endif
            </div>

            @if($product->produk_galeri && count($product->produk_galeri) > 0)
                <div class="flex gap-2 overflow-x-auto">
                    @if($product->produk_gambar_utama)
                        <button class="gallery-thumb flex-shrink-0 w-16 h-16 rounded-lg overflow-hidden border transition"
                                style="border-color:var(--color-border);"
                                data-image="{{ asset('storage/' . $product->produk_gambar_utama) }}">
                            <img src="{{ asset('storage/' . $product->produk_gambar_utama) }}" class="w-full h-full object-cover">
                        </button>
                    @endif
                    @foreach($product->produk_galeri as $img)
                        <button class="gallery-thumb flex-shrink-0 w-16 h-16 rounded-lg overflow-hidden border transition"
                                style="border-color:var(--color-border);"
                                data-image="{{ asset('storage/' . $img) }}">
                            <img src="{{ asset('storage/' . $img) }}" class="w-full h-full object-cover">
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- RIGHT: INFO -->
        <div class="space-y-7">

            <!-- Nama + Harga -->
            <div>
                <h1 class="text-4xl lg:text-5xl font-bold leading-tight mb-5 c-text-primary">{{ $product->produk_nama }}</h1>
                @if($product->produk_harga)
                    <div class="flex items-baseline gap-3">
                        @if($product->produk_harga_diskon)
                            <span class="text-3xl font-bold c-text-accent">{{ $product->formatted_sale_price }}</span>
                            <span class="line-through opacity-40 text-lg">{{ $product->formatted_price }}</span>
                        @else
                            <span class="text-3xl font-bold c-text-accent">{{ $product->formatted_price }}</span>
                        @endif
                    </div>
                @endif
            </div>

            <!-- INFO BOX -->
            @php
                $specs = [];
                if ($product->category)              $specs[] = ['icon' => 'tag',       'label' => 'Jenis Kopi',         'value' => $product->category->kategori_nama];
                if ($product->produk_origin)         $specs[] = ['icon' => 'map-pin',   'label' => 'Origin',           'value' => $product->produk_origin];
                if ($product->produk_profile_roasting) $specs[] = ['icon' => 'flame',   'label' => 'Profile Roasting', 'value' => $product->produk_profile_roasting];
                if ($product->produk_ketinggian)     $specs[] = ['icon' => 'mountain',  'label' => 'Ketinggian',       'value' => $product->produk_ketinggian];
                if ($product->produk_varietas)       $specs[] = ['icon' => 'leaf',      'label' => 'Varietas',         'value' => $product->produk_varietas];
                if ($product->produk_process)        $specs[] = ['icon' => 'droplets',  'label' => 'Process',          'value' => $product->produk_process];
                if ($product->produk_roast_date)     $specs[] = ['icon' => 'calendar',  'label' => 'Roast Date',       'value' => $product->produk_roast_date->format('d M Y')];
                if ($product->produk_ukuran)         $specs[] = ['icon' => 'package',   'label' => 'Berat',            'value' => $product->produk_ukuran . ' gram'];
            @endphp

            @if(count($specs) > 0)
                <div class="rounded-lg py-5" style="margin: 20px 0px;">
                    <div class="grid grid-cols-3 gap-5">
                        @foreach($specs as $spec)
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0 mt-0.5">
                                    <i data-lucide="{{ $spec['icon'] }}" class="w-4 h-4 opacity-50 c-text-accent"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-medium uppercase tracking-wide opacity-50 c-text-accent">{{ $spec['label'] }}</p>
                                    <p class="text-sm font-semibold c-text-primary mt-0.5">{{ $spec['value'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Deskripsi -->
            @if($product->produk_deskripsi)
                <div class="my-3">
                    <p class="text-xs font-medium uppercase tracking-wide opacity-50 mb-2 c-text-accent">Deskripsi</p>
                    <p class="text-sm leading-relaxed opacity-70">
                        {!! $product->produk_deskripsi !!}
                    </p>
                </div>
            @endif

            <!-- Spesifikasi JSON -->
            @if($product->produk_spesifikasi && count($product->produk_spesifikasi) > 0)
                <div>
                    <p class="text-xs font-medium uppercase tracking-wide opacity-50 mb-2 c-text-accent">Spesifikasi</p>
                    <div class="space-y-2 text-sm">
                        @foreach($product->produk_spesifikasi as $spec)
                            <div class="flex gap-3">
                                <span class="font-medium opacity-50 w-24 flex-shrink-0">{{ $spec['key'] ?? '' }}</span>
                                <span class="opacity-70">{{ $spec['value'] ?? '' }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Quantity Selector -->
            <div class="flex items-center gap-4 pt-2">
                <div class="inline-flex items-center rounded-full border p-1"
                     style="border-color:var(--color-border); background:var(--color-bg-card);">
                    <button onclick="decrementQty()" class="w-9 h-9 flex items-center justify-center rounded-full transition c-text-secondary hover:c-text-primary" style="hover:background:var(--color-bg);">
                        <i data-lucide="minus" class="w-4 h-4"></i>
                    </button>
                    <input type="number" id="qty-input" value="1" min="1" readonly
                           class="w-16 h-9 text-center bg-transparent font-bold border-0 outline-none c-text-primary"
                           style="border:none !important;">
                    <button onclick="incrementQty()" class="w-9 h-9 flex items-center justify-center rounded-full transition c-text-secondary hover:c-text-primary">
                        <i data-lucide="plus" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>

            <!-- CTA -->
            <div class="flex gap-3 pt-6">
                <button onclick="addToCart()"
                   class="flex-1 flex items-center justify-center gap-2 py-4 rounded-full font-bold transition hover:opacity-90 active:scale-95 c-btn-primary"
                   style="color:var(--color-accent-text);">
                    <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                    <span id="btn-text">Tambahkan ke Keranjang</span>
                </button>
                <a href="javascript:void(0)" onclick="orderWhatsApp()" class="px-4 py-4 rounded-full transition hover:opacity-90" style="background:#25D366;" title="Order via WhatsApp">
                     <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="color: #fff !important;">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Related Products -->
@if($relatedProducts->count() > 0)
<section class="border-t py-12" style="border-color:var(--color-border);">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <p class="text-xs font-medium uppercase tracking-wide opacity-40 mb-3">Produk Lainnya</p>
        <h2 class="text-2xl font-bold mb-8">Rekomendasi Serupa</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach($relatedProducts as $related)
                <a href="{{ route('frontend.products.show', $related->produk_slug) }}"
                   class="group block rounded-lg overflow-hidden hover:shadow-md transition c-card">
                    <div class="h-48 overflow-hidden" style="background:var(--color-bg-card);">
                        @if($related->produk_gambar_utama)
                            <img src="{{ asset('storage/' . $related->produk_gambar_utama) }}"
                                 alt="{{ $related->produk_nama }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-stone-200 to-stone-300">
                                <i data-lucide="coffee" class="w-10 h-10 opacity-10"></i>
                            </div>
                        @endif
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-sm mb-2 line-clamp-2 group-hover:opacity-70 transition">{{ $related->produk_nama }}</h3>
                        <div class="flex items-center justify-between text-xs opacity-60">
                            @php
                                $relatedMeta = collect([$related->produk_origin, $related->produk_ukuran ? $related->produk_ukuran.'g' : null])->filter()->implode(' · ');
                            @endphp
                            <span>{{ $relatedMeta }}</span>
                            @if($related->produk_harga)
                                <span class="font-bold c-text-accent">{{ $related->formatted_price }}</span>
                            @endif
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Back -->
<div class="py-8 text-center border-t" style="border-color:var(--color-border);">
    <a href="{{ route('frontend.products.index') }}"
       class="inline-flex items-center gap-2 text-sm font-medium opacity-60 hover:opacity-100 transition">
        <i data-lucide="arrow-left" class="w-4 h-4"></i>
        Kembali ke Produk
    </a>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const mainImage = document.getElementById('main-image');
    const thumbs = document.querySelectorAll('.gallery-thumb');

    thumbs.forEach(thumb => {
        thumb.addEventListener('click', function (e) {
            e.preventDefault();
            if (mainImage) mainImage.src = this.dataset.image;
        });
    });
});

// ===== CART FUNCTIONS =====
const CART_KEY = 'sektor21_cart';

function getCart() {
    const cart = localStorage.getItem(CART_KEY);
    return cart ? JSON.parse(cart) : [];
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
        price: {{ $product->produk_harga }},
        image: '{{ $product->produk_gambar_utama ? asset("storage/" . $product->produk_gambar_utama) : "" }}',
        qty: parseInt(document.getElementById('qty-input').value)
    };

    let cart = getCart();
    const existingItem = cart.find(item => item.id === product.id);

    if (existingItem) {
        existingItem.qty += product.qty;
    } else {
        cart.push(product);
    }

    saveCart(cart);

    // Feedback
    const btnText = document.getElementById('btn-text');
    const btnEl = btnText.closest('button');
    const originalText = btnText.textContent;
    btnText.textContent = '✓ Ditambahkan!';
    btnEl.style.opacity = '0.8';
    setTimeout(() => {
        btnText.textContent = originalText;
        btnEl.style.opacity = '1';
    }, 2000);
}

function incrementQty() {
    const input = document.getElementById('qty-input');
    input.value = parseInt(input.value) + 1;
}

function decrementQty() {
    const input = document.getElementById('qty-input');
    if (parseInt(input.value) > 1) {
        input.value = parseInt(input.value) - 1;
    }
}

function updateCartBadge() {
    const cart = getCart();
    const totalQty = cart.reduce((sum, item) => sum + item.qty, 0);
    const badge = document.getElementById('cart-badge');
    if (badge) {
        if (totalQty > 0) {
            badge.textContent = totalQty;
            badge.style.display = 'inline-flex';
        } else {
            badge.style.display = 'none';
        }
    }
}

function orderWhatsApp() {
    const productName = '{{ $product->produk_nama }}';
    const productPrice = '{{ $product->formatted_price }}';
    const qty = document.getElementById('qty-input').value;
    const productUrl = window.location.href;
    const whatsappNumber = '{{ setting("site_whatsapp") }}';

    if (!whatsappNumber) {
        alert('Nomor WhatsApp tidak tersedia');
        return;
    }

    const message = `Halo, saya ingin memesan:\n\n *${productName}*\n Harga: ${productPrice}\n Jumlah: ${qty}\n Link: ${productUrl}\n\nBerapa stok tersedia? Dan apakah bisa dikirim ke alamat saya?`;
    const encodedMessage = encodeURIComponent(message);
    const whatsappUrl = `https://wa.me/${whatsappNumber}?text=${encodedMessage}`;

    window.open(whatsappUrl, '_blank');
}

// Init cart badge on page load
document.addEventListener('DOMContentLoaded', updateCartBadge);
</script>

@endsection
