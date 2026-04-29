@extends('core::dashboard-layout')

@section('header')
    Edit Agenda
@endsection

@section('content')
<x-forms.crud-form 
    title="Edit Agenda"
    :action="route('agendas.update', $agenda)"
    method="POST"
    submit-text="Update Agenda"
    :cancel-url="route('agendas.index')"
    enctype="multipart/form-data">

    @method('PUT')

    {{-- SECTION: Basic Information --}}
    <x-forms.form-section title="Agenda Information">
        <div class="grid grid-cols-1 gap-6">
            <x-forms.form-input 
                name="title"
                label="Agenda Title"
                icon="type"
                placeholder="Enter agenda title"
                :required="true"
                value="{{ old('title', $agenda->title) }}" />

            <x-forms.form-input 
                name="location"
                label="Location"
                icon="map-pin"
                placeholder="Enter location"
                value="{{ old('location', $agenda->location) }}" />


            <x-forms.form-input 
                name="start_date"
                label="Start Date"
                icon="calendar"
                type="date"
                :required="true"
                value="{{ old('start_date', $agenda->start_date ? \Illuminate\Support\Carbon::parse($agenda->start_date)->format('Y-m-d') : '') }}" />

            <x-forms.form-input 
                name="end_date"
                label="End Date"
                icon="calendar"
                type="date"
                value="{{ old('end_date', $agenda->end_date ? \Illuminate\Support\Carbon::parse($agenda->end_date)->format('Y-m-d') : '') }}" />

            <x-forms.form-input 
                name="description"
                label="Description"
                icon="align-left"
                type="textarea"
                rows="4"
                placeholder="Write description..."
                value="{{ old('description', $agenda->description) }}" />
        </div>
    </x-forms.form-section>

    {{-- SECTION: Feature Image --}}
    <x-forms.form-section title="Feature Image">
        <div class="grid grid-cols-1 gap-6">
            <div>
                <x-forms.form-input 
                    name="image"
                    label="Replace Image"
                    type="file"
                    icon="image"
                    accept="image/*"
                    help="Upload to replace current image (Optional)" />

                {{-- Image Preview --}}
                <div class="mt-4 relative {{ $agenda->image ? '' : 'hidden' }}" id="image-preview-container">
                    <p class="text-sm text-gray-600 mb-2 font-medium">Current Image:</p>
                    <button type="button" id="remove-preview" 
                        class="absolute top-0 right-0 text-white bg-red-600 hover:bg-red-700 rounded-full w-6 h-6 flex items-center justify-center text-xs font-bold shadow">
                        ×
                    </button>
                    <img id="image-preview" 
                        src="{{ $agenda->image ? asset('storage/' . $agenda->image) : '#' }}" 
                        alt="Preview" 
                        class="max-h-48 rounded-lg border border-gray-200 shadow-sm object-contain">
                </div>
            </div>
        </div>
    </x-forms.form-section>

    {{-- SECTION: Status --}}
    <x-forms.form-section title="Status">
        <div class="flex items-center space-x-2">
            <input type="checkbox" name="status" id="status" value="1" 
                {{ old('status', $agenda->status) ? 'checked' : '' }}
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

        // Preview new upload
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

        // Remove preview
        removeBtn.addEventListener('click', function () {
            imageInput.value = '';
            previewImage.src = '#';
            previewContainer.classList.add('hidden');
        });
    });
</script>
@endpush
