@extends('core::dashboard-layout')

@section('header')
    Create Agenda
@endsection

@section('content')
<x-forms.crud-form 
    title="Add New Agenda"
    :action="route('agendas.store')"
    method="POST"
    submit-text="Save Agenda"
    :cancel-url="route('agendas.index')"
    enctype="multipart/form-data">

    <!-- Basic Information Section -->
    <x-forms.form-section title="Agenda Information">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <x-forms.form-input 
                name="title"
                label="Agenda Title"
                icon="file-text"
                placeholder="Enter agenda title"
                :required="true" />

            <x-forms.form-input 
                name="start_date"
                label="Start Date"
                type="date"
                icon="calendar"
                :required="true" />

            <x-forms.form-input 
                name="end_date"
                label="End Date (Optional)"
                type="date"
                icon="calendar"
                placeholder="Optional" />

            <x-forms.form-input 
                name="location"
                label="Location"
                icon="map-pin"
                placeholder="Enter location" />
        </div>

        <div class="mt-6">
            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea name="description" 
                rows="4"
                placeholder="Enter agenda details"
                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-teal-500 focus:border-teal-500">{{ old('description') }}</textarea>
        </div>
    </x-forms.form-section>

    <!-- Image Upload Section -->
    <x-forms.form-section title="Agenda Image (Optional)">
        <div class="grid grid-cols-1 gap-6">

            <x-forms.form-input 
                name="image"
                label="Upload Image"
                type="file"
                icon="image"
                accept="image/*"
                placeholder="Select image file"
                help="Recommended: JPG/PNG max 2MB" />

            <!-- Image Preview -->
            <div class="mt-4 hidden relative" id="image-preview-container">
                <p class="text-sm text-gray-600 mb-2 font-medium">Image Preview:</p>

                <button type="button" id="remove-preview" 
                    class="absolute top-0 right-0 text-white bg-red-600 hover:bg-red-700 rounded-full 
                           w-6 h-6 flex items-center justify-center text-xs font-bold shadow">×
                </button>

                <img id="image-preview" src="#" alt="Preview" 
                    class="max-h-48 rounded-lg border border-gray-200 shadow-sm object-contain">
            </div>
        </div>
    </x-forms.form-section>

    <!-- Status Section -->
    <x-forms.form-section title="Status">
        <div class="flex items-center space-x-2">
            <input type="checkbox" 
                   name="status" 
                   id="status" 
                   value="1" 
                   {{ old('status', true) ? 'checked' : '' }}
                   class="h-4 w-4 text-teal-600 focus:ring-teal-500 border-gray-300 rounded">
            <label for="status" class="text-sm text-gray-700">Active</label>
        </div>
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
