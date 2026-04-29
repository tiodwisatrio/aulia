@extends('core::dashboard-layout')
@section('header', 'Edit Header')
@section('content')
<div class="space-y-6">
    <div class="flex items-center gap-3">
        <a href="{{ route('headers.index') }}" class="text-gray-500 hover:text-gray-700">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <h1 class="text-2xl font-bold text-gray-900">Edit Header</h1>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('headers.update', $header) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Section <span class="text-red-500">*</span></label>
                <input type="text" name="header_section" value="{{ old('header_section', $header->header_section) }}" required
                       placeholder="contoh: about, products, services"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-500 focus:outline-none">
                <p class="text-xs text-gray-400 mt-1">Key unik untuk mengidentifikasi section (huruf kecil, tanpa spasi)</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Judul <span class="text-red-500">*</span></label>
                <input type="text" name="header_title" value="{{ old('header_title', $header->header_title) }}" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-500 focus:outline-none @error('header_title') border-red-400 @enderror">
                @error('header_title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Subtitle</label>
                <textarea name="header_subtitle" rows="4"
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-500 focus:outline-none">{{ old('header_subtitle', $header->header_subtitle) }}</textarea>
            </div>

   

            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="bg-teal-600 hover:bg-teal-700 text-white px-5 py-2 rounded-lg text-sm font-semibold transition">
                    Simpan Perubahan
                </button>
                <a href="{{ route('headers.index') }}"
                   class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2 rounded-lg text-sm font-semibold transition">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
