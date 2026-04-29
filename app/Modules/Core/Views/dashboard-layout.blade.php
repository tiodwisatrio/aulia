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

     <div class="min-h-screen flex" x-data="{ sidebarOpen: window.innerWidth >= 768 }">

        <!-- Mobile backdrop: only visible on mobile when sidebar open -->
        <div id="mobile-backdrop" @click="sidebarOpen = false"
             :class="sidebarOpen ? 'opacity-100 pointer-events-auto' : 'opacity-0 pointer-events-none'"
             class="fixed inset-0 bg-black/40 z-20 transition-opacity duration-300"></div>

        <style>
            /* Mobile: sidebar fixed overlay */
            #app-sidebar {
                position: fixed;
                top: 0; left: 0; height: 100vh;
                width: 256px;
                z-index: 30;
                transition: transform 0.3s ease-in-out;
                transform: translateX(-256px);
            }
            #app-sidebar.sidebar-open {
                transform: translateX(0);
            }
            /* Desktop: hide backdrop completely */
            @media (min-width: 768px) {
                #mobile-backdrop {
                    display: none !important;
                }
            }
            /* Desktop: sidebar sticky in flex flow */
            @media (min-width: 768px) {
                #app-sidebar {
                    position: sticky !important;
                    top: 0 !important;
                    z-index: auto !important;
                    transform: none !important;
                    height: 100vh;
                    width: 256px;
                    min-width: 256px;
                    flex-shrink: 0;
                    overflow: hidden;
                    transition: width 0.3s ease-in-out, min-width 0.3s ease-in-out;
                }
                #app-sidebar.sidebar-closed {
                    width: 0 !important;
                    min-width: 0 !important;
                }
            }
        </style>

        <aside id="app-sidebar"
               :class="sidebarOpen ? 'sidebar-open' : 'sidebar-closed'"
               class="bg-white shadow-md flex flex-col">
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
                    {{-- Dynamic Navigation from Database (parent + children) --}}
                    @php
                        $currentRole = Auth::user()->role ?? 'admin';

                        // Cache module permissions per-request
                        $modulePerms = \App\Modules\UserLevel\Models\ModulePermission::all()
                            ->keyBy('module_name');

                        // Helper: cek apakah route diizinkan untuk role ini
                        $canSeeRoute = function(?string $route) use ($currentRole, $modulePerms) {
                            if (!$route || $route === '#' || $route === 'dashboard') return true;
                            // Strip query params format "route.name|key=value"
                            if (str_contains($route, '|')) {
                                $route = explode('|', $route, 2)[0];
                            }
                            // Developer selalu boleh
                            if ($currentRole === 'developer') return true;
                            // Ambil module_name dari route: "agendas.index" atau "agendas.create" → "agendas.index"
                            $parts      = explode('.', $route);
                            $moduleName = $parts[0] . '.index';
                            $perm       = $modulePerms->get($moduleName);
                            if (!$perm) return true; // belum dikonfigurasi = boleh akses
                            return in_array($currentRole, $perm->allowed_roles ?? []);
                        };

                        $sidebarMenus = \App\Modules\Navigation\Models\Navigation::whereNull('menu_parent_id')
                            ->where('menu_status', 1)
                            ->where(function($q) use ($currentRole) {
                                $q->whereNull('menu_roles')
                                  ->orWhereJsonContains('menu_roles', $currentRole);
                            })
                            ->with(['children' => function($q) use ($currentRole) {
                                $q->where('menu_status', 1)
                                  ->where(function($q2) use ($currentRole) {
                                      $q2->whereNull('menu_roles')
                                         ->orWhereJsonContains('menu_roles', $currentRole);
                                  })
                                  ->orderBy('menu_urutan');
                            }])
                            ->orderBy('menu_urutan')
                            ->get()
                            // Filter children tiap parent dulu
                            ->each(function($nav) use ($canSeeRoute) {
                                $nav->setRelation('children',
                                    $nav->children->filter(fn($c) => $canSeeRoute($c->menu_route))
                                );
                            })
                            // Lalu filter parent:
                            // - jika route biasa → cek permission
                            // - jika group (#) → tampilkan hanya jika masih ada children visible
                            ->filter(function($nav) use ($canSeeRoute) {
                                $route = $nav->menu_route;
                                if (!$route || $route === '#') {
                                    // Group: tampil hanya jika ada child yang lolos
                                    return $nav->children->isNotEmpty();
                                }
                                return $canSeeRoute($route);
                            });
                    @endphp

