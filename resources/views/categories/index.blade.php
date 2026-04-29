@extends('core::dashboard-layout')

@section('title', 'Categories Management')

@section('content')
<div class="p-6">

    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Categories Management</h1>
            <p class="text-gray-600 mt-1">Organize your content with categories</p>
        </div>
        <a href="{{ route('categories.create', ['type' => $type]) }}" 
           class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-lg flex items-center transition-colors">
            <i data-lucide="plus" class="w-5 h-5 mr-2"></i> Add Category
        </a>
    </div>


    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                    <i data-lucide="layers" class="w-5 h-5 text-blue-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Categories</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $categories->total() }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                    <i data-lucide="check-circle" class="w-5 h-5 text-green-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Active Categories</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $categories->where('is_active', 1)->count() }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                    <i data-lucide="x-circle" class="w-5 h-5 text-red-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Inactive Categories</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $categories->where('is_active', 0)->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
        <form method="GET" action="{{ route('categories.index') }}" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-[150px]">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search categories..." 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
            </div>
            <div class="min-w-[150px]">
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <input type="hidden" name="type" value="{{ $type }}">
            <button type="submit" class="px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white rounded-lg transition">
                <i data-lucide="search" class="w-4 h-4 inline mr-1"></i> Filter
            </button>
            <a href="{{ route('categories.index', ['type' => $type]) }}" 
               class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition">
               <i data-lucide="x" class="w-4 h-4 inline mr-1"></i> Reset
            </a>
        </form>
    </div>

    <!-- Categories Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($categories as $category)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $category->sort_order }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    @if($category->icon)
                                        <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center" 
                                             style="background-color: {{ $category->color ?? '#e5e7eb' }}15">
                                            <i data-lucide="{{ $category->icon }}" class="w-5 h-5" style="color: {{ $category->color ?? '#6b7280' }}"></i>
                                        </div>
                                    @endif
                                    <div class="{{ $category->icon ? 'ml-3' : '' }}">
                                        <div class="font-medium text-gray-900">{{ $category->name }}</div>
                                        @if($category->description)
                                            <div class="text-sm text-gray-500 line-clamp-1">{{ Str::limit($category->description, 50) }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $category->type === 'post' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $category->type === 'product' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $category->type === 'portfolio' ? 'bg-purple-100 text-purple-800' : '' }}
                                    {{ $category->type === 'team' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $category->type === 'general' ? 'bg-gray-100 text-gray-800' : '' }}">
                                    {{ ucfirst($category->type) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($category->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i data-lucide="check-circle" class="w-3 h-3 mr-1"></i> Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        <i data-lucide="x-circle" class="w-3 h-3 mr-1"></i> Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('categories.edit', $category) }}" class="text-teal-600 hover:text-teal-900 transition-colors" title="Edit">
                                        <i data-lucide="edit" class="w-4 h-4"></i>
                                    </a>
                                    <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 transition-colors" title="Delete">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                                <i data-lucide="folder-x" class="w-12 h-12 mb-3 mx-auto"></i>
                                <p class="text-lg font-medium">No categories found</p>
                                <p class="text-sm mt-1">Create a category to get started</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($categories->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $categories->appends(request()->all())->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>lucide.createIcons();</script>
@endpush
