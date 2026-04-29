@extends('core::dashboard-layout')

@section('header')
    Create Why Choose Us
@endsection

@section('content')
<x-forms.crud-form 
    title="Add Why Choose Us"
    :action="route('whychooseus.store')"
    method="POST"
    submit-text="Save"
    :cancel-url="route('whychooseus.index')"
    enctype="multipart/form-data">

    {{-- SECTION: Title & Description --}}
    <x-forms.form-section title="Content Information">
        <div class="grid grid-cols-1 gap-6">

            <x-forms.form-input 
                name="title"
                label="Title"
                icon="type"
                placeholder="Enter title"
                :required="true" />

            <div>
                <label for="description" class="block text-gray-700 font-semibold mb-2">Description</label>
                <textarea name="description" id="description" rows="4" placeholder="Write description here..." class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-teal-500 focus:border-teal-500">{{ old('description') }}</textarea>
            </div>
        </div>
    </x-forms.form-section>

    {{-- SECTION: Image Upload --}}
    <x-forms.form-section title="Feature Image">
        <div class="grid grid-cols-1 gap-6">
            <div>
                <x-forms.form-input 
                    name="image"
                    label="Upload Image"
                    type="file"
                    icon="image"
                    accept="image/*"
                    help="Recommended: PNG/JPG, Max 2MB" />

                {{-- Image Preview --}}
                <div class="mt-4 hidden relative" id="image-preview-container">
                    <p class="text-sm text-gray-600 mb-2 font-medium">Image Preview:</p>

                    <button type="button" id="remove-preview" 
                        class="absolute top-0 right-0 text-white bg-red-600 hover:bg-red-700 
                        rounded-full w-6 h-6 flex items-center justify-center text-xs font-bold shadow">
                        ×
                    </button>

                    <img id="image-preview" src="#" 
                        alt="Preview" 
                        class="max-h-48 rounded-lg border border-gray-200 shadow-sm object-contain">
                </div>
            </div>
        </div>
    </x-forms.form-section>

    {{-- SECTION: Status --}}
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
