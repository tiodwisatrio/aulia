@extends('core::dashboard-layout')
@section('header', 'Detail Foto Gallery')
@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('galleries.index') }}" class="text-gray-500 hover:text-gray-700">
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
            </a>
            <h1 class="text-2xl font-bold text-gray-900">{{ $gallery->gallery_name }}</h1>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('galleries.edit', $gallery) }}"
               class="bg-teal-600 hover:bg-teal-700 text-white px-5 py-2 rounded-lg text-sm font-semibold transition">
                Edit
            </a>
            <form action="{{ route('galleries.destroy', $gallery) }}" method="POST" class="inline"
                  onsubmit="return confirm('Hapus gallery ini?')">
                @csrf @method('DELETE')
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-lg text-sm font-semibold transition">
                    Hapus
                </button>
            </form>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4">
        @if($gallery->gallery_image)
        <img src="{{ asset('storage/' . $gallery->gallery_image) }}" class="rounded-lg max-h-64 object-cover">
        @endif

        <div>
            <p class="text-xs text-gray-500 font-semibold">DESKRIPSI</p>
            <p class="text-gray-700 mt-1">{{ $gallery->gallery_deskripsi ?? '-' }}</p>
        </div>

        <div>
            <p class="text-xs text-gray-500 font-semibold">STATUS</p>
            <span class="mt-1 inline-block text-xs font-semibold px-3 py-1 rounded-full
                {{ $gallery->gallery_status ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                {{ $gallery->gallery_status ? 'Aktif' : 'Nonaktif' }}
            </span>
        </div>

        <div>
            <p class="text-xs text-gray-500 font-semibold">DIBUAT</p>
            <p class="text-gray-700 mt-1">{{ $gallery->created_at->format('d M Y, H:i') }}</p>
        </div>
    </div>

    <a href="{{ route('galleries.index') }}" class="text-teal-600 hover:text-teal-900 font-semibold">
        ← Kembali ke Gallery
    </a>
</div>
@endsection