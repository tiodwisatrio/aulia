@extends('core::dashboard-layout')

@section('header')
    Edit Post
@endsection

@section('content')
<x-forms.crud-form 
    title="Edit Post"
    :action="route('posts.update', $post)"
    method="PUT"
    submit-text="Update Post"
    :cancel-url="route('posts.index')"
    enctype="multipart/form-data"
    :model="$post">
    
    <!-- Basic Information Section -->
    <x-forms.form-section title="Basic Information">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <x-forms.form-input 
                name="title"
                label="Post Title"
                icon="type"
                placeholder="Enter post title"
                :required="true"
                col-span="lg:col-span-2"
                :value="old('title', $post->title)" />

            <x-forms.form-input 
                name="slug"
                label="Slug"
                icon="link"
                placeholder="url-friendly-slug"
                help="Leave empty to auto-generate"
                :value="old('slug', $post->slug)" />

            <x-forms.form-input 
                name="category_id"
                label="Category"
                type="select"
                icon="folder"
                placeholder="Select Category"
                :options="$categories->pluck('name', 'id')"
                :required="true"
                :selected="old('category_id', $post->category_id)" />

            <x-forms.form-input 
                name="description"
                label="Description"
                type="textarea"
                icon="file-text"
                placeholder="Brief description..."
                :rows="3"
                col-span="lg:col-span-2"
                :value="old('description', $post->description)" />

            <x-forms.form-input 
                name="content"
                label="Content"
                type="textarea"
                icon="edit-3"
                placeholder="Write your post content here..."
                :rows="10"
                col-span="lg:col-span-2"
                :required="true"
                :value="old('content', $post->content)" />
        </div>
    </x-forms.form-section>

    <!-- Media Section -->
    <x-forms.form-section title="Media">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Current Featured Image -->
            @if($post->featured_image)
                <div class="col-span-full">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Current Featured Image</label>
                    <div class="flex items-center gap-4">
                        <img src="{{ asset('storage/' . $post->featured_image) }}" 
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
                label="Featured Image"
                type="file"
                icon="image"
                accept="image/*"
                placeholder="Upload featured image"
                help="PNG, JPG, GIF up to 2MB" />

            <x-forms.form-input 
                name="document_files[]"
                label="Document Files"
                type="file"
                icon="paperclip"
                accept=".pdf,.doc,.docx"
                placeholder="Upload documents"
                help="PDF, DOC files up to 5MB each"
                :multiple="true" />

            <!-- Current Documents -->
            @if($post->document_files && count($post->document_files) > 0)
                <div class="col-span-full">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Current Documents</label>
                    <div class="grid grid-cols-2 gap-4">
                        @foreach($post->document_files as $index => $file)
                            <div class="flex items-center justify-between p-3 border rounded-lg">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <span class="text-sm">{{ basename($file) }}</span>
                                </div>
                                <label class="flex items-center">
                                    <input type="checkbox" 
                                           name="remove_document_files[]" 
                                           value="{{ $index }}" 
                                           class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <p class="text-sm text-gray-500 mt-2">Check files to remove them</p>
                </div>
            @endif
        </div>
    </x-forms.form-section>

    <!-- Publishing Section -->
    <x-forms.form-section title="Publishing">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <x-forms.form-input 
                name="status"
                label="Status"
                type="select"
                icon="toggle-left"
                :options="[
                    'active' => 'Active', 
                    'inactive' => 'Inactive'
                ]"
                :required="true"
                :selected="old('status', $post->status)" />

            <x-forms.form-input 
                name="publish_date"
                label="Publish Date"
                type="date"
                icon="calendar"
                :value="old('publish_date', $post->publish_date ? $post->publish_date->format('Y-m-d') : '')" />

            <x-forms.form-input 
                name="is_featured"
                label="Featured Post"
                type="checkbox"
                icon="star"
                placeholder="Mark as featured post"
                :checked="old('is_featured', $post->is_featured)" />
        </div>
    </x-forms.form-section>

    <!-- Additional Fields Section -->
    <x-forms.form-section title="Additional Fields">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <x-forms.form-input 
                name="price"
                label="Price"
                type="number"
                icon="dollar-sign"
                placeholder="0.00"
                step="0.01"
                help="Leave empty if free"
                :value="old('price', $post->price)" />

            <x-forms.form-input 
                name="event_date"
                label="Event Date"
                type="datetime-local"
                icon="calendar"
                help="If this is an event post"
                :value="old('event_date', $post->event_date ? $post->event_date->format('Y-m-d\TH:i') : '')" />

            <x-forms.form-input 
                name="deadline"
                label="Deadline"
                type="datetime-local"
                icon="clock"
                help="If this post has a deadline"
                :value="old('deadline', $post->deadline ? $post->deadline->format('Y-m-d\TH:i') : '')" />
        </div>
    </x-forms.form-section>

    <!-- Post Statistics Section -->
    <x-forms.form-section title="Post Statistics" icon="bar-chart-3">
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
                        <p class="text-2xl font-bold text-blue-900">{{ number_format($post->view_count) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-green-50 p-4 rounded-lg">
                <div class="flex items-center">
                    <div class="p-2 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-green-600">Likes</p>
                        <p class="text-2xl font-bold text-green-900">{{ number_format($post->likes_count ?? 0) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-yellow-50 p-4 rounded-lg">
                <div class="flex items-center">
                    <div class="p-2 bg-yellow-100 rounded-lg">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-yellow-600">Comments</p>
                        <p class="text-2xl font-bold text-yellow-900">{{ number_format($post->comments_count ?? 0) }}</p>
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
                        <p class="text-sm font-bold text-purple-900">{{ $post->created_at->format('M d, Y') }}</p>
                        <p class="text-xs text-purple-700">{{ $post->created_at->diffForHumans() }}</p>
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