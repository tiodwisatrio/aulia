@extends('frontend.layouts.app')

@section('title', $product->name)

@section('content')
<!-- Product Header -->
<div class="bg-gray-50 py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <!-- Breadcrumb -->
            <nav class="mb-6">
                <ol class="flex items-center space-x-2 text-sm text-gray-500">
                    <li><a href="{{ route('frontend.home') }}" class="hover:text-green-600">Home</a></li>
                    <li><i data-lucide="chevron-right" class="w-4 h-4"></i></li>
                    <li><a href="{{ route('frontend.products.index') }}" class="hover:text-green-600">Products</a></li>
                    <li><i data-lucide="chevron-right" class="w-4 h-4"></i></li>
                    <li class="text-gray-700">{{ Str::limit($product->name, 50) }}</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<!-- Product Details -->
<div class="py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16">
                <!-- Product Images -->
                <div class="space-y-4">
                    <!-- Main Image -->
                    <div class="aspect-square bg-gray-200 rounded-lg overflow-hidden">
                        @if($product->featured_image)
                            <img 
                                id="main-image"
                                src="{{ asset('storage/' . $product->featured_image) }}" 
                                alt="{{ $product->name }}"
                                class="w-full h-full object-cover cursor-zoom-in"
                            >
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-green-400 to-blue-500 flex items-center justify-center">
                                <i data-lucide="package" class="w-32 h-32 text-white opacity-50"></i>
                            </div>
                        @endif
                    </div>

                    <!-- Gallery Images (if available) -->
                    @if($product->gallery_images && count($product->gallery_images) > 0)
                        <div class="flex space-x-2 overflow-x-auto">
                            <!-- Main image thumbnail -->
                            @if($product->featured_image)
                                <button 
                                    class="gallery-thumb flex-shrink-0 w-20 h-20 rounded-lg overflow-hidden border-2 border-green-500"
                                    data-image="{{ asset('storage/' . $product->featured_image) }}"
                                >
                                    <img 
                                        src="{{ asset('storage/' . $product->featured_image) }}" 
                                        alt="{{ $product->name }}"
                                        class="w-full h-full object-cover"
                                    >
                                </button>
                            @endif
                            
                            <!-- Gallery thumbnails -->
                            @foreach($product->gallery_images as $image)
                                <button 
                                    class="gallery-thumb flex-shrink-0 w-20 h-20 rounded-lg overflow-hidden border-2 border-transparent hover:border-green-500 transition-colors"
                                    data-image="{{ asset('storage/' . $image) }}"
                                >
                                    <img 
                                        src="{{ asset('storage/' . $image) }}" 
                                        alt="{{ $product->name }}"
                                        class="w-full h-full object-cover"
                                    >
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>
                
                <!-- Product Info -->
                <div class="space-y-6">
                    <!-- Category -->
                    @if($product->category)
                        <div class="mb-4">
                            <span class="inline-block px-3 py-1 bg-green-600 text-white text-sm rounded-full">
                                {{ $product->category->name }}
                            </span>
                        </div>
                    @endif
                    
                    <!-- Product Name -->
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        {{ $product->name }}
                    </h1>
                    
                    <!-- Price -->
                    @if($product->price)
                        <div class="mb-6">
                            <span class="text-4xl font-bold text-green-600">
                                {{ $product->formatted_price }}
                            </span>
                        </div>
                    @endif
                    
                    <!-- Meta Info -->
                    <div class="flex flex-col md:flex-row gap-4 text-gray-600 mb-6 pb-6 border-b">
                        <div class="flex items-center">
                            <i data-lucide="user" class="w-4 h-4 mr-2"></i>
                            <span>By {{ $product->user->name }}</span>
                        </div>
                        <div class="flex items-center">
                            <i data-lucide="calendar" class="w-4 h-4 mr-2"></i>
                            <span>{{ $product->created_at->format('M d, Y') }}</span>
                        </div>
                       
                    </div>
                    
                    <!-- Description -->
                    <div class="prose prose-lg mb-8">
                        <h3 class="text-lg font-semibold mb-4">Description</h3>
                        <div class="text-gray-700 leading-relaxed">
                            {!! nl2br(e($product->description)) !!}
                        </div>
                    </div>

                    <!-- Specifications (if available) -->
                    @if($product->specifications && count($product->specifications) > 0)
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold mb-4">Specifications</h3>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <dl class="space-y-2">
                                    @foreach($product->specifications as $spec)
                                        <div class="flex">
                                            <dt class="font-medium text-gray-700 w-1/3">{{ $spec['key'] }}:</dt>
                                            <dd class="text-gray-600 w-2/3">{{ $spec['value'] }}</dd>
                                        </div>
                                    @endforeach
                                </dl>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Actions -->
                    <div class="flex gap-4 pt-6">
                        <button class="flex-1 px-8 py-4 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-semibold">
                            <i data-lucide="message-circle" class="w-5 h-5 mr-2 inline"></i>
                            Contact Seller
                        </button>
                        <button class="px-4 py-4 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                            <i data-lucide="heart" class="w-5 h-5"></i>
                        </button>
                        <button class="px-4 py-4 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                            <i data-lucide="share-2" class="w-5 h-5"></i>
                        </button>
                    </div>

                    <!-- Additional Info -->
                    <div class="grid grid-cols-2 gap-4 pt-6 border-t">
                        <div class="text-center p-4 bg-gray-50 rounded-lg">
                            <i data-lucide="shield-check" class="w-8 h-8 text-green-600 mx-auto mb-2"></i>
                            <p class="text-sm font-medium">Verified Seller</p>
                        </div>
                        <div class="text-center p-4 bg-gray-50 rounded-lg">
                            <i data-lucide="truck" class="w-8 h-8 text-blue-600 mx-auto mb-2"></i>
                            <p class="text-sm font-medium">Fast Delivery</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Related Products -->
