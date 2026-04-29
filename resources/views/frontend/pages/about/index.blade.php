@extends('frontend.layouts.app')

@section('title', 'About ' )

@section('content')
<!-- Hero Section with Animated Gradient -->
<div class="relative overflow-hidden bg-gradient-to-br from-green-600 via-teal-600 to-blue-600 text-white py-24 md:py-32 animate-gradient">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-1/2 -left-1/2 w-full h-full bg-white/10 rounded-full blur-3xl animate-pulse animate-rotate-slow"></div>
        <div class="absolute -bottom-1/2 -right-1/2 w-full h-full bg-white/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="text-center max-w-4xl mx-auto">
            <div class="inline-block mb-6 px-4 py-2 bg-white/20 backdrop-blur-lg rounded-full text-sm font-medium animate-fadeInUp">
                Welcome to Our Story
            </div>
            <h1 class="text-5xl md:text-7xl font-extrabold mb-6 leading-tight animate-fadeInUp delay-100">
                About Titit <span class="bg-clip-text text-transparent bg-gradient-to-r from-yellow-200 to-cyan-200">Us</span>
            </h1>
            <p class="text-xl md:text-2xl opacity-95 leading-relaxed animate-fadeInUp delay-200">Discover our journey, mission, and the values that drive us forward</p>
        </div>
    </div>

    <!-- Wave Divider -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full">
            <path d="M0,64L80,69.3C160,75,320,85,480,80C640,75,800,53,960,48C1120,43,1280,53,1360,58.7L1440,64L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z" fill="#F9FAFB"/>
        </svg>
    </div>
</div>

<!-- About Section with Modern Cards -->
<div class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        @if($abouts->count() > 0)
            @foreach($abouts as $index => $about)
                <div class="mb-20 last:mb-0">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center {{ $loop->even ? 'lg:flex-row-reverse' : '' }}">
                        <!-- Content -->
                        <div class="order-2 {{ $loop->even ? 'lg:order-1' : 'lg:order-2' }} animate-fadeInLeft delay-200">
                            <div class="inline-block mb-4 px-4 py-1 bg-gradient-to-r from-green-500 to-blue-500 text-white rounded-full text-sm font-medium animate-float">
                                {{ $loop->iteration < 10 ? '0' . $loop->iteration : $loop->iteration }}
                            </div>
                            <h3 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6 leading-tight">
                                {{ $about->title }}
                            </h3>
                            <p class="text-lg text-gray-600 leading-relaxed mb-6">{{ $about->content }}</p>
                            <div class="flex items-center space-x-4">
                                <div class="h-1 w-16 bg-gradient-to-r from-green-500 to-blue-500 rounded-full"></div>
                                <span class="text-sm text-gray-500 font-medium">Our Commitment</span>
                            </div>
                        </div>

                        <!-- Image -->
                        <div class="order-1 {{ $loop->even ? 'lg:order-2' : 'lg:order-1' }} animate-fadeInRight delay-300">
                            @if($about->image)
                                <div class="relative group animate-float" style="animation-delay: 0.5s;">
                                    <div class="absolute inset-0 bg-gradient-to-br from-green-500 to-blue-500 rounded-3xl transform rotate-3 group-hover:rotate-6 transition-transform duration-500"></div>
                                    <div class="relative overflow-hidden rounded-3xl shadow-2xl">
                                        <img src="{{ asset('storage/' . $about->image) }}"
                                            alt="{{ $about->title }}"
                                            class="w-full h-96 object-cover transform group-hover:scale-110 transition-transform duration-700">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="py-20 text-center">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-gradient-to-br from-green-100 to-blue-100 rounded-full mb-6">
                    <i data-lucide="info" class="w-12 h-12 text-green-600"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-3">No About Information Found</h3>
                <p class="text-gray-500 text-lg">The About section is currently unavailable. Please check back later.</p>
            </div>
        @endif
    </div>
</div>

