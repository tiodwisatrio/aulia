<header id="navbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300" style="padding: 12px 16px;">
    <div class="max-w-6xl mx-auto">
        <div class="flex items-center justify-between px-8 py-4 rounded-full"
             style="background: rgba(255,255,255,0.85); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); box-shadow: 0 2px 20px rgba(0,0,0,0.08); border: 1px solid rgba(255,255,255,0.6);">

            <!-- Logo -->
            <a href="{{ route('frontend.home') }}" class="flex items-center hover:opacity-80 transition flex-shrink-0">
                @if(setting('site_logo'))
                    <img src="{{ asset('storage/' . setting('site_logo')) }}" alt="{{ setting('site_name', 'Logo') }}" class="h-8 w-auto object-contain rounded-full mr-2">
                @endif
                <span class="text-lg font-bold whitespace-nowrap" style="color: var(--color-text-primary);">{{ setting('site_name', config('app.name')) }}</span>
            </a>

            <!-- Desktop Nav -->
            <nav class="hidden md:flex items-center gap-x-1">
                <a href="{{ route('frontend.home') }}"
                   class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ request()->routeIs('frontend.home') ? 'c-pill-link-active' : 'c-pill-link' }}">
                   Beranda
                </a>
                <a href="{{ route('frontend.abouts.index') }}"
                   class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ request()->routeIs('frontend.abouts.*') ? 'c-pill-link-active' : 'c-pill-link' }}">
                   Tentang Kami
                </a>
                <a href="{{ route('frontend.products.index') }}"
                   class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ request()->routeIs('frontend.products.*') ? 'c-pill-link-active' : 'c-pill-link' }}">
                   Produk
                </a>
                <a href="{{ route('frontend.reels.index') }}"
                   class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ request()->routeIs('frontend.reels.*') ? 'c-pill-link-active' : 'c-pill-link' }}">
                   Projects
                </a>
                <a href="{{ route('frontend.contacts.index') }}"
                   class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ request()->routeIs('frontend.contacts*') ? 'c-pill-link-active' : 'c-pill-link' }}">
                   Kontak
                </a>
                <a href="{{ route('frontend.cart') }}"
                   class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 relative {{ request()->routeIs('frontend.cart') ? 'c-pill-link-active' : 'c-pill-link' }}">
                   Keranjang
                   <span id="cart-badge" class="c-badge" style="display:none; position:absolute; top:-4px; right:-6px; min-width:17px; height:17px; padding:0 4px; border-radius:999px; font-size:10px; font-weight:700; align-items:center; justify-content:center; background:#ef4444; color:#fff;"></span>
                </a>
            </nav>

            <!-- Desktop CTA -->
            <div class="hidden md:flex items-center gap-x-2 flex-shrink-0">
                <button id="theme-toggle" aria-label="Toggle dark mode"
                    class="c-pill-toggle flex items-center justify-center w-9 h-9 rounded-full transition-all duration-200">
                    <i id="icon-sun" data-lucide="sun" class="w-4 h-4 hidden"></i>
                    <i id="icon-moon" data-lucide="moon" class="w-4 h-4"></i>
                </button>
                @guest
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full text-sm font-semibold text-white transition-all duration-200 hover:opacity-90"
                       style="background: #16a34a;">
                        Login
                    </a>
                @else
                    <a href="{{ route('dashboard') }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full text-sm font-semibold text-white transition-all duration-200 hover:opacity-90"
                       style="background: #16a34a;">
                        Dashboard
                    </a>
                @endguest
            </div>

            <!-- Mobile: Hamburger -->
            <button id="mobile-menu-btn" class="c-pill-toggle flex md:hidden items-center justify-center w-9 h-9 rounded-full transition" aria-label="Toggle menu">
                <svg id="icon-open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg id="icon-close" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

        </div>
    </div>
</header>

<!-- Mobile Menu -->
<div id="mobile-menu" class="hidden md:hidden" style="
    position: fixed;
    top: 100px;
    left: 16px;
    right: 16px;
    z-index: 45;
    background: rgba(255,255,255,0.85);
    backdrop-filter: blur(20px) saturate(180%);
    -webkit-backdrop-filter: blur(20px) saturate(180%);
    border-radius: 16px;
    box-shadow: 0 2px 20px rgba(0,0,0,0.08);
    border: 1px solid rgba(255,255,255,0.6);
    transform: translateY(-8px);
    opacity: 0;
    transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.3s ease;
    overflow: hidden;
