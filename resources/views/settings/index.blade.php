@extends('core::dashboard-layout')

@section('header')
    General Settings
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">General Settings</h2>
        <p class="text-gray-600 mt-1">Manage your website general settings</p>
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

    <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        @foreach($settings as $groupName => $groupSettings)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center capitalize">
                    @if($groupName === 'general')
                        <i data-lucide="settings" class="w-5 h-5 mr-2 text-teal-600"></i>
                    @elseif($groupName === 'email')
                        <i data-lucide="mail" class="w-5 h-5 mr-2 text-teal-600"></i>
                    @else
                        <i data-lucide="folder" class="w-5 h-5 mr-2 text-teal-600"></i>
                    @endif
                    {{ ucfirst($groupName) }} Settings
                </h3>

                <div class="space-y-4">
                    @foreach($groupSettings as $setting)
                        <div>
                            <label for="{{ $setting->key }}" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ $setting->label }}
                                @if($setting->description)
                                    <span class="text-xs text-gray-500 font-normal">({{ $setting->description }})</span>
                                @endif
                            </label>

                            @if($setting->type === 'text')
                                <input type="text"
                                       id="{{ $setting->key }}"
                                       name="settings[{{ $setting->key }}]"
                                       value="{{ old('settings.'.$setting->key, $setting->value) }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">

                            @elseif($setting->type === 'textarea')
                                <textarea id="{{ $setting->key }}"
                                          name="settings[{{ $setting->key }}]"
                                          rows="3"
                                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">{{ old('settings.'.$setting->key, $setting->value) }}</textarea>

                            @elseif($setting->type === 'file')
                                <div class="space-y-2">
                                    @if($setting->value)
                                        <div class="mb-3">
                                            <p class="text-sm text-gray-600 mb-2">Current Logo:</p>
                                            <img src="{{ asset('storage/' . $setting->value) }}"
                                                 alt="Current logo"
                                                 class="h-20 w-auto border border-gray-300 rounded-lg p-2 bg-white">
                                        </div>
                                    @endif
                                    <input type="file"
                                           id="{{ $setting->key }}"
                                           name="settings[{{ $setting->key }}]"
                                           accept="image/*"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                                    <p class="text-xs text-gray-500">Recommended: PNG or SVG format, max 2MB</p>
                                </div>

                            @elseif($setting->type === 'select')
                                <select id="{{ $setting->key }}"
                                        name="settings[{{ $setting->key }}]"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                                    <!-- Add options based on your requirements -->
                                </select>
                            @endif

                            @error('settings.'.$setting->key)
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        <!-- Actions -->
        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('dashboard') }}"
               class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition">
                <i data-lucide="x" class="w-4 h-4 inline mr-1"></i>
                Cancel
            </a>
            <button type="submit"
                    class="px-6 py-2 bg-teal-600 hover:bg-teal-700 text-white rounded-lg transition">
                <i data-lucide="save" class="w-4 h-4 inline mr-1"></i>
                Save Settings
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    lucide.createIcons();
</script>
@endpush