@foreach($sidebarMenus as $nav)
    @php
        $hasChildren = $nav->children->isNotEmpty();
        $navRoute    = $nav->menu_route;

        // Support format "route.name|key=value&key2=value2" untuk query params tambahan
        $navParams   = [];
        if ($navRoute && str_contains($navRoute, '|')) {
            [$navRoute, $paramStr] = explode('|', $navRoute, 2);
            parse_str($paramStr, $navParams);
        }

        $routeValid  = $navRoute && ($navRoute === 'dashboard' || Route::has($navRoute));
        $isActive    = $navRoute === 'dashboard'
            ? request()->routeIs('dashboard')
            : ($navRoute ? (request()->routeIs(str_replace('.index', '.*', $navRoute))
                && (empty($navParams) || collect($navParams)->every(fn($v,$k) => request($k) == $v)))
              : false);
    @endphp

    @if($hasChildren)
        {{-- Menu dengan children --}}
        @php
            $navType = str_replace('.index', '', $navRoute ?? '');
            $childActive = $nav->children->contains(function($c) use ($navType) {
                if (!$c->menu_route) return false;
                if ($c->menu_route === 'categories.index') {
                    return request()->routeIs('categories.*') && request('type') === $navType;
                }
                return Route::has($c->menu_route) && request()->routeIs(str_replace('.index', '.*', $c->menu_route));
            });
            $isOpen = $isActive || $childActive;
        @endphp
        <div x-data="{ open: {{ $isOpen ? 'true' : 'false' }} }" class="space-y-1">
            <div class="flex items-center rounded transition-colors duration-200
                        {{ $isActive || $childActive ? 'bg-teal-700 text-white' : 'hover:bg-gray-200' }}">
                @if($routeValid)
                    <a href="{{ $navRoute === 'dashboard' ? route('dashboard') : route($navRoute, $navParams) }}"
                       class="flex items-center flex-1 py-2 px-3 min-w-0">
                        @if($nav->menu_ikon)
                            <i data-lucide="{{ $nav->menu_ikon }}" class="w-5 h-5 mr-2 flex-shrink-0"></i>
                        @endif
                        <span class="truncate">{{ $nav->menu_label }}</span>
                    </a>
                @else
                    <span class="flex items-center flex-1 py-2 px-3 min-w-0 cursor-default">
                        @if($nav->menu_ikon)
                            <i data-lucide="{{ $nav->menu_ikon }}" class="w-5 h-5 mr-2 flex-shrink-0"></i>
                        @endif
                        <span class="truncate">{{ $nav->menu_label }}</span>
                    </span>
                @endif
                <button @click="open = !open" type="button" class="py-2 px-2 flex-shrink-0">
                    <svg :class="{'rotate-90': open}" class="h-4 w-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>
            <div x-show="open" class="pl-8 space-y-1">
                @foreach($nav->children as $child)
                @php
                    $childRoute  = $child->menu_route;
                    $childParams = [];
                    if ($childRoute && str_contains($childRoute, '|')) {
                        [$childRoute, $childParamStr] = explode('|', $childRoute, 2);
                        parse_str($childParamStr, $childParams);
                    }
                    $childValid  = $childRoute && ($childRoute === 'dashboard' || Route::has($childRoute));
                    $childActive = $childValid && request()->routeIs(str_replace('.index', '.*', $childRoute))
                        && (empty($childParams) || collect($childParams)->every(fn($v,$k) => request($k) == $v));
                    $childUrl    = $childValid ? route($childRoute, $childParams) : '#';
                @endphp
                <a href="{{ $childUrl }}"
                   class="flex items-center py-2 px-3 rounded transition-colors duration-200
                          {{ $childActive ? 'bg-teal-700 text-white' : 'hover:bg-gray-200' }}">
                    @if($child->menu_ikon)
                        <i data-lucide="{{ $child->menu_ikon }}" class="w-4 h-4 mr-2"></i>
                    @endif
                    {{ $child->menu_label }}
                </a>
                @endforeach
            </div>
        </div>
    @elseif($routeValid)
        {{-- Menu regular dengan route valid --}}
        <a href="{{ $navRoute === 'dashboard' ? route('dashboard') : route($navRoute, $navParams) }}"
           class="flex items-center py-2 px-3 rounded transition-colors duration-200
                  {{ $isActive ? 'bg-teal-700 text-white' : 'hover:bg-gray-200' }}">
            @if($nav->menu_ikon)
                <i data-lucide="{{ $nav->menu_ikon }}" class="w-5 h-5 mr-2"></i>
            @endif
            {{ $nav->menu_label }}
        </a>
    @else
        {{-- Menu label/group tanpa route (route kosong atau '#') --}}
        <span class="flex items-center py-2 px-3 rounded text-gray-500 cursor-default select-none">
            @if($nav->menu_ikon)
                <i data-lucide="{{ $nav->menu_ikon }}" class="w-5 h-5 mr-2"></i>
            @endif
            {{ $nav->menu_label }}
        </span>
    @endif