<!-- Our Values Section with Glass Cards -->
<div class="py-20 bg-gradient-to-br from-green-50 via-teal-50 to-blue-50">
    <div class="container mx-auto px-4">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <div class="inline-block mb-4 px-4 py-2 bg-white/60 backdrop-blur-lg rounded-full text-sm font-medium text-green-600 animate-fadeInUp">
                What We Believe In
            </div>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6 animate-fadeInUp delay-100">Our Core Values</h2>
            <p class="text-lg text-gray-600 animate-fadeInUp delay-200">The principles that guide everything we do and every decision we make</p>
        </div>

        @if($ourvalues->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($ourvalues as $value)
                    <div class="group relative animate-scaleIn" style="animation-delay: {{ $loop->index * 0.1 }}s;">
                        <!-- Gradient Background -->
                        <div class="absolute inset-0 bg-gradient-to-br from-green-400 to-blue-400 rounded-2xl opacity-0 group-hover:opacity-100 blur-xl transition-opacity duration-500"></div>

                        <!-- Glass Card -->
                        <div class="relative bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-white/20 p-8 hover:shadow-2xl hover:-translate-y-2 transition-all duration-500">
                            @if($value->image)
                                <div class="relative mb-6">
                                    <div class="absolute inset-0 bg-gradient-to-br from-green-400 to-blue-400 rounded-full blur-lg opacity-50"></div>
                                    <img src="{{ asset('storage/' . $value->image) }}"
                                        alt="{{ $value->name }}"
                                        class="relative w-20 h-20 mx-auto object-cover rounded-full ring-4 ring-white shadow-lg">
                                </div>
                            @else
                                <div class="mb-6 inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-green-500 to-blue-500 rounded-full shadow-lg mx-auto">
                                    <i data-lucide="star" class="w-10 h-10 text-white"></i>
                                </div>
                            @endif

                            <h3 class="text-2xl font-bold text-gray-900 mb-3 text-center">{{ $value->name }}</h3>
                            <p class="text-gray-600 leading-relaxed text-center">{{ $value->description }}</p>

                            <!-- Decorative Element -->
                            <div class="mt-6 flex justify-center">
                                <div class="h-1 w-12 bg-gradient-to-r from-green-500 to-blue-500 rounded-full"></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="py-20 text-center">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-white/80 backdrop-blur-lg rounded-full mb-6 shadow-lg">
                    <i data-lucide="info" class="w-12 h-12 text-green-600"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-3">No Values Found</h3>
                <p class="text-gray-500 text-lg">Our company values are currently unavailable. Please check back later.</p>
            </div>
        @endif
    </div>
</div>

<!-- CTA Section with Gradient -->
<div class="relative py-24 bg-gradient-to-br from-gray-900 via-green-900 to-blue-900 overflow-hidden">
    <!-- Animated Background -->
    <div class="absolute inset-0">
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-green-500/30 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-blue-500/30 rounded-full blur-3xl animate-pulse" style="animation-delay: 1.5s;"></div>
    </div>

    <div class="container mx-auto px-4 text-center relative z-10">
        <h2 class="text-4xl md:text-5xl font-bold mb-6 text-white leading-tight animate-fadeInUp">
            Ready to Get Started?
        </h2>
        <p class="text-xl text-gray-300 mb-10 max-w-2xl mx-auto animate-fadeInUp delay-100">
            Join us and explore amazing content and products that will transform your experience
        </p>
        <a href="{{ route('frontend.products.index') }}"
           class="inline-flex items-center px-10 py-4 bg-gradient-to-r from-green-500 to-blue-500 text-white text-lg font-semibold rounded-full hover:shadow-2xl hover:shadow-green-500/50 hover:-translate-y-1 transition-all duration-300 animate-scaleIn delay-200">
            <span>View Products</span>
            <svg class="w-6 h-6 ml-2 transition-transform group-hover:translate-x-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
            </svg>
        </a>
    </div>
</div>

<style>
/* Pulse Animation */
@keyframes pulse {
    0%, 100% {
        transform: scale(1);
        opacity: 0.5;
    }
    50% {
        transform: scale(1.05);
        opacity: 0.8;
    }
}

/* Floating Animation */
@keyframes float {
    0%, 100% {
        transform: translateY(0px);
    }
    50% {
        transform: translateY(-20px);
    }
}

/* Gradient Animation */
@keyframes gradient {
    0% {
        background-position: 0% 50%;
    }
    50% {
        background-position: 100% 50%;
    }
    100% {
        background-position: 0% 50%;
    }
}

/* Fade In Up Animation */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Fade In Left Animation */
@keyframes fadeInLeft {
    from {
        opacity: 0;
        transform: translateX(-30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

/* Fade In Right Animation */
@keyframes fadeInRight {
    from {
        opacity: 0;
        transform: translateX(30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

/* Scale In Animation */
@keyframes scaleIn {
    from {
        opacity: 0;
        transform: scale(0.8);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

/* Rotate Animation */
@keyframes rotate {
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(360deg);
    }
}

.animate-pulse {
    animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

.animate-float {
    animation: float 3s ease-in-out infinite;
}

.animate-gradient {
    background-size: 200% 200%;
    animation: gradient 8s ease infinite;
}

.animate-fadeInUp {
    animation: fadeInUp 0.8s ease-out forwards;
}

.animate-fadeInLeft {
    animation: fadeInLeft 0.8s ease-out forwards;
}

.animate-fadeInRight {
    animation: fadeInRight 0.8s ease-out forwards;
}

.animate-scaleIn {
    animation: scaleIn 0.6s ease-out forwards;
}

.animate-rotate-slow {
    animation: rotate 20s linear infinite;
}

/* Delay Classes */
.delay-100 {
    animation-delay: 0.1s;
}

.delay-200 {
    animation-delay: 0.2s;
}

.delay-300 {
    animation-delay: 0.3s;
}

.delay-400 {
    animation-delay: 0.4s;
}

.delay-500 {
    animation-delay: 0.5s;
}

/* Initial State */
.animate-fadeInUp,
.animate-fadeInLeft,
.animate-fadeInRight,
.animate-scaleIn {
    opacity: 0;
}
</style>
@endsection
