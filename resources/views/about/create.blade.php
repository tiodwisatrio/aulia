@extends('core::dashboard-layout')

@section('header')
    Create About
@endsection

@section('content')
<x-forms.crud-form 
    title="Create About"
    :action="route('abouts.store')"
    method="POST"
    submit-text="Save About"
    :cancel-url="route('abouts.index')"
    enctype="multipart/form-data">

    <!-- Basic Information -->
    <x-forms.form-section title="About Information">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <x-forms.form-input 
                name="title"
                label="Title"
                icon="info"
                placeholder="Enter about title"
                :required="true" />

            <x-forms.form-input 
                name="order"
                label="Order"
                type="number"
                icon="hash"
                placeholder="Order number (e.g., 1, 2, 3)" />
        </div>

        <x-forms.form-input 
            name="content"
            label="About Content"
            type="textarea"
            icon="align-left"
            placeholder="Write the about content..."
            :rows="5"
            :required="true"
            help="You can include a description or story here." />
    </x-forms.form-section>

    <!-- Image Upload -->
    <x-forms.form-section title="About Image (Optional)">
        <x-forms.form-input 
            name="image"
            label="About Image"
            type="file"
            icon="image"
            accept="image/*"
            placeholder="Upload about image"
            help="PNG, JPG, or GIF up to 2MB" />

        <!-- Preview -->
        <div class="mt-4 hidden relative" id="image-preview-container">
            <p class="text-sm text-gray-600 mb-2 font-medium">Image Preview:</p>
            <button type="button" id="remove-preview" class="absolute top-0 right-0 text-white bg-red-600 hover:bg-red-700 rounded-full w-6 h-6 flex items-center justify-center text-xs font-bold shadow">
                ×
            </button>
            <img id="image-preview" src="#" alt="Preview" class="max-h-48 rounded-lg border border-gray-200 shadow-sm">
        </div>
    </x-forms.form-section>

    <!-- Status -->
    <x-forms.form-section title="Visibility Settings">
        <x-forms.form-input 
            name="status"
            label="Status"
            type="select"
            icon="toggle-right"
            :options="['1' => 'Active', '0' => 'Inactive']"
            value="1"
            help="Set whether this about section is visible on the frontend." />
    </x-forms.form-section>

</x-forms.crud-form>
@endsection

@push('scripts')
<script>
    lucide.createIcons();

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