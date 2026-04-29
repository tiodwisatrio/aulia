
@extends('core::dashboard-layout')

@section('header')
    Edit Our Value
@endsection

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Value</h2>
    <form action="{{ route('ourvalues.update', $ourvalue) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 space-y-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name', $ourvalue->name) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea name="description" id="description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">{{ old('description', $ourvalue->description) }}</textarea>
                @error('description')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Image</label>
                @if($ourvalue->image)
                    <img src="{{ asset('storage/' . $ourvalue->image) }}" alt="Image" class="w-16 h-16 object-cover rounded mb-2">
                @endif
                <input type="file" name="image" id="image" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                @error('image')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                <div class="mt-4 hidden relative" id="image-preview-container">
                    <p class="text-sm text-gray-600 mb-2 font-medium">Image Preview:</p>
                    <button type="button" id="remove-preview" class="absolute top-0 right-0 text-white bg-red-600 hover:bg-red-700 rounded-full w-6 h-6 flex items-center justify-center text-xs font-bold shadow">×</button>
                    <img id="image-preview" src="#" alt="Preview" class="max-h-48 rounded-lg border border-gray-200 shadow-sm object-contain">
                </div>
            </div>
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select name="status" id="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="1" {{ old('status', $ourvalue->status) == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('status', $ourvalue->status) == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="order" class="block text-sm font-medium text-gray-700 mb-2">Order</label>
                <input type="number" name="order" id="order" value="{{ old('order', $ourvalue->order) }}" min="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                @error('order')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>
        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('ourvalues.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-200">Cancel</a>
            <button type="submit" class="px-6 py-2 bg-teal-600 hover:bg-teal-700 text-white rounded-lg transition duration-200">
                <i data-lucide="save" class="w-4 h-4 inline mr-1"></i> Update Value
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    lucide.createIcons();
    document.addEventListener("DOMContentLoaded", function () {
        const imageInput = document.querySelector('input[name="image"]');
        const previewContainer = document.getElementById('image-preview-container');
        const previewImage = document.getElementById('image-preview');
        const removeBtn = document.getElementById('remove-preview');
        if (imageInput) {
            imageInput.addEventListener('change', function (e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (event) {
                        previewImage.src = event.target.result;
                        previewContainer.classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                } else {
                    previewImage.src = '#';
                    previewContainer.classList.add('hidden');
                }
            });
            removeBtn.addEventListener('click', function () {
                imageInput.value = '';
                previewImage.src = '#';
                previewContainer.classList.add('hidden');
            });
        }
    });
</script>
@endpush
