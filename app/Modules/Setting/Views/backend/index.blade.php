@extends('core::dashboard-layout')
@section('header', 'Pengaturan Sistem')
@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Pengaturan Sistem</h1>
        <p class="text-gray-500 text-sm mt-1">Kelola informasi dan identitas website</p>
    </div>

    <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="space-y-6">

            {{-- ======== IDENTITAS ======== --}}
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-3 bg-gray-50 border-b border-gray-200">
                    <h2 class="font-semibold text-gray-700 text-sm flex items-center gap-2">
                        <i data-lucide="building-2" class="w-4 h-4 text-teal-600"></i> Identitas
                    </h2>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Nama Site</label>
                        <input type="text" name="site_name" value="{{ old('site_name', $setting->site_name) }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500"
                            placeholder="Nama website">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Nama Lain</label>
                        <input type="text" name="site_name_alt" value="{{ old('site_name_alt', $setting->site_name_alt) }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500"
                            placeholder="Singkatan / nama alternatif">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-medium text-gray-600 mb-1">Alamat</label>
                        <textarea name="site_address" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500"
                            placeholder="Alamat lengkap">{{ old('site_address', $setting->site_address) }}</textarea>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-medium text-gray-600 mb-1">Deskripsi Singkat</label>
                        <textarea name="site_description" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500"
                            placeholder="Deskripsi singkat perusahaan">{{ old('site_description', $setting->site_description) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- ======== KONTAK ======== --}}
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-3 bg-gray-50 border-b border-gray-200">
                    <h2 class="font-semibold text-gray-700 text-sm flex items-center gap-2">
                        <i data-lucide="phone" class="w-4 h-4 text-teal-600"></i> Kontak
                    </h2>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">No. Telepon</label>
                        <input type="text" name="site_phone" value="{{ old('site_phone', $setting->site_phone) }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500"
                            placeholder="021-xxxxxxx">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">No. Fax</label>
                        <input type="text" name="site_fax" value="{{ old('site_fax', $setting->site_fax) }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500"
                            placeholder="021-xxxxxxx">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">No. HP</label>
                        <input type="text" name="site_mobile" value="{{ old('site_mobile', $setting->site_mobile) }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500"
                            placeholder="08xxxxxxxxxx">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Email</label>
                        <input type="email" name="site_email" value="{{ old('site_email', $setting->site_email) }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 @error('site_email') border-red-500 @enderror"
                            placeholder="info@example.com">
                        @error('site_email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">WhatsApp</label>
                        <input type="text" name="site_whatsapp" value="{{ old('site_whatsapp', $setting->site_whatsapp) }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500"
                            placeholder="628xxxxxxxxxx">
                    </div>
                </div>
            </div>

            {{-- ======== MEDIA SOSIAL ======== --}}
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-3 bg-gray-50 border-b border-gray-200">
                    <h2 class="font-semibold text-gray-700 text-sm flex items-center gap-2">
                        <i data-lucide="share-2" class="w-4 h-4 text-teal-600"></i> Media Sosial
                    </h2>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Instagram</label>
                        <input type="text" name="site_instagram" value="{{ old('site_instagram', $setting->site_instagram) }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500"
                            placeholder="https://instagram.com/...">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">YouTube</label>
                        <input type="text" name="site_youtube" value="{{ old('site_youtube', $setting->site_youtube) }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500"
                            placeholder="https://youtube.com/...">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">TikTok</label>
                        <input type="text" name="site_tiktok" value="{{ old('site_tiktok', $setting->site_tiktok) }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500"
                            placeholder="https://tiktok.com/@...">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Twitter / X</label>
                        <input type="text" name="site_twitter" value="{{ old('site_twitter', $setting->site_twitter) }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500"
                            placeholder="https://twitter.com/...">
                    </div>
                </div>
            </div>

            {{-- ======== MAP ======== --}}
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-3 bg-gray-50 border-b border-gray-200">
                    <h2 class="font-semibold text-gray-700 text-sm flex items-center gap-2">
                        <i data-lucide="map-pin" class="w-4 h-4 text-teal-600"></i> Peta Lokasi
                    </h2>
                </div>
                <div class="p-6">
                    <label class="block text-xs font-medium text-gray-600 mb-1">Embed Map (Google Maps iframe)</label>
                    <textarea name="site_map" rows="4"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 font-mono"
                        placeholder='<iframe src="https://maps.google.com/..."></iframe>'>{{ old('site_map', $setting->site_map) }}</textarea>
                    @if($setting->site_map)
                        <div class="mt-3 rounded-lg overflow-hidden border border-gray-200">
                            {!! $setting->site_map !!}
                        </div>
                    @endif
                </div>
            </div>

            {{-- ======== LOGO & ICON ======== --}}
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-3 bg-gray-50 border-b border-gray-200">
                    <h2 class="font-semibold text-gray-700 text-sm flex items-center gap-2">
                        <i data-lucide="image" class="w-4 h-4 text-teal-600"></i> Logo & Icon
                    </h2>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">

                    {{-- Logo Atas --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Logo Atas</label>
                        @if($setting->site_logo)
                            <div class="mb-2 p-2 bg-gray-50 rounded-lg border border-gray-200 flex items-center justify-center" style="min-height:80px">
                                <img src="{{ asset('storage/' . $setting->site_logo) }}" alt="Logo Atas" class="max-h-16 max-w-full object-contain">
                            </div>
                        @endif
                        <input type="file" name="site_logo" accept="image/*"
                            class="w-full text-sm text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
                        @error('site_logo')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG, SVG. Maks 2MB</p>
                    </div>

                    {{-- Logo Bawah --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Logo Bawah</label>
                        @if($setting->site_logo_dark)
                            <div class="mb-2 p-2 bg-gray-800 rounded-lg border border-gray-200 flex items-center justify-center" style="min-height:80px">
                                <img src="{{ asset('storage/' . $setting->site_logo_dark) }}" alt="Logo Bawah" class="max-h-16 max-w-full object-contain">
                            </div>
                        @endif
                        <input type="file" name="site_logo_dark" accept="image/*"
                            class="w-full text-sm text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
                        @error('site_logo_dark')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG, SVG. Maks 2MB</p>
                    </div>

                    {{-- Icon --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Icon / Favicon</label>
                        @if($setting->site_icon)
                            <div class="mb-2 p-2 bg-gray-50 rounded-lg border border-gray-200 flex items-center justify-center" style="min-height:80px">
                                <img src="{{ asset('storage/' . $setting->site_icon) }}" alt="Icon" class="max-h-16 max-w-full object-contain">
                            </div>
                        @endif
                        <input type="file" name="site_icon" accept=".png,.ico,.svg"
                            class="w-full text-sm text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
                        @error('site_icon')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        <p class="text-xs text-gray-400 mt-1">Format: PNG, ICO, SVG. Maks 512KB</p>
                    </div>

                </div>
            </div>

        </div>

        {{-- Action --}}
        <div class="mt-6">
            <button type="submit"
                class="bg-teal-600 hover:bg-teal-700 text-white px-8 py-2.5 rounded-lg font-semibold transition flex items-center gap-2 shadow-sm">
                <i data-lucide="save" class="w-4 h-4"></i>
                Simpan Pengaturan
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined') lucide.createIcons();
});
</script>
@endsection
