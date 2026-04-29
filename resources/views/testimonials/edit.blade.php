@extends('core::dashboard-layout')

@section('header')
    Edit Testimonial
@endsection

@section('content')
<x-forms.crud-form 
    title="Edit Testimonial"
    :action="route('testimonials.update', $testimonial->id)"
    method="POST"
    submit-text="Update Testimonial"
    :cancel-url="route('testimonials.index')"
    enctype="multipart/form-data">

    @method('PUT')

    <!-- Basic Information -->
    <x-forms.form-section title="Testimonial Information">
        <div class="grid grid-cols-1 gap-6">
            <!-- Name -->
            <x-forms.form-input 
                name="name"
                label="Client Name"
                icon="user"
                placeholder="Enter client's name"
                :value="old('name', $testimonial->name)"
                :required="true" />

            <!-- Content -->
            <x-forms.form-input 
                name="content"
                label="Testimonial Content"
                type="textarea"
                icon="message-square"
                placeholder="Enter testimonial text..."
                :rows="5"
                :value="old('content', $testimonial->content)"
                :required="true"
                help="You can add a short testimonial or feedback message." />

            <!-- Order -->
            <x-forms.form-input 
                name="order"
                label="Display Order"
                type="number"
                icon="list-ordered"
                placeholder="Set display order"
                :value="old('order', $testimonial->order)"
                help="Lower numbers appear first." />
        </div>
    </x-forms.form-section>

    <!-- Image Section -->
    <x-forms.form-section title="Client Image (Optional)">
        <div class="grid grid-cols-1 gap-6">
            <div>
                <x-forms.form-input 
                    name="image"
                    label="Upload New Image"
                    type="file"
                    icon="image"
                    accept="image/*"
                    help="PNG, JPG, or GIF up to 2MB" />

                <!-- Image Preview -->
                <div class="mt-4 relative" id="image-preview-container">
                    <p class="text-sm text-gray-600 mb-2 font-medium">Current Image:</p>
                    <div class="relative inline-block border border-gray-200 rounded-lg overflow-hidden shadow-sm">
                        @if($testimonial->image)
                            <img id="image-preview" 
                                 src="{{ asset('storage/' . $testimonial->image) }}" 
                                 alt="Current Image" 
                                 class="max-h-48 rounded-lg">
                        @else
                            <div class="w-48 h-32 bg-gray-50 flex items-center justify-center text-gray-400">
                                <i data-lucide="image" class="w-6 h-6"></i>
                            </div>
                        @endif
                        <button type="button" 
                                id="remove-preview" 
                                class="absolute top-0 right-0 bg-red-600 hover:bg-red-700 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs font-bold shadow">
                            ×
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </x-forms.form-section>

    <!-- Status Section -->
    <x-forms.form-section title="Status">
        <div class="flex items-center">
            <label class="flex items-center space-x-2">
                <input type="checkbox" 
                       name="status" 
                       value="1"
                       {{ old('status', $testimonial->status) ? 'checked' : '' }}
                       class="h-4 w-4 text-teal-600 focus:ring-teal-500 border-gray-300 rounded">
                <span class="text-sm text-gray-700">Active</span>
            </label>
        </div>
    </x-forms.form-section>

</x-forms.crud-form>
@endsection

@push('scripts')
<script>
    lucide.createIcons();

    // Image preview functionality
    document.addEventListener("DOMContentLoaded", function () {
        const imageInput = document.querySelector('input[name="image"]');
        const previewContainer = document.getElementById('image-preview-container');
        const previewImage = document.getElementById('image-preview');
        const removeBtn = document.getElementById('remove-preview');

        if (imageInput) {
            imageInput.addEventListener('change', function (e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (event) {
                        previewImage.src = event.target.result;
                        previewContainer.classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                } else {
                    previewImage.src = '#';
                    previewContainer.classList.add('hidden');
                }
            });

            removeBtn.addEventListener('click', function () {
                imageInput.value = '';
                previewImage.src = '#';
                previewContainer.classList.add('hidden');
            });
        }
    });
</script>
@endpush
