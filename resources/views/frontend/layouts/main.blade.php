<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', setting('site_name', config('app.name')))</title>

    <!-- Favicon -->
    @if(setting('site_logo'))
        <link rel="icon" type="image/png" href="{{ asset('storage/' . setting('site_logo')) }}">
        <link rel="shortcut icon" type="image/png" href="{{ asset('storage/' . setting('site_logo')) }}">
        <link rel="apple-touch-icon" href="{{ asset('storage/' . setting('site_logo')) }}">
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body>

    <!-- Header -->
    @include('frontend.layouts.header')

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    @include('frontend.layouts.footer')

    <script>lucide.createIcons();</script>
    @stack('scripts')
</body>
</html>
