@extends('core::dashboard-layout')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ $post->title }}</h1>
            <p class="text-gray-600 mt-1">{{ $post->created_at->format('d M Y H:i') }}</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('posts.edit', $post) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                Edit
            </a>
            <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg font-semibold transition" onclick="return confirm('Yakin ingin menghapus?')">
                    Hapus
                </button>
            </form>
        </div>
    </div>

    <!-- Content -->
    <div class="grid grid-cols-3 gap-6">
        <div class="col-span-2 space-y-6">
            <!-- Featured Image -->
            @if($post->featured_image)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-96 object-cover">
            </div>
            @endif

            <!-- Post Content -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                <div class="prose max-w-none">
                    {!! nl2br(e($post->content)) !!}
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Meta Info -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Informasi</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-gray-600 font-semibold">PENULIS</p>
                        <p class="text-gray-900">{{ $post->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600 font-semibold">KATEGORI</p>
                        <p class="text-gray-900">{{ $post->category?->name ?? 'Tidak ada' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600 font-semibold">STATUS</p>
                        <span class="text-xs font-semibold px-3 py-1 rounded-full
                            @if($post->status === 'active') bg-green-100 text-green-800
                            @elseif($post->status === 'draft') bg-yellow-100 text-yellow-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ ucfirst($post->status) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600 font-semibold">FEATURED</p>
                        <p class="text-gray-900">{{ $post->is_featured ? 'Ya' : 'Tidak' }}</p>
                    </div>
                </div>
            </div>

            <!-- Dates -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Timeline</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-gray-600 font-semibold">DIBUAT</p>
                        <p class="text-gray-900">{{ $post->created_at->format('d M Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600 font-semibold">DIPERBARUI</p>
                        <p class="text-gray-900">{{ $post->updated_at->format('d M Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Back Button -->
    <div>
        <a href="{{ route('posts.index') }}" class="text-teal-600 hover:text-teal-900 font-semibold">
            ← Kembali ke Posts
        </a>
    </div>
</div>
@endsection
