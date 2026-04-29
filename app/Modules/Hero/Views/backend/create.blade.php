@extends('core::dashboard-layout')
@section('header', 'Tambah Hero')
@section('content')
<div class="space-y-6">
    <div class="flex items-center gap-3">
        <a href="{{ route('heroes.index') }}" class="text-gray-500 hover:text-gray-700">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <h1 class="text-2xl font-bold text-gray-900">Tambah Hero</h1>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('heroes.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Judul <span class="text-red-500">*</span></label>
                <input type="text" name="hero_title" value="{{ old('hero_title') }}" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-500 focus:outline-none @error('hero_title') border-red-400 @enderror">
                @error('hero_title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                <textarea name="hero_keterangan" rows="4"
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-500 focus:outline-none">{{ old('hero_keterangan') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Gambar</label>
                <input type="file" name="hero_image" accept="image/*" id="hero_image_input"
                       class="w-full text-sm text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-teal-50 file:text-teal-700">
                <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG. Maks 2MB.</p>

                <div id="preview-wrapper" class="hidden mt-3">
                    <p class="text-xs text-gray-500 mb-2">Preview:</p>
                    <img id="preview" src="#" alt="Preview" class="h-40 w-auto rounded-lg border border-gray-200 object-cover">
                </div>
            </div>


            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
                    <select name="hero_status" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-500 focus:outline-none">
                        <option value="1" {{ old('hero_status', '1') == '1' ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ old('hero_status') == '0' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="bg-teal-600 hover:bg-teal-700 text-white px-5 py-2 rounded-lg text-sm font-semibold transition">
                    Simpan
                </button>
                <a href="{{ route('heroes.index') }}"
                   class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2 rounded-lg text-sm font-semibold transition">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('hero_image_input').addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function (ev) {
            document.getElementById('preview').src = ev.target.result;
            document.getElementById('preview-wrapper').classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    });
</script>
@endsection