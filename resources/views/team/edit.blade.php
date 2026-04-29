

@extends('core::dashboard-layout')

@section('header')
    Edit Team Member
@endsection

@section('content')
<x-forms.crud-form 
    title="Edit Team Member"
    :action="route('teams.update', $team)"
    method="POST"
    submit-text="Update Member"
    :cancel-url="route('teams.index')"
    enctype="multipart/form-data">
    @method('PUT')

    <!-- Basic Information Section -->
    <x-forms.form-section title="Team Information">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <x-forms.form-input 
                name="name"
                label="Name"
                icon="user"
                placeholder="Enter member name"
                :required="true"
                col-span="lg:col-span-2"
                :value="old('name', $team->name)" />

            <x-forms.form-input 
                name="category_id"
                label="Division (Category)"
                type="select"
                icon="layers"
                placeholder="Select division"
                :options="$categories->pluck('name', 'id')"
                :required="true"
                :value="old('category_id', $team->category_id)" />
        </div>
    </x-forms.form-section>

    <!-- Image Section -->
    <x-forms.form-section title="Profile Image">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @if($team->image)
                <div class="col-span-full">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Current Image</label>
                    <div class="flex items-center gap-4">
                        <img src="{{ asset('storage/' . $team->image) }}" 
                             alt="Current image" 
                             class="w-20 h-20 object-cover rounded-lg border">
                        <label class="flex items-center">
                            <input type="checkbox" name="remove_current_image" value="1" class="rounded border-gray-300 text-red-600 shadow-sm focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-600">Remove current image</span>
                        </label>
                    </div>
                </div>
            @endif

            <x-forms.form-input 
                name="image"
                label="Upload New Image"
                type="file"
                icon="image"
                accept="image/*"
                placeholder="Upload image"
                help="PNG, JPG, GIF up to 2MB" />
        </div>
    </x-forms.form-section>

    <!-- Description Section -->
    <x-forms.form-section title="Description">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <x-forms.form-input 
                name="description"
                label="Description"
                type="textarea"
                icon="file-text"
                placeholder="Enter description"
                :rows="4"
                col-span="lg:col-span-2"
                :value="old('description', $team->description)" />
        </div>
    </x-forms.form-section>

    <!-- Status Section -->
    <x-forms.form-section title="Status">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <x-forms.form-input 
                name="status"
                label="Status"
                type="select"
                icon="toggle-left"
                :options="[1 => 'Active', 0 => 'Inactive']"
                :required="true"
                :value="old('status', $team->status)" />
        </div>
    </x-forms.form-section>

</x-forms.crud-form>
@endsection

@push('scripts')
<script>
lucide.createIcons();
</script>
@endpush
