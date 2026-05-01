@extends('frontend.layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')


<!-- Header -->
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-4xl font-bold c-text-primary">Keranjang Belanja</h1>
</div>

<!-- Cart Container -->
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
    <div id="cart-empty" class="text-center py-16">
        <i data-lucide="shopping-cart" class="w-16 h-16 mx-auto mb-4 opacity-20"></i>
        <h3 class="text-lg font-bold mb-2">Keranjang Anda kosong</h3>
        <p class="opacity-60 text-sm mb-6">Mulai belanja sekarang dan temukan produk favorit Anda</p>
        <a href="{{ route('frontend.products.index') }}"
           class="inline-flex items-center gap-2 px-6 py-3 rounded-lg transition hover:opacity-90 c-btn-primary"
           style="color:var(--color-accent-text);">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Lanjut Belanja
        </a>
    </div>

    <div id="cart-content" class="hidden grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Cart Items -->
        <div class="lg:col-span-2 space-y-4">
            <div id="cart-items" class="space-y-4"></div>
        </div>

        <!-- Summary -->
        <div>
            <div class="rounded-lg p-5 sticky top-4 c-card">
                <h3 class="font-bold text-lg mb-4">Ringkasan</h3>

                <div class="space-y-3 text-sm mb-4 pb-4 border-b" style="border-color:var(--color-border);">
                    <div class="flex justify-between">
                        <span class="opacity-60">Subtotal</span>
                        <span class="font-semibold" id="subtotal">¥0</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="opacity-60">Pajak (0%)</span>
                        <span class="font-semibold" id="tax">¥0</span>
                    </div>
                </div>

                <div class="flex justify-between text-lg font-bold mb-6 c-text-accent">
                    <span>Total</span>
                    <span id="total">¥0</span>
                </div>

                <a href="javascript:void(0)" onclick="checkoutWhatsApp()"
                   class="w-full flex items-center justify-center gap-2 py-3 rounded-lg font-semibold transition hover:opacity-90 c-btn-primary"
                   style="margin-bottom:12px; color:var(--color-accent-text);">
                    <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                    Checkout
                </a>

                <a href="{{ route('frontend.products.index') }}"
                   class="w-full flex items-center justify-center gap-2 py-3 rounded-lg border font-medium transition hover:opacity-70 c-text-secondary"
                   style="border-color:var(--color-border);">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    Lanjut Belanja
                </a>

                <!-- <button onclick="clearCart()" class="w-full mt-4 text-xs font-medium opacity-40 hover:opacity-80 transition">
                    Hapus Keranjang
                </button> -->
            </div>
        </div>
    </div>
</div>

<script>
const CART_KEY = 'sektor21_cart';

function getCart() {
    const cart = localStorage.getItem(CART_KEY);
    return cart ? JSON.parse(cart) : [];
}

function saveCart(cart) {
    localStorage.setItem(CART_KEY, JSON.stringify(cart));
    renderCart();
    updateCartBadge();
}

function renderCart() {
    const cart = getCart();
    const container = document.getElementById('cart-items');
    const emptyState = document.getElementById('cart-empty');
    const content = document.getElementById('cart-content');

    if (cart.length === 0) {
        emptyState.classList.remove('hidden');
        content.classList.add('hidden');
        return;
    }

    emptyState.classList.add('hidden');
    content.classList.remove('hidden');

    const borderColor = getComputedStyle(document.documentElement).getPropertyValue('--color-border').trim();
    const cardBg = getComputedStyle(document.documentElement).getPropertyValue('--color-bg-card').trim();
    const textPrimary = getComputedStyle(document.documentElement).getPropertyValue('--color-text-primary').trim();

    container.innerHTML = cart.map((item, idx) => `
        <div class="flex gap-4 p-4 rounded-lg border" style="border-color:${borderColor};">
            <img src="${item.image || ''}" alt="${item.name}"
                 class="w-20 h-20 object-cover rounded-lg flex-shrink-0" style="background:${cardBg};">
            <div class="flex-1">
                <a href="/products/${item.slug}" class="font-bold text-sm hover:opacity-70 transition" style="color:${textPrimary};">${item.name}</a>
                <p class="text-sm opacity-60 mt-1">${formatPrice(item.price)}</p>
                <div class="flex items-center gap-2 mt-3">
                    <button onclick="updateQty(${idx}, -1)" class="w-6 h-6 flex items-center justify-center rounded transition" style="border:1px solid ${borderColor};">
                        <i data-lucide="minus" class="w-3 h-3"></i>
                    </button>
                    <span class="w-8 text-center text-sm font-semibold">${item.qty}</span>
                    <button onclick="updateQty(${idx}, 1)" class="w-6 h-6 flex items-center justify-center rounded transition" style="border:1px solid ${borderColor};">
                        <i data-lucide="plus" class="w-3 h-3"></i>
                    </button>
                </div>
            </div>
            <div class="text-right flex flex-col items-end">
                <p class="font-bold text-sm">${formatPrice(item.price * item.qty)}</p>
                <button onclick="removeFromCart(${idx})" class="opacity-30 hover:opacity-70 transition mt-8 flex items-center justify-end" title="Hapus">
                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                </button>
            </div>
        </div>
    `).join('');

    updateSummary();
    lucide.createIcons();
}

function updateQty(idx, change) {
    let cart = getCart();
    cart[idx].qty += change;
    if (cart[idx].qty < 1) {
        removeFromCart(idx);
    } else {
        saveCart(cart);
    }
}

function removeFromCart(idx) {
    let cart = getCart();
    cart.splice(idx, 1);
    saveCart(cart);
}

function clearCart() {
    if (confirm('Yakin ingin menghapus semua item?')) {
        localStorage.removeItem(CART_KEY);
        renderCart();
    }
}

function updateSummary() {
    const cart = getCart();
    const subtotal = cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
    const tax = 0;
    const total = subtotal + tax;

    document.getElementById('subtotal').textContent = formatPrice(subtotal);
    document.getElementById('tax').textContent = formatPrice(tax);
    document.getElementById('total').textContent = formatPrice(total);
}

function formatPrice(price) {
    return '¥' + Math.floor(price).toLocaleString('ja-JP');
}

function updateCartBadge() {
    const cart = getCart();
    const totalQty = cart.reduce((sum, item) => sum + item.qty, 0);
    const badge = document.getElementById('cart-badge');
    if (badge) {
        if (totalQty > 0) {
            badge.textContent = totalQty;
            badge.style.display = 'flex';
        } else {
            badge.style.display = 'none';
        }
    }
}

function checkoutWhatsApp() {
    const cart = getCart();
    if (cart.length === 0) {
        alert('Keranjang kosong');
        return;
    }

    const whatsappNumber = '{{ setting("site_whatsapp") }}';
    if (!whatsappNumber) {
        alert('Nomor WhatsApp tidak tersedia');
        return;
    }

    const itemsList = cart.map(item => `• ${item.name} (${item.qty}x) - ${formatPrice(item.price * item.qty)}`).join('\n');
    const total = cart.reduce((sum, item) => sum + (item.price * item.qty), 0);

    const message = `Halo, saya ingin memesan:\n\n${itemsList}\n\n *Total: ${formatPrice(total)}*\n\nApakah produk masih tersedia?`;
    const encodedMessage = encodeURIComponent(message);
    const whatsappUrl = `https://wa.me/${whatsappNumber}?text=${encodedMessage}`;

    window.open(whatsappUrl, '_blank');
}

// Init on page load
document.addEventListener('DOMContentLoaded', () => {
    renderCart();
    updateCartBadge();
});
</script>

@endsection
