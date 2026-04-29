@extends('core::dashboard-layout')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Tambah Setting</h1>
            <p class="text-gray-600 mt-1">Buat pengaturan sistem baru</p>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
        <form action="{{ route('settings.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Key -->
            <div>
                <label class="block text-sm font-semibold text-gray-900 mb-2">Key <span class="text-red-600">*</span></label>
                <input type="text" name="key" value="{{ old('key') }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 @error('key') border-red-500 @enderror"
                    placeholder="app_name">
                @error('key')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Label -->
            <div>
                <label class="block text-sm font-semibold text-gray-900 mb-2">Label</label>
                <input type="text" name="label" value="{{ old('label') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 @error('label') border-red-500 @enderror"
                    placeholder="Nama Aplikasi">
                @error('label')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Value -->
            <div>
                <label class="block text-sm font-semibold text-gray-900 mb-2">Nilai <span class="text-red-600">*</span></label>
                <textarea name="value" required rows="5"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 @error('value') border-red-500 @enderror"
                    placeholder="Masukkan nilai setting">{{ old('value') }}</textarea>
                @error('value')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Type -->
            <div>
                <label class="block text-sm font-semibold text-gray-900 mb-2">Tipe <span class="text-red-600">*</span></label>
                <select name="type" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                    <option value="">Pilih Tipe</option>
                    <option value="text" {{ old('type') === 'text' ? 'selected' : '' }}>Text</option>
                    <option value="number" {{ old('type') === 'number' ? 'selected' : '' }}>Number</option>
                    <option value="boolean" {{ old('type') === 'boolean' ? 'selected' : '' }}>Boolean</option>
                    <option value="file" {{ old('type') === 'file' ? 'selected' : '' }}>File</option>
                </select>
                @error('type')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Group -->
            <div>
                <label class="block text-sm font-semibold text-gray-900 mb-2">Grup <span class="text-red-600">*</span></label>
                <input type="text" name="group" value="{{ old('group', 'general') }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 @error('group') border-red-500 @enderror"
                    placeholder="general">
                @error('group')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-semibold text-gray-900 mb-2">Deskripsi</label>
                <textarea name="description" rows="3"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 @error('description') border-red-500 @enderror"
                    placeholder="Deskripsi atau penjelasan setting">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex gap-4 pt-4">
                <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                    Simpan Setting
                </button>
                <a href="{{ route('settings.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-900 px-6 py-2 rounded-lg font-semibold transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
