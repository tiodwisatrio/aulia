<header id="navbar" class="c-navbar fixed top-0 left-0 right-0 z-50 backdrop-blur-md shadow-sm transition-all duration-300">
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
                   Home
                </a>
                <a href="{{ route('frontend.abouts.index') }}"
                   class="{{ request()->routeIs('frontend.abouts.*') ? 'c-nav-active' : 'c-nav-link' }} text-sm transition duration-200">
                   About
                </a>
                <a href="{{ route('frontend.blog.index') }}"
                   class="{{ request()->routeIs('frontend.blog.*') ? 'c-nav-active' : 'c-nav-link' }} text-sm transition duration-200">
                   Blog
                </a>
                <a href="{{ route('frontend.products.index') }}"
                   class="{{ request()->routeIs('frontend.products.*') ? 'c-nav-active' : 'c-nav-link' }} text-sm transition duration-200">
                   Products
                </a>
                <a href="{{ route('frontend.contacts.index') }}"
                   class="{{ request()->routeIs('frontend.contacts*') ? 'c-nav-active' : 'c-nav-link' }} text-sm transition duration-200">
                   Contact
                </a>
                <a href="{{ route('frontend.cart') }}"
                   class="{{ request()->routeIs('frontend.cart') ? 'c-nav-active' : 'c-nav-link' }} relative inline-flex items-center gap-1.5 text-sm transition duration-200">
                    <i data-lucide="shopping-cart" class="w-4 h-4"></i>
                    Keranjang
                    <span id="cart-badge" class="c-badge" style="display:none; position:absolute; top:-8px; right:-10px; min-width:18px; height:18px; padding:0 4px; border-radius:999px; font-size:10px; font-weight:700; align-items:center; justify-content:center;"></span>
                </a>
            </nav>

            <!-- Desktop CTA -->
            <div class="hidden md:flex items-center gap-4 flex-shrink-0">
                @guest
                    <a href="{{ route('login') }}" class="c-btn-outline px-4 py-2 text-sm rounded-lg transition duration-200">
                        Login
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="c-btn-primary px-4 py-2 text-sm rounded-lg transition duration-200">
                        Dashboard
                    </a>
                @endguest
            </div>

            <!-- Mobile Hamburger -->
            <button id="mobile-menu-btn" class="md:hidden flex items-center justify-center w-10 h-10 rounded-lg c-nav-link hover:opacity-70 transition" aria-label="Toggle menu">
                <svg id="icon-open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg id="icon-close" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="c-navbar hidden md:hidden border-t transition-all duration-300" style="border-color: var(--color-border);">
        <div class="max-w-7xl mx-auto px-4 py-3 flex flex-col gap-y-1">
            <a href="{{ route('frontend.home') }}"
               class="{{ request()->routeIs('frontend.home') ? 'c-nav-active' : 'c-nav-link' }} px-4 py-3 rounded-lg text-sm transition duration-200">
               Home
            </a>
            <a href="{{ route('frontend.abouts.index') }}"
               class="{{ request()->routeIs('frontend.abouts.*') ? 'c-nav-active' : 'c-nav-link' }} px-4 py-3 rounded-lg text-sm transition duration-200">
               About
            </a>
            <a href="{{ route('frontend.blog.index') }}"
               class="{{ request()->routeIs('frontend.blog.*') ? 'c-nav-active' : 'c-nav-link' }} px-4 py-3 rounded-lg text-sm transition duration-200">
               Blog
            </a>
            <a href="{{ route('frontend.products.index') }}"
               class="{{ request()->routeIs('frontend.products.*') ? 'c-nav-active' : 'c-nav-link' }} px-4 py-3 rounded-lg text-sm transition duration-200">
               Products
            </a>
            <a href="{{ route('frontend.contacts.index') }}"
               class="{{ request()->routeIs('frontend.contacts*') ? 'c-nav-active' : 'c-nav-link' }} px-4 py-3 rounded-lg text-sm transition duration-200">
               Contact
            </a>
            <div class="pt-2 pb-1 border-t mt-1" style="border-color: var(--color-border);">
                @guest
                    <a href="{{ route('login') }}" class="c-btn-outline block w-full text-center px-4 py-2.5 text-sm rounded-lg transition duration-200">
                        Login
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="c-btn-primary block w-full text-center px-4 py-2.5 text-sm rounded-lg transition duration-200">
                        Dashboard
                    </a>
                @endguest
            </div>
        </div>
    </div>
</header>

<!-- Spacer agar konten tidak tertutup navbar fixed -->
<div class="h-16 md:h-20"></div>

<script>
    const btn = document.getElementById('mobile-menu-btn');
    const menu = document.getElementById('mobile-menu');
    const iconOpen = document.getElementById('icon-open');
    const iconClose = document.getElementById('icon-close');

    btn.addEventListener('click', () => {
        menu.classList.toggle('hidden');
        iconOpen.classList.toggle('hidden');
        iconClose.classList.toggle('hidden');
    });

    menu.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            menu.classList.add('hidden');
            iconOpen.classList.remove('hidden');
            iconClose.classList.add('hidden');
        });
    });

    const navbar = document.getElementById('navbar');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 10) {
            navbar.classList.add('shadow-md');
            navbar.classList.remove('shadow-sm');
        } else {
            navbar.classList.remove('shadow-md');
            navbar.classList.add('shadow-sm');
        }
    });

    // Cart badge update
    function updateCartBadge() {
        const CART_KEY = 'sektor21_cart';
        const cart = localStorage.getItem(CART_KEY) ? JSON.parse(localStorage.getItem(CART_KEY)) : [];
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

    updateCartBadge();
    window.addEventListener('storage', updateCartBadge);
</script>
