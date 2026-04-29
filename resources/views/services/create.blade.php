@extends('core::dashboard-layout')

@section('title', 'Add Service')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white shadow-sm border border-gray-200 rounded-lg p-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Add New Service</h1>

        <form action="{{ route('services.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- Name --}}
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Name <span class="text-red-500">*</span></label>
                <input type="text" 
                       name="name" 
                       value="{{ old('name') }}" 
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                       placeholder="Enter service name"
                       required>
            </div>

            {{-- Description --}}
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Description</label>
                <textarea name="description" 
                          rows="4" 
                          class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                          placeholder="Write a short description...">{{ old('description') }}</textarea>
            </div>

            {{-- Image --}}
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Image</label>
                <input type="file" 
                       name="image" 
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                <p class="text-sm text-gray-500 mt-1">Recommended size: 600x400px</p>
            </div>

            {{-- Status & Order --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Status</label>
                    <select name="status" 
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                        <option value="1" selected>Aktif</option>
                        <option value="0">Tidak Aktif</option>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Order</label>
                    <input type="number" 
                           name="order" 
                           value="{{ old('order') }}" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                           placeholder="e.g. 1">
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex justify-end space-x-3 pt-4">
                <a href="{{ route('services.index') }}" 
                   class="px-5 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-lg transition">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-5 py-2 bg-teal-600 hover:bg-teal-700 text-white rounded-lg transition">
                    Save Service
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
