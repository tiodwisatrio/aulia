@extends('core::dashboard-layout')

@section('title', 'Our Values Management')

@section('content')
<div class="p-6">
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Our Values Management</h1>
            <p class="text-gray-600 mt-1">Manage company values and their display order</p>
        </div>
        <a href="{{ route('ourvalues.create') }}" class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-lg flex items-center transition-colors">
            <i data-lucide="plus" class="w-5 h-5 mr-2"></i>
            Add Value
        </a>
    </div>

    <!-- Flash Messages -->
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 mt-2">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                    <i data-lucide="award" class="w-5 h-5 text-blue-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Values</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $values->count() }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                    <i data-lucide="check-circle" class="w-5 h-5 text-green-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Active Values</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $values->where('status', 1)->count() }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                    <i data-lucide="x-circle" class="w-5 h-5 text-red-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Inactive Values</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $values->where('status', 0)->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Values Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Value List</h2>
        </div>
        @if($values->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($values as $value)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $value->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ Str::limit($value->description, 50) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($value->image)
                                <img src="{{ asset('storage/' . $value->image) }}" alt="{{ $value->name }}" class="h-12 w-12 rounded-lg object-cover">
                            @else
                                <div class="h-12 w-12 rounded-lg bg-gray-200 flex items-center justify-center">
                                    <i data-lucide="image" class="w-6 h-6 text-gray-400"></i>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($value->status == 1)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Active
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Inactive
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $value->order }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-3">
                                <a href="{{ route('ourvalues.edit', $value) }}" class="text-teal-600 hover:text-teal-900 transition-colors">
                                    <i data-lucide="edit" class="w-5 h-5"></i>
                                </a>
                                <form method="POST" action="{{ route('ourvalues.destroy', $value) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this value?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 transition-colors">
                                        <i data-lucide="trash-2" class="w-5 h-5"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="px-6 py-12 text-center">
            <i data-lucide="award" class="mx-auto h-12 w-12 text-gray-400"></i>
            <h3 class="mt-4 text-lg font-medium text-gray-900">No Values Found</h3>
            <p class="mt-2 text-gray-500">Get started by adding your first value.</p>
            <div class="mt-6">
                <a href="{{ route('ourvalues.create') }}" class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-lg inline-flex items-center transition-colors">
                    <i data-lucide="plus" class="w-5 h-5 mr-2"></i>
                    Add First Value
                </a>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    lucide.createIcons();
</script>
@endpush
