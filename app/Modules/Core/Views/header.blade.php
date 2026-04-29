<header id="navbar" class="c-navbar fixed top-0 left-0 right-0 z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 md:h-20">

            <!-- Logo -->
            <a href="{{ route('frontend.home') }}" class="flex items-center gap-x-3 hover:opacity-80 transition flex-shrink-0">
                @if(setting('site_logo'))
                    <img src="{{ asset('storage/' . setting('site_logo')) }}" alt="{{ setting('site_name', 'Logo') }}" class="h-10 w-auto object-contain rounded-full">
                @endif
                <span class="text-xl font-bold c-text-primary whitespace-nowrap">{{ setting('site_name', config('app.name')) }}</span>
            </a>

            <!-- Desktop Nav -->
            <nav class="hidden md:flex items-center gap-x-8">
                <a href="{{ route('frontend.home') }}"
                   class="{{ request()->routeIs('frontend.home') ? 'c-nav-active' : 'c-nav-link' }} text-sm transition duration-200">
                   Beranda
                </a>
                <a href="{{ route('frontend.abouts.index') }}"
                   class="{{ request()->routeIs('frontend.abouts.*') ? 'c-nav-active' : 'c-nav-link' }} text-sm transition duration-200">
                   Tentang Kami
                </a>
                <a href="{{ route('frontend.products.index') }}"
                   class="{{ request()->routeIs('frontend.products.*') ? 'c-nav-active' : 'c-nav-link' }} text-sm transition duration-200">
                   Produk
                </a>
                <a href="{{ route('frontend.reels.index') }}"
                   class="{{ request()->routeIs('frontend.reels.*') ? 'c-nav-active' : 'c-nav-link' }} text-sm transition duration-200">
                   Projects
                </a>
                <a href="{{ route('frontend.contacts.index') }}"
                   class="{{ request()->routeIs('frontend.contacts*') ? 'c-nav-active' : 'c-nav-link' }} text-sm transition duration-200">
                   Kontak
                </a>
                <a href="{{ route('frontend.cart') }}"
                   class="{{ request()->routeIs('frontend.cart') ? 'c-nav-active' : 'c-nav-link' }} relative text-sm transition duration-200">
                   Keranjang
                   <span id="cart-badge" class="c-badge" style="display:none; position:absolute; top:-8px; right:-14px; min-width:17px; height:17px; padding:0 4px; border-radius:999px; font-size:10px; font-weight:700; align-items:center; justify-content:center;"></span>
                </a>
            </nav>

            <!-- Desktop CTA + Theme Toggle -->
            <div class="hidden md:flex items-center gap-x-2 flex-shrink-0">
                <button id="theme-toggle" class="c-theme-toggle" aria-label="Toggle tema">
                    <!-- Sun icon (shown in dark mode) -->
                    <svg id="icon-sun" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/>
                    </svg>
                    <!-- Moon icon (shown in light mode) -->
                    <svg id="icon-moon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/>
                    </svg>
                </button>
                @guest
                    <a href="{{ route('login') }}" class="c-btn-outline px-4 py-2 text-sm rounded-lg font-semibold transition duration-200">
                        Login
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="c-btn-primary px-4 py-2 text-sm rounded-lg font-semibold transition duration-200">
                        Dashboard
                    </a>
                @endguest
            </div>

            <!-- Mobile: Theme Toggle + Hamburger -->
            <div class="flex md:hidden items-center gap-x-1">
            <button id="theme-toggle-mobile" class="c-theme-toggle" aria-label="Toggle tema">
                <svg id="icon-sun-mobile" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/>
                </svg>
                <svg id="icon-moon-mobile" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/>
                </svg>
            </button>
            <button id="mobile-menu-btn" class="flex items-center justify-center w-10 h-10 rounded-lg c-nav-link transition-transform duration-300 hover:opacity-70" aria-label="Toggle menu">
                <svg id="icon-open" class="w-6 h-6 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg id="icon-close" class="w-6 h-6 hidden absolute transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            </div><!-- end mobile controls wrapper -->

        </div>
    </div>
</header>

<!-- Mobile Menu — sibling navbar, bukan child, agar fixed positioning bekerja -->
<div id="mobile-menu" class="hidden md:hidden" style="
    position: fixed;
    top: 64px;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 45;
    background-color: rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(24px) saturate(180%);
    -webkit-backdrop-filter: blur(24px) saturate(180%);
    border-top: 1px solid rgba(0,0,0,0.06);
    transform: translateY(-12px);
    opacity: 0;
    transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.3s ease;
    overflow-y: auto;
    -webkit-overflow-scrolling: touch;
