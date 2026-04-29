@extends('core::dashboard-layout')

@section('title', 'Navigation Management')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Navigation Management</h1>
            <p class="text-gray-600 mt-1">Drag to reorder navigation menu</p>
        </div>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Navigation List <span class="text-sm text-gray-500">(Drag to reorder)</span></h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-12">Order</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Label</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Route</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Icon</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="sortable-tbody">
                    @forelse($navigations as $nav)
                    <tr class="hover:bg-gray-50 cursor-move" data-id="{{ $nav->id }}">
                        <td class="px-6 py-4 text-sm text-gray-600">
                            <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 3h2v2H9V3zm0 4h2v2H9V7zm0 4h2v2H9v-2zm4-8h2v2h-2V3zm0 4h2v2h-2V7zm0 4h2v2h-2v-2z"/>
                            </svg>
                        </td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $nav->label }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $nav->route ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $nav->icon ?? '-' }}</td>
                        <td class="px-6 py-4">
                            <label class="flex items-center space-x-2 cursor-pointer">
                                <input type="checkbox" class="toggle-status rounded border-gray-300 text-teal-600 shadow-sm focus:border-teal-300 focus:ring focus:ring-teal-200" 
                                       data-id="{{ $nav->id }}" 
                                       {{ $nav->status ? 'checked' : '' }}>
                                <span class="text-sm text-gray-600">{{ $nav->status ? 'Active' : 'Inactive' }}</span>
                            </label>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <span class="text-gray-400">---</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">No navigations found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var tbody = document.getElementById('sortable-tbody');
    if (tbody) {
        Sortable.create(tbody, {
            animation: 150,
            ghostClass: 'bg-teal-50',
            onEnd: function (evt) {
                let ids = Array.from(tbody.children).map(row => row.dataset.id);
                fetch("{{ route('navigations.reorder') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ ids })
                }).then(response => response.json()).then(data => {
                    if (data.success) {
                        console.log('Navigation order updated');
                    }
                });
            }
        });
    }

    // Handle status toggle
    document.querySelectorAll('.toggle-status').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const navId = this.dataset.id;
            const status = this.checked ? 1 : 0;
            
            fetch("{{ route('navigations.index') }}" + '/' + navId, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ status })
            }).then(response => response.json()).then(data => {
                if (data.success) {
                    location.reload();
                }
            });
        });
    });
});
</script>
@endpush

@endsection
