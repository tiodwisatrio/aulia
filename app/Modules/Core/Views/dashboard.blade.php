@extends('core::dashboard-layout')

@section('content')
<div class="space-y-6">
    <!-- Welcome Section -->
    <div class="bg-gradient-to-r from-teal-500 to-blue-600 rounded-2xl shadow-lg p-8 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2 text-white">Selamat Datang, {{ auth()->user()->name }}! 👋</h1>
                <p class="text-teal-50 text-lg">Akses cepat fitur yang kamu butuhkan.</p>
            </div>
            <div class="hidden md:block">
                <i data-lucide="sparkles" class="w-20 h-20 text-white opacity-20"></i>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Users Card -->
        <a href="{{ route('users.index') }}" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow block">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center">
                    <i data-lucide="users" class="w-6 h-6 text-white"></i>
                </div>
                <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2 py-1 rounded-full">Total</span>
            </div>
            <h3 class="text-gray-600 text-sm font-medium mb-1">Users</h3>
            <p class="text-3xl font-bold text-gray-900">{{ \App\Modules\User\Models\User::count() }}</p>
        </a>

        <!-- Posts Card -->
        <!-- <a href="{{ route('posts.index') }}" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow block">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                    <i data-lucide="file-text" class="w-6 h-6 text-white"></i>
                </div>
                <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2 py-1 rounded-full">Total</span>
            </div>
            <h3 class="text-gray-600 text-sm font-medium mb-1">Posts</h3>
            <p class="text-3xl font-bold text-gray-900">{{ \App\Modules\Post\Models\Post::count() }}</p>
        </a> -->

        <!-- Hero Card -->
        <a href="{{ route('heroes.index') }}" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow block">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                    <i data-lucide="file-text" class="w-6 h-6 text-white"></i>
                </div>
                <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2 py-1 rounded-full">Total</span>
            </div>
            <h3 class="text-gray-600 text-sm font-medium mb-1">Heroes</h3>
            <p class="text-3xl font-bold text-gray-900">{{ \App\Modules\Hero\Models\Hero::count() }}</p>
        </a>

        <!-- Products Card -->
        <a href="{{ route('products.index') }}" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow block">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center">
                    <i data-lucide="package" class="w-6 h-6 text-white"></i>
                </div>
                <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2 py-1 rounded-full">Total</span>
            </div>
            <h3 class="text-gray-600 text-sm font-medium mb-1">Products</h3>
            <p class="text-3xl font-bold text-gray-900">{{ \App\Modules\Product\Models\Product::count() }}</p>
        </a>

        <!-- About Card -->
        <a href="{{ route('abouts.index') }}" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow block">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-pink-500 to-pink-600 rounded-lg flex items-center justify-center">
                    <i data-lucide="info" class="w-6 h-6 text-white"></i>
                </div>
                <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2 py-1 rounded-full">Total</span>
            </div>
            <h3 class="text-gray-600 text-sm font-medium mb-1">Tentang Kami</h3>
            <p class="text-3xl font-bold text-gray-900">{{ \App\Modules\About\Models\About::count() }}</p>
        </a>

        <!-- Services Card -->
        <a href="{{ route('services.index') }}" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow block">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-teal-500 to-teal-600 rounded-lg flex items-center justify-center">
                    <i data-lucide="heart" class="w-6 h-6 text-white"></i>
                </div>
                <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2 py-1 rounded-full">Total</span>
            </div>
            <h3 class="text-gray-600 text-sm font-medium mb-1">Layanan</h3>
            <p class="text-3xl font-bold text-gray-900">{{ \App\Modules\Service\Models\Service::count() }}</p>
        </a>

        <!-- Our Clients Card -->
        <a href="{{ route('ourclient.index') }}" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow block">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-lg flex items-center justify-center">
                    <i data-lucide="briefcase" class="w-6 h-6 text-white"></i>
                </div>
                <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2 py-1 rounded-full">Total</span>
            </div>
            <h3 class="text-gray-600 text-sm font-medium mb-1">Mitra Kami</h3>
            <p class="text-3xl font-bold text-gray-900">{{ \App\Modules\OurClient\Models\OurClient::count() }}</p>
        </a>

        <!-- Contact Messages Card -->
        <a href="{{ route('contacts.index') }}" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow block">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-lg flex items-center justify-center">
                    <i data-lucide="mail" class="w-6 h-6 text-white"></i>
                </div>
                @php
                    $newMessages = \App\Modules\Contact\Models\ContactMessage::where('hubungi_kami_status', 'baru')->count();
                @endphp
                @if($newMessages > 0)
                    <span class="text-xs font-bold text-white bg-red-500 px-2 py-1 rounded-full">{{ $newMessages }} New</span>
                @else
                    <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2 py-1 rounded-full">Total</span>
                @endif
            </div>
            <h3 class="text-gray-600 text-sm font-medium mb-1">Contact</h3>
            <p class="text-3xl font-bold text-gray-900">{{ \App\Modules\Contact\Models\ContactMessage::count() }}</p>
        </a>

        <!-- Testimonials Card -->
        <a href="{{ route('ourvalues.index') }}" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow block">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg flex items-center justify-center">
                    <i data-lucide="message-square" class="w-6 h-6 text-white"></i>
                </div>
                <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2 py-1 rounded-full">Total</span>
            </div>
            <h3 class="text-gray-600 text-sm font-medium mb-1">Keunggulan</h3>
            <p class="text-3xl font-bold text-gray-900">{{ \App\Modules\OurValue\Models\OurValue::count() }}</p>
        </a>
    </div>


    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <i data-lucide="zap" class="w-5 h-5 mr-2 text-teal-600"></i>
            Quick Actions
        </h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <!-- <a href="{{ route('posts.create') }}" 
               class="flex flex-col items-center justify-center p-4 rounded-lg border-2 border-dashed border-gray-200 hover:border-teal-500 hover:bg-teal-50 transition-all group">
                <i data-lucide="plus-circle" class="w-8 h-8 text-gray-400 group-hover:text-teal-600 mb-2"></i>
                <span class="text-sm font-medium text-gray-600 group-hover:text-teal-600">New Post</span>
            </a> -->
            <a href="{{ route('products.create') }}" 
               class="flex flex-col items-center justify-center p-4 rounded-lg border-2 border-dashed border-gray-200 hover:border-green-500 hover:bg-green-50 transition-all group">
                <i data-lucide="package-plus" class="w-8 h-8 text-gray-400 group-hover:text-green-600 mb-2"></i>
                <span class="text-sm font-medium text-gray-600 group-hover:text-green-600">New Products</span>
            </a>
              <a href="{{ route('services.create') }}" 
               class="flex flex-col items-center justify-center p-4 rounded-lg border-2 border-dashed border-gray-200 hover:border-teal-500 hover:bg-teal-50 transition-all group">
                <i data-lucide="plus-circle" class="w-8 h-8 text-gray-400 group-hover:text-teal-600 mb-2"></i>
                <span class="text-sm font-medium text-gray-600 group-hover:text-teal-600">New Services</span>
            </a>
            <a href="{{ route('contacts.index') }}" 
               class="flex flex-col items-center justify-center p-4 rounded-lg border-2 border-dashed border-gray-200 hover:border-blue-500 hover:bg-blue-50 transition-all group">
                <i data-lucide="inbox" class="w-8 h-8 text-gray-400 group-hover:text-blue-600 mb-2"></i>
                <span class="text-sm font-medium text-gray-600 group-hover:text-blue-600">View Messages</span>
            </a>
            <a href="{{ route('settings.index') }}" 
               class="flex flex-col items-center justify-center p-4 rounded-lg border-2 border-dashed border-gray-200 hover:border-purple-500 hover:bg-purple-50 transition-all group">
                <i data-lucide="settings-2" class="w-8 h-8 text-gray-400 group-hover:text-purple-600 mb-2"></i>
                <span class="text-sm font-medium text-gray-600 group-hover:text-purple-600">Settings</span>
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Initialize Lucide icons
    lucide.createIcons();
</script>
@endpush