@if($relatedProducts->count() > 0)
<section class="bg-gray-50 py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-3xl font-bold text-center mb-12">Related Products</h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($relatedProducts as $relatedProduct)
                    <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <!-- Image -->
                        <div class="h-48 bg-gray-300 relative">
                            @if($relatedProduct->featured_image)
                                <img 
                                    src="{{ asset('storage/' . $relatedProduct->featured_image) }}" 
                                    alt="{{ $relatedProduct->name }}"
                                    class="w-full h-full object-cover"
                                >
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-green-400 to-blue-500 flex items-center justify-center">
                                    <i data-lucide="package" class="w-12 h-12 text-white opacity-50"></i>
                                </div>
                            @endif
                            
                            @if($relatedProduct->price)
                                <div class="absolute top-2 right-2">
                                    <span class="px-2 py-1 bg-blue-600 text-white text-xs font-bold rounded shadow-lg">
                                        {{ $relatedProduct->formatted_price }}
                                    </span>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Content -->
                        <div class="p-4">
                            <h3 class="text-lg font-semibold mb-2 line-clamp-2">
                                <a href="{{ route('frontend.products.show', $relatedProduct->slug) }}" class="hover:text-green-600 transition-colors">
                                    {{ $relatedProduct->name }}
                                </a>
                            </h3>
                            
                            <p class="text-gray-600 text-sm line-clamp-2 mb-3">
                                {{ Str::limit(strip_tags($relatedProduct->description), 80) }}
                            </p>
                            
                            @if($relatedProduct->price)
                                <div class="text-lg font-bold text-green-600">
                                    {{ $relatedProduct->formatted_price }}
                                </div>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

<!-- Back to Products -->
<div class="py-8 text-center">
    <a 
        href="{{ route('frontend.products.index') }}"
        class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors"
    >
        <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
        Back to Products
    </a>
</div>

<!-- Gallery Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const mainImage = document.getElementById('main-image');
    const thumbs = document.querySelectorAll('.gallery-thumb');
    
    thumbs.forEach(thumb => {
        thumb.addEventListener('click', function() {
            const newSrc = this.dataset.image;
            if (mainImage && newSrc) {
                mainImage.src = newSrc;
                
                // Update active thumbnail
                thumbs.forEach(t => t.classList.remove('border-green-500'));
                thumbs.forEach(t => t.classList.add('border-transparent'));
                this.classList.remove('border-transparent');
                this.classList.add('border-green-500');
            }
        });
    });
});
</script>
@endsection