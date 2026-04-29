@extends('core::dashboard-layout')

@section('header')
    Create Our Client
@endsection

@section('content')
<x-forms.crud-form 
    title="Add New Client"
    :action="route('ourclient.store')"
    method="POST"
    submit-text="Save Client"
    :cancel-url="route('ourclient.index')"
    enctype="multipart/form-data">

    <!-- Basic Information Section -->
    <x-forms.form-section title="Client Information">
        <div class="grid grid-cols-1 gap-6">
            <x-forms.form-input 
                name="name"
                label="Client Name"
                icon="user"
                placeholder="Enter client name"
                :required="true" />

            <x-forms.form-input 
                name="order"
                label="Display Order"
                icon="list-ordered"
                type="number"
                value="{{ old('order', 0) }}"
                placeholder="e.g. 1"
                help="Lower numbers will appear first." />
        </div>
    </x-forms.form-section>

    <!-- Logo / Image Upload Section -->
    <x-forms.form-section title="Client Logo or Image">
        <div class="grid grid-cols-1 gap-6">
            <div>
                <x-forms.form-input 
                    name="image"
                    label="Upload Client Image"
                    type="file"
                    icon="image"
                    accept="image/*"
                    placeholder="Select image file"
                    help="Recommended: Square PNG/JPG image, max 2MB" />

                <!-- Image Preview -->
                <div class="mt-4 hidden relative" id="image-preview-container">
                    <p class="text-sm text-gray-600 mb-2 font-medium">Image Preview:</p>
                    <button type="button" id="remove-preview" class="absolute top-0 right-0 text-white bg-red-600 hover:bg-red-700 rounded-full w-6 h-6 flex items-center justify-center text-xs font-bold shadow">
                        ×
                    </button>
                    <img id="image-preview" src="#" alt="Preview" class="max-h-48 rounded-lg border border-gray-200 shadow-sm object-contain">
                </div>
            </div>
        </div>
    </x-forms.form-section>

    <!-- Status Section -->
    <x-forms.form-section title="Status">
        <div class="flex items-center space-x-2">
            <input type="checkbox" name="status" id="status" value="1" 
                {{ old('status', true) ? 'checked' : '' }}
                class="h-4 w-4 text-teal-600 focus:ring-teal-500 border-gray-300 rounded">
            <label for="status" class="text-sm text-gray-700">Active</label>
        </div>
    </x-forms.form-section>

</x-forms.crud-form>
@endsection

@push('scripts')
<script>
    // Initialize Lucide icons
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
