@extends('core::dashboard-layout')

@section('header')
    Contact Message
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Breadcrumb -->
    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-gray-600 mb-2">
            <a href="{{ route('contacts.index') }}" class="hover:text-teal-600">Contact Messages</a>
            <i data-lucide="chevron-right" class="w-4 h-4"></i>
            <span class="text-gray-900">Message Details</span>
        </div>
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

    <!-- Message Details -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <div class="flex items-start justify-between mb-6">
            <div class="flex-1">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $contact->subject }}</h2>
                <div class="flex items-center gap-4 text-sm text-gray-600">
                    <span><i data-lucide="user" class="w-4 h-4 inline"></i> {{ $contact->name }}</span>
                    <span><i data-lucide="mail" class="w-4 h-4 inline"></i> {{ $contact->email }}</span>
                    <span><i data-lucide="calendar" class="w-4 h-4 inline"></i> {{ $contact->created_at->format('M d, Y H:i') }}</span>
                </div>
            </div>
            <div>
                {!! $contact->status_badge !!}
            </div>
        </div>

        <div class="border-t pt-6">
            <h3 class="font-semibold text-gray-900 mb-3">Message:</h3>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-gray-700 whitespace-pre-wrap">{{ $contact->message }}</p>
            </div>
        </div>

        @if($contact->ip_address)
            <div class="mt-4 text-xs text-gray-500">
                IP Address: {{ $contact->ip_address }}
            </div>
        @endif
    </div>

    <!-- Admin Reply Section -->
    @if($contact->isReplied())
        <div class="bg-green-50 border border-green-200 rounded-lg p-6 mb-6">
            <div class="flex items-center justify-between mb-3">
                <h3 class="font-semibold text-green-900">Your Reply:</h3>
                <span class="text-sm text-green-700">Sent {{ $contact->replied_at->diffForHumans() }}</span>
            </div>
            <div class="bg-white p-4 rounded">
                <p class="text-gray-700 whitespace-pre-wrap">{{ $contact->admin_reply }}</p>
            </div>
        </div>
    @else
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Send Reply</h3>
            <form action="{{ route('contacts.reply', $contact) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="reply_message" class="block text-sm font-medium text-gray-700 mb-2">
                        Your Reply <span class="text-red-500">*</span>
                    </label>
                    <textarea id="reply_message" 
                              name="reply_message" 
                              rows="8"
                              required
                              placeholder="Type your reply here..."
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 @error('reply_message') border-red-500 @enderror">{{ old('reply_message') }}</textarea>
                    @error('reply_message')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-sm text-gray-500">
                        This reply will be sent to <strong>{{ $contact->email }}</strong>
                    </p>
                </div>

                <div class="flex items-center justify-between">
                    <a href="{{ route('contacts.index') }}" 
                       class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                        Back to Messages
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-teal-600 hover:bg-teal-700 text-white rounded-lg transition">
                        <i data-lucide="send" class="w-4 h-4 inline mr-1"></i>
                        Send Reply
                    </button>
                </div>
            </form>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    lucide.createIcons();
</script>
@endpush
