<div class="border-b pb-6">
    <div class="mb-4">
        <h2 class="text-lg font-semibold text-gray-900">{{ $title }}</h2>
        @if($description)
            <p class="text-sm text-gray-600 mt-1">{{ $description }}</p>
        @endif
    </div>
    
    <div class="space-y-6">
        {{ $slot }}
    </div>
</div>