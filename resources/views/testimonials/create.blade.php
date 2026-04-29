@extends('core::dashboard-layout')

@section('header')
    Add Testimonial
@endsection

@section('content')
<x-forms.crud-form 
    title="Add New Testimonial"
    :action="route('testimonials.store')"
    method="POST"
    submit-text="Save Testimonial"
    :cancel-url="route('testimonials.index')"
    enctype="multipart/form-data">

    <!-- Testimonial Information Section -->
    <x-forms.form-section title="Testimonial Information">
        <div class="grid grid-cols-1 gap-6">
            <x-forms.form-input 
                name="name"
                label="Name"
                icon="user"
                placeholder="Enter testimonial name"
                :required="true" />

            <x-forms.form-input 
                name="content"
                label="Content"
                type="textarea"
                icon="message-square"
                placeholder="Write testimonial content..."
                :rows="5"
                :required="true"
                help="Short testimonial or feedback text from client." />

            <x-forms.form-input 
                name="order"
                label="Order"
                icon="list-ordered"
                type="number"
                placeholder="Enter display order (e.g. 1, 2, 3)"
                value="{{ old('order', 0) }}"
                help="Lower numbers will appear first." />
        </div>
    </x-forms.form-section>

    <!-- Image Upload Section -->
    <x-forms.form-section title="Client Image (Optional)">
        <div class="grid grid-cols-1 gap-6">
            <div>
                <x-forms.form-input 
                    name="image"
                    label="Image"
                    type="file"
                    icon="image"
                    accept="image/*"
                    placeholder="Upload client image or logo"
                    help="PNG, JPG, or GIF up to 2MB" />

                <!-- Image Preview -->
                <div class="mt-4 hidden relative" id="image-preview-container">
                    <p class="text-sm text-gray-600 mb-2 font-medium">Image Preview:</p>
                    <button type="button" id="remove-preview" class="absolute top-0 right-0 text-white bg-red-600 hover:bg-red-700 rounded-full w-6 h-6 flex items-center justify-center text-xs font-bold shadow">
                        ×
                    </button>
                    <img id="image-preview" src="#" alt="Preview" class="max-h-48 rounded-lg border border-gray-200 shadow-sm">
                </div>
            </div>
        </div>
    </x-forms.form-section>

    <!-- Status Section -->
    <x-forms.form-section title="Status">
        <div class="flex items-center space-x-2">
            <input type="checkbox" name="status" value="1" id="status" 
                class="h-4 w-4 text-teal-600 focus:ring-teal-500 border-gray-300 rounded"
                {{ old('status', true) ? 'checked' : '' }}>
            <label for="status" class="text-sm text-gray-700">Active</label>
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
