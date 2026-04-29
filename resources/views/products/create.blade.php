@extends('core::dashboard-layout')

@section('header')
    Create New Product
@endsection

@section('content')
<x-forms.crud-form 
    title="Create New Product"
    :action="route('products.store')"
    method="POST"
    submit-text="Save Product"
    :cancel-url="route('products.index')"
    enctype="multipart/form-data">
    
    <!-- Basic Information Section -->
    <x-forms.form-section title="Product Information">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <x-forms.form-input 
                name="name"
                label="Product Name"
                icon="package"
                placeholder="Enter product name"
                :required="true"
                col-span="lg:col-span-2" />

            <x-forms.form-input 
                name="sku"
                label="SKU"
                icon="hash"
                placeholder="Product SKU"
                :required="true" />

            <x-forms.form-input 
                name="slug"
                label="Product Slug"
                icon="link"
                placeholder="auto-generated-from-name"
                help="Leave empty to auto-generate from product name" />

            <x-forms.form-input 
                name="category_id"
                label="Category"
                type="select"
                icon="folder"
                placeholder="Select Category"
                :options="$categories->pluck('name', 'id')"
                :required="true" />

            <x-forms.form-input 
                name="price"
                label="Price"
                type="number"
                icon="dollar-sign"
                placeholder="0.00"
                step="0.01"
                :required="true" />

            <x-forms.form-input 
                name="sale_price"
                label="Sale Price"
                type="number"
                icon="tag"
                placeholder="0.00"
                step="0.01"
                help="Leave empty if no discount" />

            <x-forms.form-input 
                name="stock"
                label="Stock Quantity"
                type="number"
                icon="package"
                placeholder="0"
                :required="true" />

            <x-forms.form-input 
                name="min_stock"
                label="Minimum Stock"
                type="number"
                icon="alert-triangle"
                placeholder="5"
                help="Alert when stock reaches this level"
                :required="true" />

            <x-forms.form-input 
                name="description"
                label="Product Description"
                type="textarea"
                icon="file-text"
                placeholder="Product description..."
                :rows="4"
                col-span="lg:col-span-2" />
        </div>
    </x-forms.form-section>

    <!-- Images Section -->
    <x-forms.form-section title="Product Images">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
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
                value="active"
                :required="true" />

            <x-forms.form-input 
                name="is_featured"
                label="Featured Product"
                type="checkbox"
                icon="star"
                placeholder="Mark as featured product" />

            <x-forms.form-input 
                name="track_stock"
                label="Track Stock"
                type="checkbox"
                icon="package-check"
                placeholder="Enable stock tracking"
                :checked="true" />
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
                help="Product weight in kilograms" />

            <x-forms.form-input 
                name="dimensions"
                label="Dimensions"
                icon="box"
                placeholder="L x W x H (cm)"
                help="Example: 20x15x10" />

            <x-forms.form-input 
                name="meta_description"
                label="Meta Description"
                type="textarea"
                icon="file-text"
                placeholder="SEO description for search engines..."
                :rows="3"
                maxlength="160"
                help="Maximum 160 characters for SEO"
                col-span="lg:col-span-2" />

            <x-forms.form-input 
                name="meta_keywords"
                label="Meta Keywords"
                icon="tag"
                placeholder="keyword1, keyword2, keyword3"
                help="Separate keywords with commas"
                col-span="lg:col-span-2" />
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