">
    <div class="px-4 py-4 flex flex-col gap-y-1">
        <a href="{{ route('frontend.home') }}" class="menu-link {{ request()->routeIs('frontend.home') ? 'c-nav-active' : 'c-nav-link' }} block px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200">
           Beranda
        </a>
        <a href="{{ route('frontend.abouts.index') }}" class="menu-link {{ request()->routeIs('frontend.abouts.*') ? 'c-nav-active' : 'c-nav-link' }} block px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200">
           Tentang Kami
        </a>
        <a href="{{ route('frontend.products.index') }}" class="menu-link {{ request()->routeIs('frontend.products.*') ? 'c-nav-active' : 'c-nav-link' }} block px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200">
           Produk
        </a>
        <a href="{{ route('frontend.reels.index') }}" class="menu-link {{ request()->routeIs('frontend.reels.*') ? 'c-nav-active' : 'c-nav-link' }} block px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200">
           Projects
        </a>
        <a href="{{ route('frontend.contacts.index') }}" class="menu-link {{ request()->routeIs('frontend.contacts*') ? 'c-nav-active' : 'c-nav-link' }} block px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200">
           Kontak
        </a>
        <a href="{{ route('frontend.cart') }}" class="menu-link {{ request()->routeIs('frontend.cart') ? 'c-nav-active' : 'c-nav-link' }} relative block px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200">
           Keranjang
           <span id="cart-badge-mobile" class="c-badge" style="display:none; position:absolute; top:8px; left:76px; min-width:17px; height:17px; padding:0 4px; border-radius:999px; font-size:10px; font-weight:700; align-items:center; justify-content:center;"></span>
        </a>

        <div class="pt-3 mt-2" style="border-top: 1px solid var(--color-border);">
            @guest
                <a href="{{ route('login') }}" class="menu-link c-btn-outline block w-full text-center px-4 py-2.5 text-sm rounded-xl font-semibold transition-all duration-200">
                    Login
                </a>
            @else
                <a href="{{ route('dashboard') }}" class="menu-link c-btn-primary block w-full text-center px-4 py-2.5 text-sm rounded-xl font-semibold transition-all duration-200">
                    Dashboard
                </a>
            @endguest
        </div>
    </div>
</div>

<!-- Spacer agar konten tidak tertutup navbar fixed -->
<div class="h-16 md:h-20"></div>

<script>
    const btn = document.getElementById('mobile-menu-btn');
    const menu = document.getElementById('mobile-menu');
    const iconOpen = document.getElementById('icon-open');
    const iconClose = document.getElementById('icon-close');
    let isMenuOpen = false;

    function openMenu() {
        isMenuOpen = true;
        // Navbar fixed → selalu di top 0, tingginya = offsetHeight
        const navbar = document.getElementById('navbar');
        const h = navbar.offsetHeight;
        menu.style.top    = h + 'px';
        menu.style.bottom = '0';
        menu.style.left   = '0';
        menu.style.right  = '0';
        menu.style.position = 'fixed';

        menu.classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // cegah scroll konten di bawah

        requestAnimationFrame(() => requestAnimationFrame(() => {
            menu.style.transform = 'translateY(0)';
            menu.style.opacity   = '1';
        }));

        iconOpen.classList.add('hidden');
        iconClose.classList.remove('hidden');
    }

    function closeMenu() {
        isMenuOpen = false;
        menu.style.transform = 'translateY(-12px)';
        menu.style.opacity   = '0';
        document.body.style.overflow = ''; // kembalikan scroll
        setTimeout(() => menu.classList.add('hidden'), 300);
        iconOpen.classList.remove('hidden');
        iconClose.classList.add('hidden');
    }

    btn.addEventListener('click', () => isMenuOpen ? closeMenu() : openMenu());

    menu.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', closeMenu);
    });

    const navbar = document.getElementById('navbar');
    function handleNavbarScroll() {
        if (window.scrollY > 20) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    }
    window.addEventListener('scroll', handleNavbarScroll, { passive: true });
    handleNavbarScroll(); // cek posisi awal saat load

    function updateCartBadge() {
        const cart = localStorage.getItem('sektor21_cart') ? JSON.parse(localStorage.getItem('sektor21_cart')) : [];
        const totalQty = cart.reduce((sum, item) => sum + item.qty, 0);

        const badge = document.getElementById('cart-badge');
        const badgeMobile = document.getElementById('cart-badge-mobile');

        [badge, badgeMobile].forEach(el => {
            if (!el) return;
            if (totalQty > 0) {
                el.textContent = totalQty;
                el.style.display = 'inline-flex';
            } else {
                el.style.display = 'none';
            }
        });
    }

    updateCartBadge();
    window.addEventListener('storage', updateCartBadge);

    // ── Theme Toggle ────────────────────────────────────────
    function applyThemeIcons(isDark) {
        // Desktop
        document.getElementById('icon-sun').classList.toggle('hidden', !isDark);
        document.getElementById('icon-moon').classList.toggle('hidden', isDark);
        // Mobile
        document.getElementById('icon-sun-mobile').classList.toggle('hidden', !isDark);
        document.getElementById('icon-moon-mobile').classList.toggle('hidden', isDark);
    }

    function toggleTheme() {
        const isDark = document.documentElement.classList.toggle('dark');
        localStorage.setItem('sektor21_theme', isDark ? 'dark' : 'light');
        applyThemeIcons(isDark);
    }

    // Set icons based on current state (set by inline script in <head>)
    applyThemeIcons(document.documentElement.classList.contains('dark'));

    document.getElementById('theme-toggle').addEventListener('click', toggleTheme);
    document.getElementById('theme-toggle-mobile').addEventListener('click', toggleTheme);
</script>
