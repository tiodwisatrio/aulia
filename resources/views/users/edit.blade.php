@extends('core::dashboard-layout')

@section('header', 'Edit User')

@section('content')
<div class="max-w-2xl mx-auto">
    <x-forms.crud-form
        title="Edit User: {{ $user->name }}"
        :action="route('users.update', $user)"
        method="PUT"
        submit-text="Update User"
        :cancel-url="route('users.index')"
        :model="$user">
        
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
                    :value="old('name', $user->name)" />

                <x-forms.form-input
                    name="email"
                    label="Email Address"
                    type="email"
                    icon="mail"
                    placeholder="user@example.com"
                    :required="true"
                    help="This will be used for login and notifications"
                    :value="old('email', $user->email)" />
                    
                @can('modify-user', $user)
                    <x-forms.form-input
                        name="role"
                        label="User Role"
                        type="select"
                        icon="shield"
                        :required="true"
                        help="Select the appropriate role for this user"
                        :options="$availableRoles"
                        :value="old('role', $user->role ?? 'admin')" />
                @else
                    <!-- Users without permission can't change role -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i data-lucide="shield" class="w-4 h-4 inline mr-1"></i>
                            User Role
                        </label>
                        <div class="px-3 py-2 bg-gray-50 border border-gray-300 rounded-md text-sm text-gray-600">
                            {{ str_replace('_', ' ', ucwords($user->role, '_')) }}
                        </div>
                        <input type="hidden" name="role" value="{{ $user->role }}">
                        <p class="mt-1 text-sm text-gray-500">You don't have permission to change this user's role</p>
                    </div>
                @endcan
            </div>
        </x-forms.form-section>

        <x-forms.form-section title="Security" description="Update password (leave blank to keep current password)">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-forms.form-input
                    name="password"
                    label="New Password"
                    type="password"
                    icon="lock"
                    placeholder="Enter new password (optional)"
                    :required="false"
                    help="Leave blank to keep current password" />

                <x-forms.form-input
                    name="password_confirmation"
                    label="Confirm New Password"
                    type="password"
                    icon="lock"
                    placeholder="Confirm the new password"
                    :required="false"
                    help="Must match the new password above" />
            </div>
        </x-forms.form-section>

        <!-- User Stats Section -->
        <x-forms.form-section title="User Statistics" description="Account activity and information">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="flex items-center mb-2">
                        <i data-lucide="calendar" class="w-4 h-4 text-gray-500 mr-2"></i>
                        <span class="text-sm font-medium text-gray-700">Account Created</span>
                    </div>
                    <p class="text-sm text-gray-600">{{ $user->created_at->format('M d, Y') }}</p>
                    <p class="text-xs text-gray-500">{{ $user->created_at->diffForHumans() }}</p>
                </div>
                
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="flex items-center mb-2">
                        <i data-lucide="activity" class="w-4 h-4 text-gray-500 mr-2"></i>
                        <span class="text-sm font-medium text-gray-700">Last Updated</span>
                    </div>
                    <p class="text-sm text-gray-600">{{ $user->updated_at->format('M d, Y') }}</p>
                    <p class="text-xs text-gray-500">{{ $user->updated_at->diffForHumans() }}</p>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="flex items-center mb-2">
                        <i data-lucide="check-circle" class="w-4 h-4 text-gray-500 mr-2"></i>
                        <span class="text-sm font-medium text-gray-700">Email Status</span>
                    </div>
                    @if($user->email_verified_at)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <i data-lucide="check" class="w-3 h-3 mr-1"></i>
                            Verified
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            <i data-lucide="clock" class="w-3 h-3 mr-1"></i>
                            Pending Verification
                        </span>
                    @endif
                </div>

                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="flex items-center mb-2">
                        <i data-lucide="file-text" class="w-4 h-4 text-gray-500 mr-2"></i>
                        <span class="text-sm font-medium text-gray-700">Content Created</span>
                    </div>
                    <p class="text-sm text-gray-600">
                        {{ $user->posts()->count() }} Posts, 
                        {{ $user->products()->count() }} Products
                    </p>
                </div>
            </div>
        </x-forms.form-section>

        <!-- Warning for Role Changes -->
        @if($user->isDeveloper())
            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex items-start">
                    <i data-lucide="alert-triangle" class="w-5 h-5 text-red-500 mt-0.5 mr-3"></i>
                    <div>
                        <h4 class="text-sm font-medium text-red-800 mb-1">Developer Account</h4>
                        <p class="text-sm text-red-700">
                            This user has Developer privileges - full system access. Only other Developers can modify this account.
                        </p>
                    </div>
                </div>
            </div>
        @elseif($user->isSuperAdmin())
            <div class="bg-amber-50 border border-amber-200 rounded-lg p-4">
                <div class="flex items-start">
                    <i data-lucide="alert-triangle" class="w-5 h-5 text-amber-500 mt-0.5 mr-3"></i>
                    <div>
                        <h4 class="text-sm font-medium text-amber-800 mb-1">Super Admin Account</h4>
                        <p class="text-sm text-amber-700">
                            This user has Super Admin privileges. They can manage content, settings, and other Admin users.
                        </p>
                    </div>
                </div>
            </div>
        @endif

    </x-forms.crud-form>
</div>
@endsection