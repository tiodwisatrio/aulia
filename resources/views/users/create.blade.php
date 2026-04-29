@extends('core::dashboard-layout')

@section('header', 'Create New User')

@section('content')
<div class="max-w-2xl mx-auto">
    <x-forms.crud-form
        title="Create New User"
        :action="route('users.store')"
        method="POST"
        submit-text="Create User"
        :cancel-url="route('users.index')">
        
        <x-forms.form-section title="User Information" description="Basic information about the user">
            <div class="grid grid-cols-1 gap-6">
                <x-forms.form-input
                    name="name"
                    label="Full Name"
                    type="text"
                    icon="user"
                    placeholder="Enter user's full name"
                    :required="true"
                    help="The display name for this user"
                    :value="old('name')" />

                <x-forms.form-input
                    name="email"
                    label="Email Address"
                    type="email"
                    icon="mail"
                    placeholder="user@example.com"
                    :required="true"
                    help="This will be used for login and notifications"
                    :value="old('email')" />
                    
                <x-forms.form-input
                    name="role"
                    label="User Role"
                    type="select"
                    icon="shield"
                    :required="true"
                    help="Select the appropriate role for this user"
                    :options="$availableRoles"
                    :value="old('role', 'admin')" />
            </div>
        </x-forms.form-section>

        <x-forms.form-section title="Security" description="Set up login credentials">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-forms.form-input
                    name="password"
                    label="Password"
                    type="password"
                    icon="lock"
                    placeholder="Enter secure password"
                    :required="true"
                    help="Minimum 8 characters" />

                <x-forms.form-input
                    name="password_confirmation"
                    label="Confirm Password"
                    type="password"
                    icon="lock"
                    placeholder="Confirm the password"
                    :required="true"
                    help="Must match the password above" />
            </div>
        </x-forms.form-section>

        <!-- Help Section -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-start">
                <i data-lucide="info" class="w-5 h-5 text-blue-500 mt-0.5 mr-3"></i>
                <div>
                    <h4 class="text-sm font-medium text-blue-800 mb-1">User Roles</h4>
                    <ul class="text-sm text-blue-700 space-y-1">
                        <li>• <strong>Developer</strong> - Full access to all features and user management</li>
                        <li>• <strong>Super Admin</strong> - Can manage content, settings, and admin users (but not Developers)</li>
                        <li>• <strong>Admin</strong> - Can manage content (posts, products, categories) only</li>
                        <li>• Users you can create depend on your role permissions</li>
                    </ul>
                </div>
            </div>
        </div>

    </x-forms.crud-form>
</div>
@endsection