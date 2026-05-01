<!DOCTYPE html>
<html lang="en" id="html-root">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $siteName     = setting('site_name', config('app.name'));
        $canonicalUrl = url()->current();
    @endphp

    <title>@hasSection('title')@yield('title') — {{ $siteName }}@else{{ $siteName }}@endif</title>

    {{-- Canonical --}}
    <link rel="canonical" href="{{ $canonicalUrl }}">

    {{-- Basic Meta --}}
    @hasSection('meta_description')
        <meta name="description" content="{{ Str::limit($__env->yieldContent('meta_description'), 160) }}">
    @elseif(setting('site_description'))
        <meta name="description" content="{{ Str::limit(setting('site_description'), 160) }}">
    @endif
    <meta name="robots" content="index, follow">

    {{-- Open Graph --}}
    <meta property="og:type"      content="@yield('og_type', 'website')">
    <meta property="og:url"       content="{{ $canonicalUrl }}">
    <meta property="og:title"     content="@hasSection('title')@yield('title') — {{ $siteName }}@else{{ $siteName }}@endif">
    <meta property="og:site_name" content="{{ $siteName }}">
    @hasSection('meta_description')
        <meta property="og:description" content="{{ Str::limit($__env->yieldContent('meta_description'), 200) }}">
    @elseif(setting('site_description'))
        <meta property="og:description" content="{{ Str::limit(setting('site_description'), 200) }}">
    @endif
    @hasSection('meta_image')
        <meta property="og:image"        content="@yield('meta_image')">
        <meta property="og:image:width"  content="1200">
        <meta property="og:image:height" content="630">
    @elseif(setting('site_logo'))
        <meta property="og:image" content="{{ asset('storage/' . setting('site_logo')) }}">
    @endif

    {{-- Twitter Card --}}
    <meta name="twitter:card"  content="summary_large_image">
    <meta name="twitter:title" content="@hasSection('title')@yield('title') — {{ $siteName }}@else{{ $siteName }}@endif">
    @hasSection('meta_description')
        <meta name="twitter:description" content="{{ Str::limit($__env->yieldContent('meta_description'), 200) }}">
    @elseif(setting('site_description'))
        <meta name="twitter:description" content="{{ Str::limit(setting('site_description'), 200) }}">
    @endif
    @hasSection('meta_image')
        <meta name="twitter:image" content="@yield('meta_image')">
    @elseif(setting('site_logo'))
        <meta name="twitter:image" content="{{ asset('storage/' . setting('site_logo')) }}">
    @endif

    {{-- Extra SEO slots (e.g. article:published_time) --}}
    @stack('seo_meta')

    {{-- Google Search Console Verification --}}
    <meta name="google-site-verification" content="xbpTBIsNXuqLpybW7J2dicykb8jneTFiMLszRVdkHD8" />

    <!-- Theme init — runs before render to prevent flash -->
    <script>
        (function() {
            var saved = localStorage.getItem('sektor21_theme');
            var prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (saved === 'dark' || (!saved && prefersDark)) {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>

    <!-- Favicon -->
    @if(setting('site_logo'))
        <link rel="icon" type="image/png" href="{{ asset('storage/' . setting('site_logo')) }}">
        <link rel="shortcut icon" type="image/png" href="{{ asset('storage/' . setting('site_logo')) }}">
        <link rel="apple-touch-icon" href="{{ asset('storage/' . setting('site_logo')) }}">
    @endif

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Crimson+Text:ital,wght@0,400;0,600;0,700;1,400;1,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

    <!-- Flag Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@7.2.3/css/flag-icons.min.css"/>

    <!-- AOS (Animate On Scroll) -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
</head>
<body>
    <!-- Include Header Component -->
    @include('core::header')

    <!-- Spacer: tampil di semua halaman kecuali yang punya hero full-screen (set @section('no_navbar_spacer')) -->
    @unless(View::hasSection('no_navbar_spacer'))
        <div class="h-28"></div>
    @endunless

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    @include('frontend.layouts.footer')

    <!-- AOS Library -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>

    <!-- Initialize AOS & Lucide Icons -->
    <script>
        AOS.init({
            duration: 800,
            easing: 'ease-out-quad',
            once: true,
            offset: 100,
            delay: 0
        });

        lucide.createIcons();
    </script>
</body>
</html>
