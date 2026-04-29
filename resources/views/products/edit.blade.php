@extends('core::dashboard-layout')

@section('header')
    Edit Product
@endsection

@section('content')
<x-forms.crud-form 
    title="Edit Product"
    :action="route('products.update', $product)"
    method="PUT"
    submit-text="Update Product"
    :cancel-url="route('products.index')"
    enctype="multipart/form-data"
    :model="$product">
    
    <!-- Basic Information Section -->
    <x-forms.form-section title="Product Information">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <x-forms.form-input 
                name="name"
                label="Product Name"
                icon="package"
                placeholder="Enter product name"
                :required="true"
                col-span="lg:col-span-2"
                :value="old('name', $product->name)" />

            <x-forms.form-input 
                name="sku"
                label="SKU"
                icon="hash"
                placeholder="Product SKU"
                :required="true"
                :value="old('sku', $product->sku)" />

            <x-forms.form-input 
                name="slug"
                label="Product Slug"
                icon="link"
                placeholder="auto-generated-from-name"
                help="Leave empty to auto-generate from product name"
                :value="old('slug', $product->slug)" />

            <x-forms.form-input 
                name="category_id"
                label="Category"
                type="select"
                icon="folder"
                placeholder="Select Category"
                :options="$categories->pluck('name', 'id')"
                :required="true"
                :value="old('category_id', $product->category_id)" />

            <x-forms.form-input 
                name="price"
                label="Price"
                type="number"
                icon="dollar-sign"
                placeholder="0.00"
                step="0.01"
                :required="true"
                :value="old('price', $product->price)" />

            <x-forms.form-input 
                name="sale_price"
                label="Sale Price"
                type="number"
                icon="tag"
                placeholder="0.00"
                step="0.01"
                help="Leave empty if no discount"
                :value="old('sale_price', $product->sale_price)" />

            <x-forms.form-input 
                name="stock"
                label="Stock Quantity"
                type="number"
                icon="package"
                placeholder="0"
                :required="true"
                :value="old('stock', $product->stock)" />

            <x-forms.form-input 
                name="min_stock"
                label="Minimum Stock"
                type="number"
                icon="alert-triangle"
                placeholder="5"
                help="Alert when stock reaches this level"
                :required="true"
                :value="old('min_stock', $product->min_stock)" />

            <x-forms.form-input 
                name="description"
                label="Product Description"
                type="textarea"
                icon="file-text"
                placeholder="Product description..."
                :rows="4"
                col-span="lg:col-span-2"
                :value="old('description', $product->description)" />
        </div>
    </x-forms.form-section>

    <!-- Images Section -->
    <x-forms.form-section title="Product Images">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Current Featured Image -->
            @if($product->featured_image)
                <div class="col-span-full">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Current Featured Image</label>
                    <div class="flex items-center gap-4">
                        <img src="{{ asset('storage/' . $product->featured_image) }}" 
                             alt="Current featured image" 
                             class="w-20 h-20 object-cover rounded-lg border">
                        <label class="flex items-center">
                            <input type="checkbox" name="remove_current_image" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-600">Remove current image</span>
                        </label>
                    </div>
                </div>
            @endif

            <x-forms.form-input 
                name="featured_image"
                label="Main Product Image"
                type="file"
                icon="image"
                accept="image/*"
                placeholder="Upload main image"
                help="PNG, JPG, GIF up to 2MB" />

            <x-forms.form-input 
                name="gallery_images[]"
                label="Gallery Images"
                type="file"
                icon="images"
                accept="image/*"
                placeholder="Upload gallery images"
                help="Multiple images up to 2MB each"
                :multiple="true" />

            <!-- Current Gallery Images -->
            @if($product->gallery_images && count($product->gallery_images) > 0)
                <div class="col-span-full">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Current Gallery Images</label>
                    <div class="grid grid-cols-4 gap-4">
                        @foreach($product->gallery_images as $index => $image)
                            <div class="relative">
                                <img src="{{ asset('storage/' . $image) }}" 
                                     alt="Gallery image {{ $index + 1 }}" 
                                     class="w-full h-20 object-cover rounded-lg border">
                                <label class="absolute top-1 right-1 bg-white rounded-full p-1">
                                    <input type="checkbox" 
                                           name="remove_gallery_images[]" 
                                           value="{{ $index }}" 
                                           class="w-4 h-4 text-red-600 bg-gray-100 border-gray-300 rounded focus:ring-red-500">
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <p class="text-sm text-gray-500 mt-2">Check images to remove them</p>
                </div>
            @endif
        </div>
    </x-forms.form-section>

    <!-- Settings Section -->
    <x-forms.form-section title="Product Settings">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <x-forms.form-input 
                name="status"
                label="Status"
                type="select"
                icon="toggle-left"
                :options="[
                    'active' => 'Active', 
                    'inactive' => 'Inactive',
                    'out_of_stock' => 'Out of Stock'
                ]"
                :required="true"
                :value="old('status', $product->status)" />

            <x-forms.form-input 
                name="is_featured"
                label="Featured Product"
                type="checkbox"
                icon="star"
                placeholder="Mark as featured product"
                :checked="old('is_featured', $product->is_featured)" />

            <x-forms.form-input 
                name="track_stock"
                label="Track Stock"
                type="checkbox"
                icon="package-check"
                placeholder="Enable stock tracking"
                :checked="old('track_stock', $product->track_stock)" />
        </div>
    </x-forms.form-section>

    <!-- Additional Information Section -->
    <x-forms.form-section title="Additional Information">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <x-forms.form-input 
                name="weight"
                label="Weight (kg)"
                type="number"
                icon="weight"
                placeholder="0.00"
                step="0.01"
                help="Product weight in kilograms"
                :value="old('weight', $product->weight)" />

            <x-forms.form-input 
                name="dimensions"
                label="Dimensions"
                icon="box"
                placeholder="L x W x H (cm)"
                help="Example: 20x15x10"
                :value="old('dimensions', $product->dimensions)" />

            <x-forms.form-input 
                name="meta_description"
                label="Meta Description"
                type="textarea"
                icon="file-text"
                placeholder="SEO description for search engines..."
                :rows="3"
                maxlength="160"
                help="Maximum 160 characters for SEO"
                col-span="lg:col-span-2"
                :value="old('meta_description', $product->meta_description)" />

            <x-forms.form-input 
                name="meta_keywords"
                label="Meta Keywords"
                icon="tag"
                placeholder="keyword1, keyword2, keyword3"
                help="Separate keywords with commas"
                col-span="lg:col-span-2"
                :value="old('meta_keywords', $product->meta_keywords)" />
        </div>
    </x-forms.form-section>

    <!-- Product Statistics Section -->
    <x-forms.form-section title="Product Statistics" icon="bar-chart-3">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-blue-50 p-4 rounded-lg">
                <div class="flex items-center">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-blue-600">Total Views</p>
                        <p class="text-2xl font-bold text-blue-900">{{ number_format($product->view_count) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-green-50 p-4 rounded-lg">
                <div class="flex items-center">
                    <div class="p-2 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-green-600">Total Orders</p>
                        <p class="text-2xl font-bold text-green-900">{{ number_format($product->order_count) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-yellow-50 p-4 rounded-lg">
                <div class="flex items-center">
                    <div class="p-2 bg-yellow-100 rounded-lg">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-yellow-600">Revenue</p>
                        <p class="text-2xl font-bold text-yellow-900">
                            Rp {{ number_format($product->order_count * $product->price, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-purple-50 p-4 rounded-lg">
                <div class="flex items-center">
                    <div class="p-2 bg-purple-100 rounded-lg">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-purple-600">Created</p>
                        <p class="text-sm font-bold text-purple-900">{{ $product->created_at->format('M d, Y') }}</p>
                        <p class="text-xs text-purple-700">{{ $product->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </x-forms.form-section>

</x-forms.crud-form>
@endsection

@push('scripts')
<script>
// Initialize Lucide icons
lucide.createIcons();
</script>
@endpush