@extends('core::dashboard-layout')

@section('header')
    Edit Post
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white p-8 rounded-lg shadow">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Edit Post</h1>
            <a href="{{ route('posts.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition duration-200">
                <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                Back to Posts
            </a>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                <div class="flex items-start">
                    <i data-lucide="alert-circle" class="w-5 h-5 mr-3 mt-0.5 flex-shrink-0"></i>
                    <div>
                        <h3 class="font-semibold">Please fix the following errors:</h3>
                        <ul class="list-disc list-inside mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Basic Information -->
            <div class="border-b pb-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h2>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Title -->
                    <div class="lg:col-span-2">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            <i data-lucide="type" class="w-4 h-4 inline mr-1"></i>
                            Post Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="title" 
                               name="title" 
                               value="{{ old('title', $post->title) }}"
                               placeholder="Enter post title"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('title') border-red-500 @enderror"
                               required>
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Slug -->
                    <div>
                        <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">
                            <i data-lucide="link" class="w-4 h-4 inline mr-1"></i>
                            Slug (Optional)
                        </label>
                        <input type="text" 
                               id="slug" 
                               name="slug" 
                               value="{{ old('slug', $post->slug) }}"
                               placeholder="url-friendly-slug"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('slug') border-red-500 @enderror">
                        @error('slug')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Leave empty to auto-generate from title</p>
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                            <i data-lucide="folder" class="w-4 h-4 inline mr-1"></i>
                            Category <span class="text-red-500">*</span>
                        </label>
                        <select name="category_id" 
                                id="category_id" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('category_id') border-red-500 @enderror"
                                required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="lg:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            <i data-lucide="file-text" class="w-4 h-4 inline mr-1"></i>
                            Short Description
                        </label>
                        <textarea id="description" 
                                  name="description" 
                                  rows="3"
                                  placeholder="Brief description of the post..."
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror">{{ old('description', $post->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="border-b pb-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Content</h2>
                
                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                        <i data-lucide="edit" class="w-4 h-4 inline mr-1"></i>
                        Post Content <span class="text-red-500">*</span>
                    </label>
                    <textarea id="content" 
                              name="content" 
                              rows="12"
                              placeholder="Write your post content here..."
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('content') border-red-500 @enderror"
                              required>{{ old('content', $post->content) }}</textarea>
                    @error('content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Media & Files -->
            <div class="border-b pb-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Media & Files</h2>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Featured Image -->
                    <div>
                        <label for="featured_image" class="block text-sm font-medium text-gray-700 mb-2">
                            <i data-lucide="image" class="w-4 h-4 inline mr-1"></i>
                            Featured Image
                        </label>

                        <!-- Current Image -->
                        @if($post->featured_image)
                            <div class="mb-4">
                                <p class="text-sm text-gray-600 mb-2">Current image:</p>
                                <div class="relative inline-block">
                                    <img src="{{ asset('storage/' . $post->featured_image) }}" 
                                         alt="Current featured image" 
                                         class="h-24 w-24 object-cover rounded-lg border">
                                    <div class="mt-2 flex items-center">
                                        <input type="checkbox" id="remove_current_image" name="remove_current_image" value="1" class="mr-2">
                                        <label for="remove_current_image" class="text-sm text-red-600 cursor-pointer">
                                            Remove current image
                                        </label>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 transition-colors">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="featured_image" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                        <span>{{ $post->featured_image ? 'Replace image' : 'Upload a file' }}</span>
                                        <input id="featured_image" 
                                               name="featured_image" 
                                               type="file" 
                                               accept="image/*"
                                               class="sr-only">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                            </div>
                        </div>
                        @error('featured_image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <!-- New Image Preview -->
                        <div id="image-preview" class="mt-3 hidden">
                            <p class="text-sm text-gray-600 mb-2">New image:</p>
                            <div class="relative inline-block">
                                <img id="preview-img" src="" alt="Preview" class="h-20 w-20 object-cover rounded-lg border">
                                <button type="button" id="remove-image" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs hover:bg-red-600">
                                    ×
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Document Files -->
                    <div>
                        <label for="document_files" class="block text-sm font-medium text-gray-700 mb-2">
                            <i data-lucide="file" class="w-4 h-4 inline mr-1"></i>
                            Document Files
                        </label>

                        <!-- Current Files -->
                        @if($post->document_files && count($post->document_files) > 0)
                            <div class="mb-4">
                                <p class="text-sm text-gray-600 mb-2">Current files:</p>
                                <div class="space-y-2">
                                    @foreach($post->document_files as $index => $file)
                                        <div class="flex items-center justify-between p-2 bg-gray-50 rounded text-sm">
                                            <div class="flex items-center">
                                                <i data-lucide="file-text" class="w-4 h-4 mr-2 text-gray-500"></i>
                                                <span class="text-gray-700">{{ $file['filename'] ?? 'Unknown file' }}</span>
                                                <span class="text-gray-500 ml-2">({{ isset($file['size']) ? number_format($file['size']/1024, 1) . ' KB' : 'Unknown size' }})</span>
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                @if(isset($file['path']))
                                                    <a href="{{ asset('storage/' . $file['path']) }}" 
                                                       target="_blank" 
                                                       class="text-blue-600 hover:text-blue-700">
                                                        <i data-lucide="download" class="w-4 h-4"></i>
                                                    </a>
                                                @endif
                                                <label class="flex items-center cursor-pointer">
                                                    <input type="checkbox" name="remove_current_files[]" value="{{ $index }}" class="mr-1">
                                                    <span class="text-red-600 text-xs">Remove</span>
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 transition-colors">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 48 48">
                                    <path d="M8 14v20c0 4.418 7.163 8 16 8 1.381 0 2.721-.087 4-.252M8 14c0 4.418 7.163 8 16 8s16-3.582 16-8M8 14c0-4.418 7.163-8 16-8s16 3.582 16 8m0 0v14m-16-8l4 4m0 0l4-4m-4 4V14" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="document_files" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                        <span>{{ $post->document_files && count($post->document_files) > 0 ? 'Replace files' : 'Upload files' }}</span>
                                        <input id="document_files" 
                                               name="document_files[]" 
                                               type="file" 
                                               multiple
                                               accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx"
                                               class="sr-only">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PDF, DOC, DOCX, XLS, XLSX, PPT up to 10MB each</p>
                            </div>
                        </div>
                        @error('document_files.*')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <!-- New File List Preview -->
                        <div id="file-list" class="mt-3 space-y-2 hidden">
                            <h4 class="text-sm font-medium text-gray-700">New files selected:</h4>
                            <div id="selected-files" class="space-y-1"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Publishing Settings -->
            <div class="border-b pb-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Publishing Settings</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            <i data-lucide="toggle-left" class="w-4 h-4 inline mr-1"></i>
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select name="status" 
                                id="status" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('status') border-red-500 @enderror"
                                required>
                            <option value="active" {{ old('status', $post->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $post->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Publish Date -->
                    <div>
                        <label for="publish_date" class="block text-sm font-medium text-gray-700 mb-2">
                            <i data-lucide="calendar" class="w-4 h-4 inline mr-1"></i>
                            Publish Date
                        </label>
                        <input type="date" 
                               id="publish_date" 
                               name="publish_date" 
                               value="{{ old('publish_date', $post->publish_date ? $post->publish_date->format('Y-m-d') : '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('publish_date') border-red-500 @enderror">
                        @error('publish_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Featured -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i data-lucide="star" class="w-4 h-4 inline mr-1"></i>
                            Featured Post
                        </label>
                        <div class="flex items-center mt-2">
                            <input type="checkbox" 
                                   id="is_featured" 
                                   name="is_featured" 
                                   value="1"
                                   {{ old('is_featured', $post->is_featured) ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="is_featured" class="ml-2 text-sm text-gray-700">
                                Mark as featured post
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end gap-4 pt-4">
                <a href="{{ route('posts.index') }}" 
                   class="inline-flex items-center px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-200">
                    <i data-lucide="x" class="w-4 h-4 mr-2"></i>
                    Cancel
                </a>
                <button type="submit" 
                        class="inline-flex items-center px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200 font-medium">
                    <i data-lucide="save" class="w-4 h-4 mr-2"></i>
                    Update Post
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
// Initialize CKEditor
CKEDITOR.replace('content', {
    height: 400,
    toolbarGroups: [
        { name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
        { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
        { name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
        { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
        { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
        { name: 'links', groups: [ 'links' ] },
        { name: 'insert', groups: [ 'insert' ] },
        { name: 'styles', groups: [ 'styles' ] },
        { name: 'colors', groups: [ 'colors' ] },
        { name: 'tools', groups: [ 'tools' ] }
    ],
    removeButtons: 'Source,Save,NewPage,Preview,Print,Templates,Language,BidiRtl,BidiLtr,Flash,Smiley,PageBreak,Iframe,ShowBlocks,About'
});

// Auto generate slug from title (only for new slugs or if not manually edited)
document.getElementById('title').addEventListener('input', function() {
    const title = this.value;
    
    // Create slug: convert to lowercase, handle Indonesian characters, replace spaces with hyphens
    let slug = title
        .toLowerCase()
        .trim()
        // Replace Indonesian characters
        .replace(/[àáâãäå]/g, 'a')
        .replace(/[èéêë]/g, 'e')
        .replace(/[ìíîï]/g, 'i')
        .replace(/[òóôõö]/g, 'o')
        .replace(/[ùúûü]/g, 'u')
        .replace(/[ñ]/g, 'n')
        .replace(/[ç]/g, 'c')
        // Remove special characters except spaces and hyphens
        .replace(/[^a-z0-9\s-]/g, '')
        // Replace multiple spaces with single space
        .replace(/\s+/g, ' ')
        // Replace spaces with hyphens
        .replace(/\s/g, '-')
        // Replace multiple hyphens with single hyphen
        .replace(/-+/g, '-')
        // Remove hyphens from start and end
        .replace(/^-+|-+$/g, '');
    
    // Only update slug if user hasn't manually edited it
    const slugInput = document.getElementById('slug');
    if (!slugInput.dataset.manuallyEdited) {
        slugInput.value = slug;
    }
});

// Track if user manually edits slug
document.getElementById('slug').addEventListener('input', function() {
    this.dataset.manuallyEdited = 'true';
});

// Image preview functionality
const featuredImageInput = document.getElementById('featured_image');
const imagePreview = document.getElementById('image-preview');
const previewImg = document.getElementById('preview-img');
const removeImageBtn = document.getElementById('remove-image');

featuredImageInput.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        if (file.size > 2 * 1024 * 1024) { // 2MB limit
            alert('Image size must be less than 2MB');
            this.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            imagePreview.classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    }
});

removeImageBtn.addEventListener('click', function() {
    featuredImageInput.value = '';
    imagePreview.classList.add('hidden');
    previewImg.src = '';
});

// Document files functionality
const documentFilesInput = document.getElementById('document_files');
const fileList = document.getElementById('file-list');
const selectedFilesContainer = document.getElementById('selected-files');

documentFilesInput.addEventListener('change', function(e) {
    const files = Array.from(e.target.files);
    selectedFilesContainer.innerHTML = '';
    
    if (files.length > 0) {
        fileList.classList.remove('hidden');
        
        files.forEach((file, index) => {
            // Check file size (10MB limit)
            if (file.size > 10 * 1024 * 1024) {
                alert(`${file.name} is too large. Maximum size is 10MB.`);
                return;
            }
            
            const fileItem = document.createElement('div');
            fileItem.className = 'flex items-center justify-between p-2 bg-gray-50 rounded text-sm';
            fileItem.innerHTML = `
                <div class="flex items-center">
                    <i data-lucide="file-text" class="w-4 h-4 mr-2 text-gray-500"></i>
                    <span class="text-gray-700">${file.name}</span>
                    <span class="text-gray-500 ml-2">(${formatFileSize(file.size)})</span>
                </div>
                <button type="button" class="text-red-500 hover:text-red-700" onclick="removeFile(${index})">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            `;
            selectedFilesContainer.appendChild(fileItem);
        });
        
        // Re-initialize Lucide icons
        lucide.createIcons();
    } else {
        fileList.classList.add('hidden');
    }
});

// Remove individual file
function removeFile(index) {
    const dt = new DataTransfer();
    const files = Array.from(documentFilesInput.files);
    
    files.forEach((file, i) => {
        if (i !== index) {
            dt.items.add(file);
        }
    });
    
    documentFilesInput.files = dt.files;
    documentFilesInput.dispatchEvent(new Event('change'));
}

// Format file size
function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

// Initialize Lucide icons
lucide.createIcons();
</script>
@endpush
