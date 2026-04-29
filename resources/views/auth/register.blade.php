<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - {{ setting('site_name', config('app.name')) }}</title>

    <!-- Favicon -->
    @if(setting('site_logo'))
        <link rel="icon" type="image/png" href="{{ asset('storage/' . setting('site_logo')) }}">
        <link rel="shortcut icon" type="image/png" href="{{ asset('storage/' . setting('site_logo')) }}">
        <link rel="apple-touch-icon" href="{{ asset('storage/' . setting('site_logo')) }}">
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-gradient-to-br from-teal-50 to-cyan-50 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!-- Logo & Title -->
        <div class="text-center mb-8">
            <a href="{{ route('frontend.home') }}" class="inline-flex items-center justify-center gap-3 mb-4 hover:opacity-80 transition-opacity">
                @if(setting('site_logo'))
                    <img src="{{ asset('storage/' . setting('site_logo')) }}" alt="Logo" class="h-16 w-auto object-contain">
                @endif
                <h1 class="text-3xl font-bold text-gray-800">{{ setting('site_name', config('app.name')) }}</h1>
            </a>
            <p class="text-gray-600 mt-2">Create your account</p>
        </div>

        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-4 p-3 rounded-lg bg-green-50 border border-green-200 text-green-700 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i data-lucide="user" class="h-5 w-5 text-gray-400"></i>
                        </div>
                        <input
                            id="name"
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            required
                            autofocus
                            autocomplete="name"
                            class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all @error('name') border-red-500 @enderror"
                            placeholder="Enter your full name"
                        >
                    </div>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i data-lucide="mail" class="h-5 w-5 text-gray-400"></i>
                        </div>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autocomplete="username"
                            class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all @error('email') border-red-500 @enderror"
                            placeholder="Enter your email"
                        >
                    </div>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i data-lucide="lock" class="h-5 w-5 text-gray-400"></i>
                        </div>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            autocomplete="new-password"
                            class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all @error('password') border-red-500 @enderror"
                            placeholder="Create a password"
                        >
                    </div>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i data-lucide="lock" class="h-5 w-5 text-gray-400"></i>
                        </div>
                        <input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            required
                            autocomplete="new-password"
                            class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all"
                            placeholder="Confirm your password"
                        >
                    </div>
                </div>

                <!-- Submit Button -->
                <button
                    type="submit"
                    class="w-full bg-gradient-to-r from-teal-600 to-cyan-600 text-white font-semibold py-3 px-4 rounded-lg hover:from-teal-700 hover:to-cyan-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition-all transform hover:scale-[1.02] active:scale-[0.98]"
                >
                    Create Account
                </button>

                <!-- Already have account -->
                <div class="text-center pt-4 border-t border-gray-200">
                    <p class="text-sm text-gray-600">
                        Already have an account?
                        <a href="{{ route('login') }}" class="font-medium text-teal-600 hover:text-teal-700 transition-colors">
                            Sign in here
                        </a>
                    </p>
                </div>
            </form>
        </div>

        <!-- Back to Home -->
        <div class="text-center mt-6">
            <a href="{{ route('frontend.home') }}" class="inline-flex items-center gap-2 text-sm text-gray-600 hover:text-teal-600 transition-colors">
                <i data-lucide="arrow-left" class="h-4 w-4"></i>
                Back to Home
            </a>
        </div>
    </div>

    <!-- Initialize Lucide Icons -->
    <script>
        lucide.createIcons();
    </script>
</body>
</html>
