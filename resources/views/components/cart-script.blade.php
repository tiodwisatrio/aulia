<!-- Cart Toast -->
<style>
#cart-toast {
    position: fixed;
    top: 80px;
    left: 50%;
    transform: translateX(-50%) translateY(-20px);
    background: var(--color-accent);
    color: var(--color-accent-text);
    padding: 12px 20px;
    border-radius: 999px;
    font-size: 13px;
    font-weight: 600;
    z-index: 9999;
    white-space: nowrap;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
    display: flex;
    align-items: center;
    gap: 8px;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.3s ease, transform 0.3s ease;
}
#cart-toast.show {
    opacity: 1;
    transform: translateX(-50%) translateY(0);
}
</style>

<div id="cart-toast">
    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
    <span id="cart-toast-text"></span>
</div>

<script>
function addToCartCard(id, name, price, slug, image) {
    const CART_KEY = 'sektor21_cart';
    const cart = localStorage.getItem(CART_KEY) ? JSON.parse(localStorage.getItem(CART_KEY)) : [];
    const existing = cart.find(item => item.id == id);

    if (existing) {
        existing.qty += 1;
    } else {
        cart.push({ id: String(id), slug, name, price: parseFloat(price), image, qty: 1 });
    }

    localStorage.setItem(CART_KEY, JSON.stringify(cart));

    const totalQty = cart.reduce((sum, item) => sum + item.qty, 0);
    ['cart-badge', 'cart-badge-mobile'].forEach(badgeId => {
        const el = document.getElementById(badgeId);
        if (!el) return;
        el.textContent = totalQty;
        el.style.display = 'inline-flex';
    });

    // Toast
    const toast = document.getElementById('cart-toast');
    const toastText = document.getElementById('cart-toast-text');
    if (toast && toastText) {
        toastText.textContent = `"${name}" ditambahkan ke keranjang`;
        toast.classList.add('show');
        clearTimeout(toast._timer);
        toast._timer = setTimeout(() => toast.classList.remove('show'), 2500);
    }
}
</script>
