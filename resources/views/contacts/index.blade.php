@extends('core::dashboard-layout')

@section('header')
    Contact Messages
@endsection

@section('content')
<div class="mb-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Contact Messages</h2>
            <p class="text-gray-600 mt-1">Manage messages from visitors</p>
        </div>
        @if($newCount > 0)
            <span class="px-4 py-2 bg-blue-100 text-blue-800 rounded-lg font-semibold">
                {{ $newCount }} New {{ Str::plural('Message', $newCount) }}
            </span>
        @endif
    </div>
</div>

<!-- Filters -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
    <form method="GET" action="{{ route('contacts.index') }}" class="flex flex-wrap gap-4">
        <!-- Search -->
        <div class="flex-1 min-w-[200px]">
            <input type="text" 
                   name="search" 
                   value="{{ request('search') }}"
                   placeholder="Search messages..." 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
        </div>

        <!-- Status Filter -->
        <div class="min-w-[150px]">
            <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                <option value="all" {{ request('status') === 'all' ? 'selected' : '' }}>All Status</option>
                <option value="new" {{ request('status') === 'new' ? 'selected' : '' }}>New</option>
                <option value="read" {{ request('status') === 'read' ? 'selected' : '' }}>Read</option>
                <option value="replied" {{ request('status') === 'replied' ? 'selected' : '' }}>Replied</option>
            </select>
        </div>

        <button type="submit" class="px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white rounded-lg transition">
            <i data-lucide="search" class="w-4 h-4 inline mr-1"></i> Filter
        </button>
        <a href="{{ route('contacts.index') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition">
            <i data-lucide="x" class="w-4 h-4 inline mr-1"></i> Reset
        </a>
    </form>
</div>

<!-- Messages -->
@if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6 flex items-center">
        <i data-lucide="check-circle" class="w-5 h-5 mr-2"></i>
        {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">From</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subject</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($messages as $message)
                    <tr class="hover:bg-gray-50 {{ $message->isNew() ? 'bg-blue-50' : '' }}">
                        <td class="px-6 py-4 whitespace-nowrap">
                            {!! $message->status_badge !!}
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-900">{{ $message->name }}</div>
                            <div class="text-sm text-gray-500">{{ $message->email }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-gray-900">{{ Str::limit($message->subject, 50) }}</div>
                            <div class="text-sm text-gray-500">{{ Str::limit($message->message, 60) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $message->created_at->format('M d, Y') }}<br>
                            <span class="text-xs">{{ $message->created_at->format('H:i') }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('contacts.show', $message) }}" 
                                   class="text-teal-600 hover:text-teal-900" title="View">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </a>
                                <form action="{{ route('contacts.destroy', $message) }}" 
                                      method="POST" 
                                      class="inline"
                                      onsubmit="return confirm('Delete this message?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" title="Delete">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <i data-lucide="inbox" class="w-12 h-12 mx-auto text-gray-400 mb-3"></i>
                            <p class="text-gray-500">No messages found</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($messages->hasPages())
        <div class="px-6 py-4 border-t">
            {{ $messages->links() }}
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    lucide.createIcons();
</script>
@endpush