@endforeach

                    <!-- Module Generator - hardcoded hanya untuk admin -->
                    <div class="border-t my-3"></div>
                    {{-- Module Generator (disabled)
                    @can('admin-access')
                    <a href="{{ route('module-generator.index') }}"
                       class="flex items-center py-2 px-3 rounded transition-colors duration-200 {{ request()->routeIs('module-generator.*') ? 'bg-teal-700 text-white' : 'hover:bg-gray-200' }}">
                        <i data-lucide="cpu" class="w-5 h-5 mr-2"></i> Module Generator
                    </a>
                    @endcan
                    --}}
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
                        <div class="flex-1 min-w-0">
                            <a href="{{ route('profile.edit') }}" class="block hover:opacity-70 transition-opacity">
                                <div class="font-medium text-gray-900 truncate">{{ Auth::user()->name }}</div>
                                <div class="text-xs text-gray-500 capitalize">{{ Auth::user()->role ?? 'User' }}</div>
                            </a>
                        </div>
                    </div>
                </div>
                @endauth
                
               
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col h-screen min-w-0">
            <!-- Header Bar -->
            <header class="bg-white border-b border-gray-200 px-4 py-3 flex items-center gap-3 flex-shrink-0">
                <button @click="sidebarOpen = !sidebarOpen"
                        class="p-1.5 rounded-lg hover:bg-gray-100 transition text-gray-500 hover:text-gray-700">
                    <i data-lucide="menu" class="w-5 h-5"></i>
                </button>
                <span class="text-sm text-gray-500">@yield('header', 'Dashboard')</span>
            </header>

            <!-- Page Content -->
            <main class="flex-1 p-4 sm:p-6 overflow-y-auto">
                <!-- Flash Messages -->
                @if($message = Session::get('success'))
                    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-start gap-3">
                        <i data-lucide="check-circle" class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5"></i>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-green-800">{{ $message }}</p>
                        </div>
                        <button onclick="this.parentElement.style.display='none'" class="text-green-600 hover:text-green-700">
                            <i data-lucide="x" class="w-4 h-4"></i>
                        </button>
                    </div>
                @endif

                @if($message = Session::get('error'))
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg flex items-start gap-3">
                        <i data-lucide="alert-circle" class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5"></i>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-red-800">{{ $message }}</p>
                        </div>
                        <button onclick="this.parentElement.style.display='none'" class="text-red-600 hover:text-red-700">
                            <i data-lucide="x" class="w-4 h-4"></i>
                        </button>
                    </div>
                @endif

                @if($message = Session::get('warning'))
                    <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg flex items-start gap-3">
                        <i data-lucide="alert-triangle" class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5"></i>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-yellow-800">{{ $message }}</p>
                        </div>
                        <button onclick="this.parentElement.style.display='none'" class="text-yellow-600 hover:text-yellow-700">
                            <i data-lucide="x" class="w-4 h-4"></i>
                        </button>
                    </div>
                @endif

                @if($message = Session::get('info'))
                    <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg flex items-start gap-3">
                        <i data-lucide="info" class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5"></i>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-blue-800">{{ $message }}</p>
                        </div>
                        <button onclick="this.parentElement.style.display='none'" class="text-blue-600 hover:text-blue-700">
                            <i data-lucide="x" class="w-4 h-4"></i>
                        </button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')

    <script>
        lucide.createIcons();

        // Auto-close sidebar on mobile when a nav link is clicked
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('app-sidebar');
            if (!sidebar) return;
            sidebar.querySelectorAll('a[href]').forEach(function (link) {
                link.addEventListener('click', function () {
                    if (window.innerWidth < 768) {
                        // trigger Alpine sidebarOpen = false via click on backdrop
                        const backdrop = document.getElementById('mobile-backdrop');
                        if (backdrop) backdrop.click();
                    }
                });
            });
        });

        function showLogoutModal() {
            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 z-50 flex items-center justify-center p-4';
            modal.innerHTML = `
                <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>
                <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-sm mx-auto p-6 flex flex-col items-center gap-4">
                    <div class="w-14 h-14 rounded-full bg-red-50 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-red-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/>
                        </svg>
                    </div>
                    <div class="text-center">
                        <h3 class="text-base font-bold text-gray-900">Keluar dari sistem?</h3>
                        <p class="text-sm text-gray-500 mt-1">Sesi Anda akan diakhiri. Pastikan semua perubahan sudah tersimpan.</p>
                    </div>
                    <div class="flex gap-3 w-full mt-1">
                        <button id="logout-cancel" class="flex-1 px-4 py-2.5 rounded-xl border border-gray-200 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">
                            Batal
                        </button>
                        <button id="logout-confirm" class="flex-1 px-4 py-2.5 rounded-xl bg-red-500 hover:bg-red-600 text-white text-sm font-semibold transition">
                            Ya, Logout
                        </button>
                    </div>
                </div>
            `;

            document.body.appendChild(modal);

            document.getElementById('logout-confirm').onclick = function () {
                document.getElementById('logoutForm').submit();
            };

            document.getElementById('logout-cancel').onclick = function () {
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
