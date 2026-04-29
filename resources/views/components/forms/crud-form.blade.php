<div class="max-w-4xl mx-auto">
    <div class="bg-white p-8 rounded-lg shadow">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-900">{{ $title }}</h1>
            <a href="{{ $cancelUrl }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition duration-200">
                <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                Back
            </a>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                <div class="flex items-start">
                    <i data-lucide="alert-circle" class="w-5 h-5 mr-3 mt-0.5 flex-shrink-0"></i>
                    <div>
                        <h3 class="font-semibold">Please fix the following errors:</h3>
                        <ul class="list-disc list-inside mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Form -->
        <form action="{{ $action }}" 
              method="POST" 
              @if($enctype) enctype="{{ $enctype }}" @endif 
              class="space-y-6">
            @csrf
            @if($method !== 'POST')
                @method($method)
            @endif
            
            <!-- Form Content Slot -->
            {{ $slot }}

            <!-- Action Buttons -->
            <div class="flex justify-end gap-4 pt-4 border-t">
                <a href="{{ $cancelUrl }}" 
                   class="inline-flex items-center px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-200">
                    <i data-lucide="x" class="w-4 h-4 mr-2"></i>
                    Cancel
                </a>
                <button type="submit" 
                        class="inline-flex items-center px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200 font-medium">
                    <i data-lucide="save" class="w-4 h-4 mr-2"></i>
                    {{ $submitText }}
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
// Initialize Lucide icons
lucide.createIcons();
</script>
@endpush