">
    <div class="px-3 py-3 flex flex-col gap-y-1">
        <a href="{{ route('frontend.home') }}" class="menu-link block px-4 py-2.5 rounded-full text-sm font-medium transition-all duration-200 {{ request()->routeIs('frontend.home') ? 'c-pill-link-active' : 'c-pill-link' }}">Beranda</a>
        <a href="{{ route('frontend.abouts.index') }}" class="menu-link block px-4 py-2.5 rounded-full text-sm font-medium transition-all duration-200 {{ request()->routeIs('frontend.abouts.*') ? 'c-pill-link-active' : 'c-pill-link' }}">Tentang Kami</a>
        <a href="{{ route('frontend.products.index') }}" class="menu-link block px-4 py-2.5 rounded-full text-sm font-medium transition-all duration-200 {{ request()->routeIs('frontend.products.*') ? 'c-pill-link-active' : 'c-pill-link' }}">Produk</a>
        <a href="{{ route('frontend.reels.index') }}" class="menu-link block px-4 py-2.5 rounded-full text-sm font-medium transition-all duration-200 {{ request()->routeIs('frontend.reels.*') ? 'c-pill-link-active' : 'c-pill-link' }}">Projects</a>
        <a href="{{ route('frontend.contacts.index') }}" class="menu-link block px-4 py-2.5 rounded-full text-sm font-medium transition-all duration-200 {{ request()->routeIs('frontend.contacts*') ? 'c-pill-link-active' : 'c-pill-link' }}">Kontak</a>
        <a href="{{ route('frontend.cart') }}" class="menu-link relative block px-4 py-2.5 rounded-full text-sm font-medium transition-all duration-200 {{ request()->routeIs('frontend.cart') ? 'c-pill-link-active' : 'c-pill-link' }}">
            Keranjang
            <span id="cart-badge-mobile" style="display:none; position:absolute; top:6px; left:80px; min-width:17px; height:17px; padding:0 4px; border-radius:999px; font-size:10px; font-weight:700; align-items:center; justify-content:center; background:#ef4444; color:#fff;"></span>
        </a>
        <div class="pt-2 mt-1 flex flex-col gap-2" style="border-top: 1px solid var(--color-border);">
            <button id="theme-toggle-mobile" aria-label="Toggle dark mode"
                class="c-pill-toggle menu-link flex items-center gap-3 w-full px-4 py-2.5 rounded-full text-sm font-medium transition-all duration-200">
                <i id="icon-sun-mobile" data-lucide="sun" class="w-4 h-4 hidden"></i>
                <i id="icon-moon-mobile" data-lucide="moon" class="w-4 h-4"></i>
                <span id="theme-label-mobile">Dark Mode</span>
            </button>
            @guest
                <a href="{{ route('login') }}" class="menu-link flex items-center justify-center gap-2 w-full px-4 py-2.5 rounded-full text-sm font-semibold text-white transition-all duration-200" style="background:#16a34a;">Login</a>
            @else
                <a href="{{ route('dashboard') }}" class="menu-link flex items-center justify-center gap-2 w-full px-4 py-2.5 rounded-full text-sm font-semibold text-white transition-all duration-200" style="background:#16a34a;">Dashboard</a>
            @endguest
        </div>
    </div>
</div>


<script>
    const btn = document.getElementById('mobile-menu-btn');
    const menu = document.getElementById('mobile-menu');
    const iconOpen = document.getElementById('icon-open');
    const iconClose = document.getElementById('icon-close');
    let isMenuOpen = false;

    function openMenu() {
        isMenuOpen = true;
        menu.classList.remove('hidden');
        requestAnimationFrame(() => requestAnimationFrame(() => {
            menu.style.transform = 'translateY(0)';
            menu.style.opacity = '1';
        }));
        iconOpen.classList.add('hidden');
        iconClose.classList.remove('hidden');
    }

    function closeMenu() {
        isMenuOpen = false;
        menu.style.transform = 'translateY(-8px)';
        menu.style.opacity = '0';
        setTimeout(() => menu.classList.add('hidden'), 300);
        iconOpen.classList.remove('hidden');
        iconClose.classList.add('hidden');
    }

    btn.addEventListener('click', () => isMenuOpen ? closeMenu() : openMenu());
    menu.querySelectorAll('a').forEach(link => link.addEventListener('click', closeMenu));

    function updateCartBadge() {
        const cart = localStorage.getItem('sektor21_cart') ? JSON.parse(localStorage.getItem('sektor21_cart')) : [];
        const totalQty = cart.reduce((sum, item) => sum + item.qty, 0);
        [document.getElementById('cart-badge'), document.getElementById('cart-badge-mobile')].forEach(el => {
            if (!el) return;
            if (totalQty > 0) { el.textContent = totalQty; el.style.display = 'inline-flex'; }
            else { el.style.display = 'none'; }
        });
    }

    updateCartBadge();
    window.addEventListener('storage', updateCartBadge);

    // Dark mode toggle
    const PILL_BG_LIGHT = 'rgba(255,255,255,0.85)';
    const PILL_BG_DARK  = 'rgba(20,20,20,0.85)';
    const MOBILE_MENU_BG_DARK = 'rgba(20,20,20,0.92)';

    function applyNavbarDarkStyles(isDark) {
        const pill = document.querySelector('#navbar .flex.items-center.justify-between');
        const mobileMenu = document.getElementById('mobile-menu');
        if (pill) {
            pill.style.background = isDark ? PILL_BG_DARK : PILL_BG_LIGHT;
            pill.style.borderColor = isDark ? 'rgba(255,255,255,0.08)' : 'rgba(255,255,255,0.6)';
        }
        if (mobileMenu) {
            mobileMenu.style.background = isDark ? MOBILE_MENU_BG_DARK : PILL_BG_LIGHT;
            mobileMenu.style.borderColor = isDark ? 'rgba(255,255,255,0.08)' : 'rgba(255,255,255,0.6)';
        }
    }

    function syncThemeIcons() {
        const isDark = document.documentElement.classList.contains('dark');
        document.getElementById('icon-sun').classList.toggle('hidden', !isDark);
        document.getElementById('icon-moon').classList.toggle('hidden', isDark);
        document.getElementById('icon-sun-mobile').classList.toggle('hidden', !isDark);
        document.getElementById('icon-moon-mobile').classList.toggle('hidden', isDark);
        document.getElementById('theme-label-mobile').textContent = isDark ? 'Light Mode' : 'Dark Mode';
        applyNavbarDarkStyles(isDark);
        if (typeof lucide !== 'undefined') lucide.createIcons();
    }

    function toggleTheme() {
        const isDark = document.documentElement.classList.toggle('dark');
        localStorage.setItem('sektor21_theme', isDark ? 'dark' : 'light');
        syncThemeIcons();
    }

    document.getElementById('theme-toggle').addEventListener('click', toggleTheme);
    document.getElementById('theme-toggle-mobile').addEventListener('click', toggleTheme);

    syncThemeIcons();
</script>
