@extends('core::dashboard-layout')

@section('header')
    Add Team Member
@endsection

@section('content')
<x-forms.crud-form 
    title="Add New Team Member"
    :action="route('teams.store')"
    method="POST"
    submit-text="Save Member"
    :cancel-url="route('teams.index')"
    enctype="multipart/form-data">

    <!-- Basic Information -->
    <x-forms.form-section title="Team Information">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <x-forms.form-input 
                name="name"
                label="Full Name"
                icon="user"
                placeholder="Enter team member's name"
                :required="true"
                col-span="lg:col-span-2" />

            <x-forms.form-input 
                name="category_id"
                label="Division"
                type="select"
                icon="folder"
                placeholder="Select division"
                :options="$categories->pluck('name', 'id')"
                :required="true"
                help="Select team division (category type: team)"
                col-span="lg:col-span-2" />

            <x-forms.form-input 
                name="description"
                label="Description"
                type="textarea"
                icon="file-text"
                placeholder="Short bio or role description..."
                :rows="4"
                col-span="lg:col-span-2" />
        </div>
    </x-forms.form-section>

    <!-- Profile Image -->
    <x-forms.form-section title="Profile Image">
        <div class="grid grid-cols-1 gap-6">
            <x-forms.form-input 
                name="image"
                label="Profile Picture"
                type="file"
                icon="image"
                accept="image/*"
                placeholder="Upload profile image"
                help="Recommended size: 400x400px (PNG or JPG up to 2MB)" />
        </div>
    </x-forms.form-section>

    <!-- Status Settings -->
    <x-forms.form-section title="Status Settings">
        <div class="grid grid-cols-1 gap-6">
            <x-forms.form-input 
                name="status"
                label="Status"
                type="select"
                icon="toggle-left"
                :options="[
                    1 => 'Active',
                    0 => 'Inactive'
                ]"
                value="1"
                :required="true" />
        </div>
    </x-forms.form-section>
</x-forms.crud-form>
@endsection

@push('scripts')
<script>
lucide.createIcons();
</script>
@endpush
