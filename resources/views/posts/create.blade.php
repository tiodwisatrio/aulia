@extends('core::dashboard-layout')

@section('header')
    Create New Post
@endsection

@section('content')
<x-forms.crud-form 
    title="Create New Post"
    :action="route('posts.store')"
    method="POST"
    submit-text="Save Post"
    :cancel-url="route('posts.index')"
    enctype="multipart/form-data">
    
    <!-- Basic Information Section -->
    <x-forms.form-section title="Basic Information">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <x-forms.form-input 
                name="title"
                label="Post Title"
                icon="type"
                placeholder="Enter post title"
                :required="true"
                col-span="lg:col-span-2" />

            <x-forms.form-input 
                name="slug"
                label="Slug"
                icon="link"
                placeholder="url-friendly-slug"
                help="Leave empty to auto-generate from title" />

            <x-forms.form-input 
                name="category_id"
                label="Category"
                type="select"
                icon="folder"
                placeholder="Select Category"
                :options="$categories->pluck('name', 'id')"
                :required="true" />

            <x-forms.form-input 
                name="description"
                label="Short Description"
                type="textarea"
                icon="file-text"
                placeholder="Brief description of the post..."
                :rows="3"
                col-span="lg:col-span-2" />
        </div>
    </x-forms.form-section>

    <!-- Content Section -->
    <x-forms.form-section title="Content">
        <x-forms.form-input 
            name="content"
            label="Post Content"
            type="textarea"
            icon="edit"
            placeholder="Write your post content here..."
            :rows="12"
            :required="true" />
    </x-forms.form-section>

    <!-- Media & Files Section -->
    <x-forms.form-section title="Media & Files">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <x-forms.form-input 
                name="featured_image"
                label="Featured Image"
                type="file"
                icon="image"
                accept="image/*"
                placeholder="Upload a file"
                help="PNG, JPG, GIF up to 2MB" />

            <x-forms.form-input 
                name="document_files"
                label="Document Files"
                type="file"
                icon="file"
                accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx"
                placeholder="Upload files"
                help="PDF, DOC, DOCX, XLS, XLSX, PPT up to 10MB each"
                :multiple="true" />
        </div>
    </x-forms.form-section>

    <!-- Publishing Settings Section -->
    <x-forms.form-section title="Publishing Settings">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <x-forms.form-input 
                name="status"
                label="Status"
                type="select"
                icon="toggle-left"
                :options="['active' => 'Active', 'inactive' => 'Inactive']"
                value="active"
                :required="true" />

            <x-forms.form-input 
                name="publish_date"
                label="Publish Date"
                type="date"
                icon="calendar"
                :value="date('Y-m-d')" />

            <x-forms.form-input 
                name="is_featured"
                label="Featured Post"
                type="checkbox"
                icon="star"
                placeholder="Mark as featured post" />
        </div>
    </x-forms.form-section>

</x-forms.crud-form>
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

// Auto generate slug from title
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
    
    // Only update slug if it's empty (auto-generate) or if user hasn't manually edited it
    const slugInput = document.getElementById('slug');
    if (slugInput.value === '' || !slugInput.dataset.manuallyEdited) {
        slugInput.value = slug;
    }
});

// Track if user manually edits slug
document.getElementById('slug').addEventListener('input', function() {
    this.dataset.manuallyEdited = 'true';
});

// Image preview functionality
const featuredImageInput = document.getElementById('featured_image');
if (featuredImageInput) {
    featuredImageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            if (file.size > 2 * 1024 * 1024) { // 2MB limit
                alert('Image size must be less than 2MB');
                this.value = '';
                return;
            }
        }
    });
}

// Document files functionality
const documentFilesInput = document.getElementById('document_files');
if (documentFilesInput) {
    documentFilesInput.addEventListener('change', function(e) {
        const files = Array.from(e.target.files);
        
        files.forEach((file) => {
            // Check file size (10MB limit)
            if (file.size > 10 * 1024 * 1024) {
                alert(`${file.name} is too large. Maximum size is 10MB.`);
                this.value = '';
                return;
            }
        });
    });
}

// Initialize Lucide icons
lucide.createIcons();
</script>
@endpush

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

// Auto generate slug from title
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
    
    // Only update slug if it's empty (auto-generate) or if user hasn't manually edited it
    const slugInput = document.getElementById('slug');
    if (slugInput.value === '' || !slugInput.dataset.manuallyEdited) {
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
