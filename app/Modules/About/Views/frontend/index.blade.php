@extends('frontend.layouts.app')

@section('title', 'Tentang Kami')

@section('content')
<!-- About Content -->
@if($abouts->count() > 0)
    @foreach($abouts as $index => $about)
        <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

                @if($about->tentang_gambar)
                    <!-- Image -->
                    <div class="{{ $index % 2 === 0 ? 'lg:order-1' : 'lg:order-2' }} aspect-square rounded-2xl overflow-hidden"
                         style="background:var(--color-bg-card);"
                         data-aos="{{ $index % 2 === 0 ? 'fade-right' : 'fade-left' }}">
                        <img src="{{ asset('storage/' . $about->tentang_gambar) }}"
                             alt="{{ $about->tentang_judul }}"
                             class="w-full h-full object-cover">
                    </div>
                @endif

                <!-- Content -->
                <div class="{{ $index % 2 === 0 ? 'lg:order-2' : 'lg:order-1' }}"
                     data-aos="{{ $index % 2 === 0 ? 'fade-left' : 'fade-right' }}" data-aos-delay="100">
                    <div class="mb-4">
                        <span class="text-xs font-bold uppercase tracking-widest opacity-40 c-text-accent">
                            Tentang Sektor21
                        </span>
                    </div>
                    <h2 class="text-3xl md:text-4xl font-bold leading-tight mb-5 c-text-primary">
                        {{ $about->tentang_judul }}
                    </h2>
                    <div class="prose prose-sm max-w-none mb-6 text-sm leading-relaxed opacity-75">
                        {!! $about->tentang_konten !!}
                    </div>

                    {{-- Stats --}}
                    @php
                        $stats = collect([
                            ['value' => $about->tentang_jumlah_origin,      'label' => 'Origins Kopi'],
                            ['value' => $about->tentang_jumlah_pelanggan,   'label' => 'Pelanggan'],
                            ['value' => $about->tentang_jumlah_fresh_roast, 'label' => 'Fresh Roast'],
                            ['value' => $about->tentang_tahun_berdiri,      'label' => 'Berdiri'],
                        ])->filter(fn($s) => !empty($s['value']));
                    @endphp
                    @if($stats->count() > 0)
                    <div class="grid grid-cols-2 gap-4 pt-6 border-t" style="border-color:var(--color-border);">
                        @foreach($stats as $i => $stat)
                        <div data-aos="fade-up" data-aos-delay="{{ 200 + ($i * 80) }}">
                            <p class="text-2xl font-bold c-text-primary">{{ $stat['value'] }}</p>
                            <p class="text-xs uppercase tracking-widest opacity-50 mt-0.5">{{ $stat['label'] }}</p>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </section>
    @endforeach
@else
    <div class="py-20 text-center">
        <i data-lucide="info" class="w-12 h-12 mx-auto mb-4 opacity-20"></i>
        <p class="text-sm opacity-50">Tidak ada informasi tentang kami saat ini.</p>
    </div>
@endif

<!-- Values Section -->
@if($ourvalues && $ourvalues->count() > 0)
    <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16 border-t" style="border-color:var(--color-border);">
        <div class="mb-12" data-aos="fade-up">
            <p class="text-xs font-bold uppercase tracking-widest opacity-40 mb-2">— Nilai-nilai Kami</p>
            <h2 class="text-3xl md:text-4xl font-bold c-text-primary">Prinsip yang Kami Pegang Teguh</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($ourvalues as $value)
                <div class="rounded-xl p-6 hover:shadow-sm transition duration-300 c-card"
                     data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    @if($value->nilai_kami_gambar)
                        <div class="w-14 h-14 rounded-2xl mb-5 flex items-center justify-center p-2.5" style="background:var(--color-bg);">
                            <img src="{{ asset('storage/' . $value->nilai_kami_gambar) }}"
                                 alt="{{ $value->nilai_kami_nama }}"
                                 class="w-full h-full object-contain"
                                 style="filter: var(--icon-img-filter, none);">
                        </div>
                    @else
                        <div class="w-14 h-14 rounded-2xl mb-5 flex items-center justify-center" style="background:var(--color-bg);">
                            <i data-lucide="star" class="w-7 h-7 c-text-accent"></i>
                        </div>
                    @endif

                    <h3 class="font-bold text-lg mb-2">{{ $value->nilai_kami_nama }}</h3>
                    <p class="text-sm opacity-70 leading-relaxed">{{ $value->nilai_kami_deskripsi }}</p>
                </div>
            @endforeach
        </div>
    </section>
@endif

<!-- CTA -->
<section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16 border-t" style="border-color:var(--color-border);">
    <div class="text-center py-8" data-aos="fade-up">
        <h2 class="text-3xl md:text-4xl font-bold mb-4 c-text-primary">Jelajahi Koleksi Kami</h2>
        <p class="text-sm opacity-60 mb-8 max-w-xl mx-auto">Rasakan sendiri kualitas dan keunggulan kopi pilihan kami yang telah melalui proses seleksi ketat.</p>
        <a href="{{ route('frontend.products.index') }}"
           class="inline-flex items-center gap-2 px-8 py-4 rounded-full font-bold transition hover:opacity-90 c-btn-primary"
           style="color: var(--color-accent-text);">
            Lihat Produk
            <i data-lucide="arrow-right" class="w-5 h-5"></i>
        </a>
    </div>
</section>

<div class="h-8"></div>

@endsection
