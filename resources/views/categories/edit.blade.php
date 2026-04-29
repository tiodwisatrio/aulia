@extends('core::dashboard-layout')

@section('header')
    Edit Category
@endsection

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-gray-600 mb-2">
            <a href="{{ route('categories.index') }}" class="hover:text-teal-600">Categories</a>
            <i data-lucide="chevron-right" class="w-4 h-4"></i>
            <span class="text-gray-900">Edit {{ $category->name }}</span>
        </div>
        <h2 class="text-2xl font-bold text-gray-800">Edit Category</h2>
    </div>

    <!-- Form -->
    <form action="{{ route('categories.update', $category) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Basic Information -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <i data-lucide="info" class="w-5 h-5 mr-2 text-teal-600"></i>
                Basic Information
            </h3>

            <div class="space-y-4">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Category Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name', $category->name) }}"
                           required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Slug -->
                <div>
                    <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">
                        Slug
                    </label>
                    <input type="text" 
                           id="slug" 
                           name="slug" 
                           value="{{ old('slug', $category->slug) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 @error('slug') border-red-500 @enderror">
                    <p class="mt-1 text-xs text-gray-500">Leave empty to auto-generate from name</p>
                    @error('slug')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Type (hidden, set from parent menu) -->
                <input type="hidden" name="type" value="{{ request('type', $category->type) }}">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Category Type
                    </label>
                    <span class="inline-block px-3 py-1 rounded bg-gray-100 text-gray-700 text-sm font-semibold">
                        {{ ucfirst(request('type', $category->type)) }}
                    </span>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Description
                    </label>
                    <textarea id="description" 
                              name="description" 
                              rows="3"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 @error('description') border-red-500 @enderror">{{ old('description', $category->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Display Settings -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <i data-lucide="palette" class="w-5 h-5 mr-2 text-teal-600"></i>
                Display Settings
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Color -->
                <div>
                    <label for="color" class="block text-sm font-medium text-gray-700 mb-2">
                        Color
                    </label>
                    <div class="flex gap-2">
                        <input type="color" 
                               id="color" 
                               name="color" 
                               value="{{ old('color', $category->color ?? '#3b82f6') }}"
                               class="h-10 w-16 rounded border border-gray-300 cursor-pointer">
                        <input type="text" 
                               id="color-text" 
                               value="{{ old('color', $category->color ?? '#3b82f6') }}"
                               readonly
                               class="flex-1 px-4 py-2 border border-gray-300 rounded-lg bg-gray-50">
                    </div>
                    @error('color')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Icon -->
                <div>
                    <label for="icon" class="block text-sm font-medium text-gray-700 mb-2">
                        Icon (Lucide)
                    </label>
                    <div class="flex gap-2">
                        <input type="text" 
                               id="icon" 
                               name="icon" 
                               value="{{ old('icon', $category->icon) }}"
                               placeholder="folder"
                               class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 @error('icon') border-red-500 @enderror">
                        <div id="icon-preview" class="w-10 h-10 border border-gray-300 rounded-lg flex items-center justify-center bg-gray-50">
                            <i data-lucide="{{ old('icon', $category->icon ?? 'folder') }}" class="w-5 h-5 text-gray-400"></i>
                        </div>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">
                        Example: folder, tag, package. <a href="https://lucide.dev/icons/" target="_blank" class="text-teal-600 hover:underline">Browse icons</a>
                    </p>
                    @error('icon')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Sort Order -->
                <div>
                    <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">
                        Sort Order
                    </label>
                    <input type="number" 
                           id="sort_order" 
                           name="sort_order" 
                           value="{{ old('sort_order', $category->sort_order) }}"
                           min="0"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 @error('sort_order') border-red-500 @enderror">
                    <p class="mt-1 text-xs text-gray-500">Lower numbers appear first</p>
                    @error('sort_order')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <label class="flex items-center mt-3">
                        <input type="checkbox" 
                               name="is_active" 
                               value="1"
                               {{ old('is_active', $category->is_active) ? 'checked' : '' }}
                               class="h-4 w-4 text-teal-600 focus:ring-teal-500 border-gray-300 rounded">
                        <span class="ml-2 text-sm text-gray-700">Active</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        @if($category->posts_count > 0 || $category->products_count > 0)
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <h4 class="font-semibold text-blue-900 mb-2 flex items-center">
                <i data-lucide="info" class="w-4 h-4 mr-2"></i>
                Category Usage
            </h4>
            <div class="flex gap-4 text-sm text-blue-800">
                @if($category->posts_count > 0)
                    <span><i data-lucide="file-text" class="w-4 h-4 inline"></i> {{ $category->posts_count }} Posts</span>
                @endif
                @if($category->products_count > 0)
                    <span><i data-lucide="package" class="w-4 h-4 inline"></i> {{ $category->products_count }} Products</span>
                @endif
            </div>
        </div>
        @endif

        <!-- Actions -->
        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('categories.index') }}" 
               class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-200">
                Cancel
            </a>
            <button type="submit" 
                    class="px-6 py-2 bg-teal-600 hover:bg-teal-700 text-white rounded-lg transition duration-200">
                <i data-lucide="save" class="w-4 h-4 inline mr-1"></i>
                Update Category
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    // Initialize Lucide icons
    lucide.createIcons();

    // Color picker sync
    const colorInput = document.getElementById('color');
    const colorText = document.getElementById('color-text');
    
    colorInput.addEventListener('input', function() {
        colorText.value = this.value;
    });

    // Icon preview
    const iconInput = document.getElementById('icon');
    const iconPreview = document.getElementById('icon-preview');
    
    iconInput.addEventListener('input', function() {
        const iconName = this.value || 'folder';
        iconPreview.innerHTML = '';
        const iconElement = document.createElement('i');
        iconElement.setAttribute('data-lucide', iconName);
        iconElement.className = 'w-5 h-5 text-gray-400';
        iconPreview.appendChild(iconElement);
        lucide.createIcons();
    });
</script>
@endpush
