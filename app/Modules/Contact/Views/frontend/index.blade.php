@extends('frontend.layouts.app')

@section('title', 'Kontak — ' . setting('site_name', config('app.name')))

@section('content')

<!-- Content Section -->
<div class="py-10 lg:py-15">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5">
        <div data-aos="fade-up">
            <h2 class="text-3xl font-bold c-text-primary mb-8">Hubungi Kami</h2>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-start">

            {{-- INFO CARDS (LEFT) --}}
            <div class="space-y-6">
                @if(setting('site_whatsapp'))
                <a href="https://wa.me/{{ preg_replace('/\D/', '', setting('site_whatsapp')) }}"
                   target="_blank" rel="noopener"
                   class="group flex items-start gap-4 p-6 rounded-2xl c-card hover:shadow-lg transition duration-300 cursor-pointer"
                   data-aos="fade-right" data-aos-delay="100">
                    <div class="w-14 h-14 rounded-xl flex items-center justify-center flex-shrink-0"
                         style="background:var(--color-border);">
                          <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                            </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-lg font-bold c-text-primary mb-1">WhatsApp</h3>
                        <p class="text-sm c-text-secondary">Chat dengan kami secara real-time</p>
                        <p class="text-base font-semibold mt-2 flex items-center gap-1">
                            {{ setting('site_whatsapp') }}
                            <i data-lucide="arrow-up-right" class="w-3 h-3 opacity-40 group-hover:opacity-100 transition"></i>
                        </p>
                    </div>
                </a>
                @endif

                @if(setting('site_email'))
                <div class="flex items-start gap-4 p-6 rounded-2xl c-card hover:shadow-md transition duration-300"
                     data-aos="fade-right" data-aos-delay="200">
                    <div class="w-14 h-14 rounded-xl flex items-center justify-center flex-shrink-0"
                         style="background:var(--color-border);">
                        <i data-lucide="mail" class="w-6 h-6 c-text-accent"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-lg font-bold c-text-primary mb-1">Email</h3>
                        <p class="text-sm c-text-secondary">Kirim email untuk pertanyaan bisnis</p>
                        <p class="text-base font-semibold mt-2 break-all">{{ setting('site_email') }}</p>
                    </div>
                </div>
                @endif

                @if(setting('site_address'))
                <div class="flex items-start gap-4 p-6 rounded-2xl c-card hover:shadow-md transition duration-300"
                     data-aos="fade-right" data-aos-delay="300">
                    <div class="w-14 h-14 rounded-xl flex items-center justify-center flex-shrink-0"
                         style="background:var(--color-border);">
                        <i data-lucide="map-pin" class="w-6 h-6 c-text-accent"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-lg font-bold c-text-primary mb-1">Lokasi</h3>
                        <p class="text-sm c-text-secondary mb-2">Kunjungi kantor kami</p>
                        <p class="text-base font-semibold leading-relaxed">{{ setting('site_address') }}</p>
                    </div>
                </div>
                @endif
            </div>

            {{-- FORM (RIGHT) --}}
            <div>
                @if(session('success'))
                    <div class="flex items-center gap-3 p-4 rounded-xl mb-6 border border-emerald-200 bg-emerald-50">
                        <i data-lucide="check-circle" class="w-5 h-5 flex-shrink-0 text-emerald-600"></i>
                        <p class="text-sm font-semibold text-emerald-700">{{ session('success') }}</p>
                    </div>
                @endif

                <div class="c-card rounded-2xl p-8" data-aos="fade-left" data-aos-delay="100">
                    <h2 class="text-2xl font-bold c-text-primary mb-6">Kirim Pesan</h2>

                    <form action="{{ route('frontend.contacts.store') }}" method="POST" class="space-y-5">
                        @csrf

                        <div>
                            <label class="block text-sm font-bold mb-2.5 c-text-primary">Nama Lengkap *</label>
                            <input type="text"
                                   name="hubungi_kami_nama"
                                   value="{{ old('hubungi_kami_nama') }}"
                                   placeholder="Nama lengkap Anda"
                                   required
                                   class="w-full px-4 py-3 rounded-lg border border-current border-opacity-20 focus:outline-none focus:border-opacity-60 focus:ring-2 focus:ring-current focus:ring-opacity-10 text-sm transition @error('hubungi_kami_nama') border-red-400 @enderror" style="background:var(--color-bg); color:var(--color-text-primary);">
                            @error('hubungi_kami_nama')
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold mb-2.5 c-text-primary">Email *</label>
                            <input type="email"
                                   name="hubungi_kami_email"
                                   value="{{ old('hubungi_kami_email') }}"
                                   placeholder="email@anda.com"
                                   required
                                   class="w-full px-4 py-3 rounded-lg border border-current border-opacity-20 focus:outline-none focus:border-opacity-60 focus:ring-2 focus:ring-current focus:ring-opacity-10 text-sm transition @error('hubungi_kami_email') border-red-400 @enderror" style="background:var(--color-bg); color:var(--color-text-primary);">
                            @error('hubungi_kami_email')
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold mb-2.5 c-text-primary">Subjek *</label>
                            <input type="text"
                                   name="hubungi_kami_subjek"
                                   value="{{ old('hubungi_kami_subjek') }}"
                                   placeholder="Topik pesan Anda"
                                   required
                                   class="w-full px-4 py-3 rounded-lg border border-current border-opacity-20 focus:outline-none focus:border-opacity-60 focus:ring-2 focus:ring-current focus:ring-opacity-10 text-sm transition @error('hubungi_kami_subjek') border-red-400 @enderror" style="background:var(--color-bg); color:var(--color-text-primary);">
                            @error('hubungi_kami_subjek')
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold mb-2.5 c-text-primary">Pesan *</label>
                            <textarea name="hubungi_kami_pesan"
                                      rows="5"
                                      placeholder="Tulis pesan Anda di sini..."
                                      required
                                      class="w-full px-4 py-3 rounded-lg border border-current border-opacity-20 focus:outline-none focus:border-opacity-60 focus:ring-2 focus:ring-current focus:ring-opacity-10 text-sm resize-none transition @error('hubungi_kami_pesan') border-red-400 @enderror" style="background:var(--color-bg); color:var(--color-text-primary);">{{ old('hubungi_kami_pesan') }}</textarea>
                            @error('hubungi_kami_pesan')
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                                class="w-full flex items-center justify-center gap-2 px-6 py-3.5 rounded-lg font-bold text-base c-btn-primary transition hover:opacity-90 active:scale-95">
                            <i data-lucide="send" class="w-5 h-5"></i>
                            Kirim Pesan
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
