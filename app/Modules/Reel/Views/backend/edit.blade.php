@extends('core::dashboard-layout')
@section('header', 'Edit Reel')
@section('content')
<div class="space-y-4">
    <!-- Header -->
    <div class="flex items-center gap-3">
        <a href="{{ route('reels.index') }}" class="text-gray-400 hover:text-gray-600 p-1">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Edit Reel</h1>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6">
        <form action="{{ route('reels.update', $reel) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <!-- URL -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    URL Instagram Reel <span class="text-red-500">*</span>
                </label>
                <input type="url" name="reel_url" value="{{ old('reel_url', $reel->reel_url) }}" required
                       placeholder="https://www.instagram.com/reel/xxxxx/"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 @error('reel_url') border-red-400 @enderror">
                <p class="text-xs text-gray-400 mt-1">Paste link reel dari Instagram (share → Copy Link)</p>
                @error('reel_url') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Judul -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Judul <span class="text-gray-400 font-normal">(opsional)</span></label>
                <input type="text" name="reel_judul" value="{{ old('reel_judul', $reel->reel_judul) }}"
                       placeholder="Judul reel untuk referensi admin"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
            </div>

            <!-- Thumbnail -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Thumbnail</label>
                @if($reel->reel_thumbnail)
                    <div class="mb-3">
                        <img id="current-preview" src="{{ asset('storage/' . $reel->reel_thumbnail) }}"
                             alt="Thumbnail" class="h-48 w-auto rounded-xl border border-gray-200 object-cover">
                        <p class="text-xs text-gray-400 mt-1">Thumbnail saat ini</p>
                    </div>
                @endif
                <input type="file" name="reel_thumbnail" accept="image/*" id="thumbnail_input"
                       class="w-full text-sm text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-teal-50 file:text-teal-700">
                <p class="text-xs text-gray-400 mt-1">Kosongkan jika tidak ingin mengganti. Format: JPG, PNG. Maks 2MB.</p>
                @error('reel_thumbnail') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                <div id="preview-wrapper" class="hidden mt-3">
                    <img id="preview" src="#" alt="Preview baru" class="h-48 w-auto rounded-xl border border-gray-200 object-cover">
                </div>
            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
                <select name="reel_status" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                    <option value="1" {{ $reel->reel_status ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ !$reel->reel_status ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            <!-- Buttons -->
            <div class="flex gap-3 pt-2 border-t">
                <button type="submit"
                        class="inline-flex items-center gap-2 bg-teal-600 hover:bg-teal-700 text-white px-5 py-2.5 rounded-lg text-sm font-semibold transition">
                    <i data-lucide="save" class="w-4 h-4"></i> Simpan Perubahan
                </button>
                <a href="{{ route('reels.index') }}"
                   class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2.5 rounded-lg text-sm font-semibold transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
<script>
document.getElementById('thumbnail_input').addEventListener('change', function (e) {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function (ev) {
        document.getElementById('preview').src = ev.target.result;
        document.getElementById('preview-wrapper').classList.remove('hidden');
        const cur = document.getElementById('current-preview');
        if (cur) cur.classList.add('hidden');
    };
    reader.readAsDataURL(file);
});
</script>
@endsection
