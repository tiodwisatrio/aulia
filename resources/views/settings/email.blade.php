@extends('core::dashboard-layout')

@section('header')
    Email Settings
@endsection

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Email Settings</h2>
        <p class="text-gray-600 mt-1">Configure SMTP settings for sending emails</p>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6 flex items-center">
            <i data-lucide="check-circle" class="w-5 h-5 mr-2"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-6 flex items-center">
            <i data-lucide="alert-circle" class="w-5 h-5 mr-2"></i>
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('settings.email.update') }}" method="POST" class="space-y-6">
        @csrf

        <!-- SMTP Configuration -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <i data-lucide="server" class="w-5 h-5 mr-2 text-teal-600"></i>
                SMTP Configuration
            </h3>

            <div class="space-y-4">
                <!-- SMTP Host -->
                <div>
                    <label for="smtp_host" class="block text-sm font-medium text-gray-700 mb-2">
                        SMTP Host <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="smtp_host" 
                           name="smtp_host" 
                           value="{{ old('smtp_host', $settings['smtp_host']->value ?? '') }}"
                           placeholder="smtp.gmail.com"
                           required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                    @error('smtp_host')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- SMTP Port -->
                <div>
                    <label for="smtp_port" class="block text-sm font-medium text-gray-700 mb-2">
                        SMTP Port <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           id="smtp_port" 
                           name="smtp_port" 
                           value="{{ old('smtp_port', $settings['smtp_port']->value ?? '587') }}"
                           placeholder="587"
                           required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                    @error('smtp_port')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- SMTP Encryption -->
                <div>
                    <label for="smtp_encryption" class="block text-sm font-medium text-gray-700 mb-2">
                        SMTP Encryption <span class="text-red-500">*</span>
                    </label>
                    <select id="smtp_encryption" 
                            name="smtp_encryption" 
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                        <option value="tls" {{ old('smtp_encryption', $settings['smtp_encryption']->value ?? 'tls') == 'tls' ? 'selected' : '' }}>TLS</option>
                        <option value="ssl" {{ old('smtp_encryption', $settings['smtp_encryption']->value ?? 'tls') == 'ssl' ? 'selected' : '' }}>SSL</option>
                    </select>
                    @error('smtp_encryption')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- SMTP Username -->
                <div>
                    <label for="smtp_username" class="block text-sm font-medium text-gray-700 mb-2">
                        SMTP Username <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="smtp_username" 
                           name="smtp_username" 
                           value="{{ old('smtp_username', $settings['smtp_username']->value ?? '') }}"
                           placeholder="your-email@gmail.com"
                           required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                    @error('smtp_username')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- SMTP Password -->
                <div>
                    <label for="smtp_password" class="block text-sm font-medium text-gray-700 mb-2">
                        SMTP Password
                    </label>
                    <input type="password" 
                           id="smtp_password" 
                           name="smtp_password" 
                           placeholder="Leave empty to keep current password"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                    <p class="mt-1 text-xs text-gray-500">Leave empty if you don't want to change the password</p>
                    @error('smtp_password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Sender Information -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <i data-lucide="user" class="w-5 h-5 mr-2 text-teal-600"></i>
                Sender Information
            </h3>

            <div class="space-y-4">
                <!-- From Email -->
                <div>
                    <label for="mail_from_address" class="block text-sm font-medium text-gray-700 mb-2">
                        From Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" 
                           id="mail_from_address" 
                           name="mail_from_address" 
                           value="{{ old('mail_from_address', $settings['mail_from_address']->value ?? '') }}"
                           placeholder="noreply@example.com"
                           required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                    @error('mail_from_address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- From Name -->
                <div>
                    <label for="mail_from_name" class="block text-sm font-medium text-gray-700 mb-2">
                        From Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="mail_from_name" 
                           name="mail_from_name" 
                           value="{{ old('mail_from_name', $settings['mail_from_name']->value ?? '') }}"
                           placeholder="Your Company Name"
                           required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                    @error('mail_from_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-end gap-3">
            <button type="submit" 
                    class="px-6 py-2 bg-teal-600 hover:bg-teal-700 text-white rounded-lg transition">
                <i data-lucide="save" class="w-4 h-4 inline mr-1"></i>
                Save Settings
            </button>
        </div>
    </form>

    <!-- Test Email Section -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mt-6">
        <h3 class="text-lg font-semibold text-blue-900 mb-4 flex items-center">
            <i data-lucide="send" class="w-5 h-5 mr-2"></i>
            Test Email Configuration
        </h3>
        <form action="{{ route('settings.email.test') }}" method="POST" class="flex gap-3">
            @csrf
            <input type="email" 
                   name="test_email" 
                   placeholder="Enter test email address"
                   required
                   class="flex-1 px-4 py-2 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            <button type="submit" 
                    class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                Send Test Email
            </button>
        </form>
        <p class="text-sm text-blue-700 mt-2">Send a test email to verify your SMTP configuration</p>
    </div>
</div>
@endsection

@push('scripts')
<script>
    lucide.createIcons();
</script>
@endpush
