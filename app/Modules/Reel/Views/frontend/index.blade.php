@extends('frontend.layouts.app')

@section('title', 'Projects')

@section('content')

{{-- Hero Header --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-12">
    <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.3em] mb-3" style="color:var(--color-text-muted);">— Our Work</p>
            <h1 class="text-5xl sm:text-6xl lg:text-7xl font-black leading-none tracking-tight" style="color:var(--color-text-primary);">
                Projects
            </h1>
        </div>
        <div class="flex items-center gap-3 md:flex-col md:items-end">
            <p class="text-sm leading-relaxed md:text-right" style="color:var(--color-text-muted);">
                Setiap frame adalah hasil dari<br class="hidden md:block"> proses, passion, dan dedikasi kami.
            </p>
            <span class="text-xs font-bold px-3 py-1 rounded-full flex-shrink-0"
                  style="background:var(--color-bg-card); color:var(--color-text-muted); border:1px solid var(--color-border);">
                {{ $reels->count() }} Projects
            </span>
        </div>
    </div>
    <div class="mt-10 h-px w-full" style="background:var(--color-border);"></div>
</section>

{{-- Projects Grid --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-24">
    @if($reels->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($reels as $reel)
            @php $idx = $loop->index + 1; @endphp
            <a href="{{ $reel->reel_url }}" target="_blank" rel="noopener"
               class="group block rounded-2xl overflow-hidden"
               style="background:var(--color-bg-card); border:1px solid var(--color-border);"
               data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 80 }}">

                {{-- Thumbnail --}}
                <div class="relative aspect-[3/2] overflow-hidden" style="background:var(--color-bg-card);">
                    @if($reel->reel_thumbnail)
                        <img src="{{ asset('storage/' . $reel->reel_thumbnail) }}"
                             alt="{{ $reel->reel_judul ?? 'Project' }}"
                             class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-110">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <span class="text-7xl font-black select-none" style="color:var(--color-border);">
                                {{ str_pad($idx, 2, '0', STR_PAD_LEFT) }}
                            </span>
                        </div>
                    @endif

                    {{-- Overlay on hover --}}
                    <div class="absolute inset-0 flex flex-col justify-between p-5 opacity-0 group-hover:opacity-100 transition-all duration-400"
                         style="background:rgba(0,0,0,0.55);">
                        <span class="text-xs font-bold tracking-widest" style="color:rgba(255,255,255,0.4);">
                            {{ str_pad($idx, 2, '0', STR_PAD_LEFT) }}
                        </span>
                        <div>
                            @if($reel->reel_judul)
                                <p class="font-black text-lg uppercase leading-tight mb-3 tracking-tight" style="color:#fff;">
                                    {{ $reel->reel_judul }}
                                </p>
                            @endif
                            <span class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-widest pb-0.5"
                                  style="color:rgba(255,255,255,0.8); border-bottom:1px solid rgba(255,255,255,0.3);">
                                <svg class="w-3.5 h-3.5 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                                Lihat di Instagram
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Bottom bar --}}
                <div class="flex items-center justify-between px-4 py-3">
                    <span class="text-xs font-black tracking-widest" style="color:var(--color-border);">
                        {{ str_pad($idx, 2, '0', STR_PAD_LEFT) }}
                    </span>
                    @if($reel->reel_judul)
                        <span class="text-xs font-semibold uppercase tracking-wider truncate mx-3" style="color:var(--color-text-muted);">
                            {{ $reel->reel_judul }}
                        </span>
                    @endif
                    <svg class="w-3.5 h-3.5 flex-shrink-0 transition-transform group-hover:translate-x-0.5 group-hover:-translate-y-0.5"
                         style="color:var(--color-text-muted);"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M7 17L17 7M17 7H7M17 7v10"/>
                    </svg>
                </div>

            </a>
            @endforeach
        </div>
    @else
        <div class="py-32 text-center">
            <p class="text-8xl font-black mb-6" style="color:var(--color-border);">00</p>
            <p class="text-sm uppercase tracking-widest" style="color:var(--color-text-muted);">Belum ada project</p>
        </div>
    @endif
</section>

{{-- CTA Section --}}
<section>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-8">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.3em] mb-3" style="color:var(--color-text-muted);">— Follow Us</p>
                <h2 class="text-4xl sm:text-5xl font-black leading-tight" style="color:var(--color-text-primary);">
                    Lihat lebih banyak<br>
                    <span style="color:var(--color-text-muted);">di Instagram</span>
                </h2>
            </div>
            <div class="flex flex-col items-start lg:items-end gap-3">
                <p class="text-sm" style="color:var(--color-text-muted);">Temukan konten terbaru seputar proses roasting,<br class="hidden lg:block"> tips kopi, dan koleksi kami.</p>
                <a href="https://www.instagram.com/sektor21_" target="_blank" rel="noopener"
                   class="group inline-flex items-center gap-3 px-7 py-3.5 rounded-full font-black text-sm text-white transition-all duration-300 hover:scale-105"
                   style="background:linear-gradient(135deg,#f09433 0%,#e6683c 25%,#dc2743 50%,#cc2366 75%,#bc1888 100%); box-shadow:0 8px 30px rgba(220,39,67,0.25);">
                    <svg class="w-4 h-4 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                    </svg>
                    @sektor21_
                    <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M7 17L17 7M17 7H7M17 7v10"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
