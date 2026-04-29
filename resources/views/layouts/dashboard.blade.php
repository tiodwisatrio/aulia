<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('header', 'Dashboard') - {{ setting('site_name', config('app.name')) }}</title>

    <!-- Favicon -->
    @if(setting('site_logo'))
        <link rel="icon" type="image/png" href="{{ asset('storage/' . setting('site_logo')) }}">
        <link rel="shortcut icon" type="image/png" href="{{ asset('storage/' . setting('site_logo')) }}">
        <link rel="apple-touch-icon" href="{{ asset('storage/' . setting('site_logo')) }}">
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <style>
        /* Custom scrollbar untuk sidebar */
        .sidebar-scroll::-webkit-scrollbar {
            width: 6px;
        }
        
        .sidebar-scroll::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }
        
        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }
        
        .sidebar-scroll::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
        
        /* Smooth scrolling */
        .sidebar-scroll {
            scrollbar-width: thin;
            scrollbar-color: #c1c1c1 #f1f1f1;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans antialiased">

    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-md flex flex-col h-screen">
            <!-- Sidebar Header - Fixed di atas -->
            <div class="p-4 border-b flex-shrink-0">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-x-3 hover:opacity-80 transition">
                    @if(setting('site_logo'))
                        <img src="{{ asset('storage/' . setting('site_logo')) }}" alt="{{ setting('site_name', 'Logo') }}" class="h-10 w-auto object-contain">
                    @endif
                    <span class="font-bold text-lg text-gray-800">{{ setting('site_name', config('app.name')) }}</span>
                </a>
            </div>
            
            <!-- Navigation Area - Scrollable -->
            <div class="flex-1 overflow-y-auto sidebar-scroll">
                <nav class="p-4 space-y-2">
                    {{-- Dynamic Navigation from Database --}}
                    @php
                        $navigations = \App\Modules\Navigation\Models\Navigation::where('status', 1)->orderBy('order')->get();
                        $subMenuRoutes = ['posts.index', 'products.index', 'teams.index'];
                    @endphp
                    
                    @php
    // Menu yang punya submenu Categories, mapping route ke tipe singular
    $subMenuRoutes = [
        'posts.index'    => 'post',
        'products.index' => 'product',
        'teams.index'    => 'team',
    ];
@endphp

@foreach($navigations as $nav)
    @if($nav->route)
        {{-- Menu dengan submenu (Posts, Products, Teams) --}}
        @if(array_key_exists($nav->route, $subMenuRoutes))
            @php
                $type = $subMenuRoutes[$nav->route];
                $isOpen = request('type', '') === $type || request()->routeIs(str_replace('.index', '.*', $nav->route));
            @endphp
            <div x-data="{ open: {{ $isOpen ? 'true' : 'false' }} }" class="space-y-1">
                <button @click="open = !open" type="button" 
                        class="flex items-center w-full py-2 px-3 rounded transition-colors duration-200
                               {{ (request()->routeIs(str_replace('.index', '.*', $nav->route)) || (request()->routeIs('categories.*') && request('type') === $type)) ? 'bg-teal-700 text-white' : 'hover:bg-gray-200' }}">
                    @if($nav->icon)
                        <i data-lucide="{{ $nav->icon }}" class="w-5 h-5 mr-2"></i>
                    @endif
                    {{ $nav->label }}
                    <svg :class="{'rotate-90': open}" class="ml-auto h-4 w-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
                
                {{-- Submenu --}}
                <div x-show="open" class="pl-8 space-y-1">
                    {{-- All Items --}}
                    <a href="{{ route($nav->route) }}" 
                       class="flex items-center py-2 px-3 rounded transition-colors duration-200
                              {{ request()->routeIs(str_replace('.index', '.*', $nav->route)) && !request()->has('type') ? 'bg-teal-700 text-white' : 'hover:bg-gray-200' }}">
                        <i data-lucide="list" class="w-4 h-4 mr-2"></i> All {{ $nav->label }}
                    </a>

                    {{-- Categories --}}
                    <a href="{{ route('categories.index', ['type' => $type]) }}" 
                       class="flex items-center py-2 px-3 rounded transition-colors duration-200
                              {{ (request()->routeIs('categories.*') && request('type') === $type) ? 'bg-teal-700 text-white' : 'hover:bg-gray-200' }}">
                        <i data-lucide="folder" class="w-4 h-4 mr-2"></i> Categories
                    </a>
                </div>
            </div>
        @else
            {{-- Menu regular tanpa submenu --}}
            <a href="{{ route($nav->route) }}" 
               class="flex items-center py-2 px-3 rounded transition-colors duration-200
                      {{ request()->routeIs(str_replace('.index', '.*', $nav->route)) ? 'bg-teal-700 text-white' : 'hover:bg-gray-200' }}">
                @if($nav->icon)
                    <i data-lucide="{{ $nav->icon }}" class="w-5 h-5 mr-2"></i>
                @endif
                {{ $nav->label }}
            </a>
        @endif
    @endif
@endforeach



                    <!-- Divider -->
                    <div class="border-t my-3"></div>

                    <!-- Users menu - Super Admin dan Developer -->
                    @can('manage-users')
                    <a href="{{ route('users.index') }}"
                       class="flex items-center py-2 px-3 rounded transition-colors duration-200 {{ request()->routeIs('users.*') ? 'bg-teal-700 text-white' : 'hover:bg-gray-200' }}">
                        <i data-lucide="users" class="w-5 h-5 mr-2"></i> Users
                    </a>
                    @endcan

                    <!-- Navigation & Settings - Super Admin dan Developer -->
                    @can('super-admin-access')
                    <a href="{{ route('navigations.index') }}"
                       class="flex items-center py-2 px-3 rounded transition-colors duration-200 {{ request()->routeIs('navigations.*') ? 'bg-teal-700 text-white' : 'hover:bg-gray-200' }}">
                        <i data-lucide="menu" class="w-5 h-5 mr-2"></i> Navigation
                    </a>
                    <a href="{{ route('settings.index') }}"
                       class="flex items-center py-2 px-3 rounded transition-colors duration-200 {{ request()->routeIs('settings.*') ? 'bg-teal-700 text-white' : 'hover:bg-gray-200' }}">
                        <i data-lucide="settings" class="w-5 h-5 mr-2"></i> Settings
                    </a>
                    @endcan
                </nav>
            </div>
            
            <!-- Bottom Section - Fixed di bawah -->
            <div class="flex-shrink-0 border-t bg-white">

            <!-- Logout Button - Always visible at bottom -->
                <div class="p-4 pt-0">
                    <form action="{{ route('logout') }}" method="POST" class="inline w-full" id="logoutForm">
                        @csrf
                        <button type="button" onclick="showLogoutModal()" 
                                class="flex items-center py-2 px-3 rounded hover:bg-red-50 hover:text-red-600 w-full text-left transition-colors duration-200">
                            <i data-lucide="log-out" class="w-5 h-5 mr-2"></i> 
                            <span>Logout</span>
                        </button>
                    </form>
                </div>

                <!-- User Info Section -->
                @auth
                <div class="p-4 pb-2">
                    <div class="flex items-center py-2 px-3 text-sm text-gray-600">
                        <div class="w-8 h-8 bg-teal-700 rounded-full flex items-center justify-center mr-3">
                            <span class="text-white font-medium text-xs">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </span>
                        </div>
                        <div class="flex-1">
                            <a href="{{ route('profile.edit') }}" class="block {{ request()->routeIs('profile.*') ? 'bg-teal-700 text-white rounded px-2 py-1' : '' }}">
                                <div class="font-medium text-gray-900 truncate {{ request()->routeIs('profile.*') ? 'text-white' : '' }}">{{ Auth::user()->name }}</div>
                                <div class="text-xs text-gray-500 capitalize {{ request()->routeIs('profile.*') ? 'text-gray-200' : '' }}">{{ Auth::user()->role ?? 'User' }}</div>
                            </a>
                        </div>
                    </div>
                </div>
                @endauth
                
               
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col h-screen">
            <!-- Header -->
      

            <!-- Page Content -->
            <main class="flex-1 p-6 overflow-y-auto">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')

    <script>
        lucide.createIcons();

        // Function untuk konfirmasi logout
        function confirmLogout() {
            // Menggunakan confirm dialog sederhana
            if (confirm('Apakah Anda yakin ingin logout?')) {
                document.getElementById('logoutForm').submit();
            }
        }

        // Alternative: menggunakan modal yang lebih cantik (opsional)
        function showLogoutModal() {
            // Create modal
            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50';
            modal.innerHTML = `
                <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                    <div class="mt-3 text-center">
                        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                            <i data-lucide="log-out" class="w-6 h-6 text-red-600"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mt-4">Konfirmasi Logout</h3>
                        <div class="mt-2 px-7 py-3">
                            <p class="text-sm text-gray-500">
                                Apakah Anda yakin ingin keluar dari sistem?
                            </p>
                        </div>
                        <div class="items-center px-4 py-3">
                            <button id="logout-confirm" class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md w-24 mr-2 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300">
                                Logout
                            </button>
                            <button id="logout-cancel" class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-24 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                                Batal
                            </button>
                        </div>
                    </div>
                </div>
            `;
            
            document.body.appendChild(modal);
            lucide.createIcons();
            
            // Event listeners untuk modal buttons
            document.getElementById('logout-confirm').onclick = function() {
                document.getElementById('logoutForm').submit();
            };
            
            document.getElementById('logout-cancel').onclick = function() {
                document.body.removeChild(modal);
            };
            
            // Close modal ketika click outside
            modal.onclick = function(e) {
                if (e.target === modal) {
                    document.body.removeChild(modal);
                }
            };
        }
    </script>
</body>
</html>
