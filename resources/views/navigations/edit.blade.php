@extends('core::dashboard-layout')

@section('title', 'Edit Navigation')

@section('content')
<div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow">
    <h1 class="text-2xl font-bold mb-6">Edit Navigation</h1>
    <form action="{{ route('navigations.update', $navigation) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Label</label>
            <input type="text" name="label" value="{{ old('label', $navigation->label) }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-teal-500 focus:border-teal-500" placeholder="Navigation label" required>
            @error('label')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Route</label>
            <input type="text" name="route" value="{{ old('route', $navigation->route) }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-teal-500 focus:border-teal-500" placeholder="e.g., dashboard or abouts.index">
            @error('route')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Icon (Lucide Icon)</label>
            <input type="text" name="icon" value="{{ old('icon', $navigation->icon) }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-teal-500 focus:border-teal-500" placeholder="e.g., home, settings, users">
            @error('icon')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>
        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Status</label>
            <select name="status" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-teal-500 focus:border-teal-500">
                <option value="1" {{ old('status', $navigation->status) == 1 ? 'selected' : '' }}>Active</option>
                <option value="0" {{ old('status', $navigation->status) == 0 ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
        <div class="flex justify-end">
            <a href="{{ route('navigations.index') }}" class="mr-4 px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Cancel</a>
            <button type="submit" class="px-4 py-2 bg-teal-600 text-white rounded hover:bg-teal-700">Update</button>
        </div>
    </form>
</div>
@endsection
