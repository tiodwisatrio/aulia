@extends('core::dashboard-layout')
@section('header', 'Edit Foto Gallery')
@section('content')
<div class="space-y-6">
    <div class="flex items-center gap-3">
        <a href="{{ route('galleries.index') }}" class="text-gray-500 hover:text-gray-700">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <h1 class="text-2xl font-bold text-gray-900">Edit Foto Gallery</h1>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('galleries.update', $gallery) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Judul <span class="text-red-500">*</span></label>
                <input type="text" name="gallery_name" value="{{ old('gallery_name', $gallery->gallery_name) }}" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-500 focus:outline-none @error('gallery_name') border-red-400 @enderror">
                @error('gallery_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>


            <!-- Gambar: tampilkan existing + preview baru -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Gambar</label>

                @if($gallery->gallery_image)
                <div class="mb-2">
                    <p class="text-xs text-gray-500 mb-1">Gambar saat ini:</p>
                    <img id="current_img" src="{{ asset('storage/' . $gallery->gallery_image) }}"
                         class="h-40 rounded-lg border border-gray-200 object-cover">
                </div>
                @endif

                <input type="file" name="gallery_image" accept="image/*" id="img_input"
                       class="w-full text-sm text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-teal-50 file:text-teal-700">
                <p class="text-xs text-gray-400 mt-1">Kosongkan jika tidak ingin ganti gambar. Format: JPG, PNG. Maks 2MB.</p>

                <div id="preview_wrap" class="hidden mt-3">
                    <p class="text-xs text-gray-500 mb-1">Preview gambar baru:</p>
                    <img id="preview_img" src="#" class="h-40 rounded-lg border border-gray-200 object-cover">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
                <select name="gallery_status" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-500 focus:outline-none">
                    <option value="1" {{ old('gallery_status', $gallery->gallery_status) == '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ old('gallery_status', $gallery->gallery_status) == '0' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white px-5 py-2 rounded-lg text-sm font-semibold transition">Simpan Perubahan</button>
                <a href="{{ route('galleries.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2 rounded-lg text-sm font-semibold transition">Batal</a>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('img_input').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = ev => {
            document.getElementById('preview_img').src = ev.target.result;
            document.getElementById('preview_wrap').classList.remove('hidden');
            const cur = document.getElementById('current_img');
            if (cur) cur.classList.add('hidden'); // sembunyikan gambar lama
        };
        reader.readAsDataURL(file);
    });
</script>
@endsection