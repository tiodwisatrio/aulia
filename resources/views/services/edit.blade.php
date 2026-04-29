@extends('core::dashboard-layout')

@section('title', 'Edit Service')

@section('content')
<div class="p-6 max-w-3xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Service</h1>

    <form action="{{ route('services.update', $service) }}" method="POST" enctype="multipart/form-data" class="space-y-6 bg-white p-6 rounded-lg shadow-sm border border-gray-200">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-gray-700 font-medium mb-2">Name</label>
            <input type="text" name="name" value="{{ old('name', $service->name) }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-teal-500 focus:border-teal-500" required>
        </div>

        <div>
            <label class="block text-gray-700 font-medium mb-2">Description</label>
            <textarea name="description" rows="4" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-teal-500 focus:border-teal-500">{{ old('description', $service->description) }}</textarea>
        </div>

        <div>
            <label class="block text-gray-700 font-medium mb-2">Current Image</label>
            @if($service->image)
                <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" class="h-24 w-24 object-cover rounded-lg mb-2">
            @else
                <p class="text-gray-500 text-sm mb-2">No image uploaded.</p>
            @endif
            <input type="file" name="image" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-teal-500 focus:border-teal-500">
        </div>

        <div class="grid grid-cols-2 gap-6">
            <div>
                <label class="block text-gray-700 font-medium mb-2">Status</label>
                <select name="status" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-teal-500 focus:border-teal-500">
                    <option value="1" {{ $service->status == 1 ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ $service->status == 0 ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-2">Order</label>
                <input type="number" name="order" value="{{ old('order', $service->order) }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-teal-500 focus:border-teal-500">
            </div>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('services.index') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg">Cancel</a>
            <button type="submit" class="px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white rounded-lg">Update</button>
        </div>
    </form>
</div>
@endsection
