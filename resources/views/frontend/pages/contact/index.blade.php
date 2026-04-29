@extends('frontend.layouts.main')

@section('title', 'Contact')

@section('content')
<div class="bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Contact Us</h1>
            <p class="text-lg text-gray-600">Have a question? We'd love to hear from you. Send us a message and we'll respond as soon as possible.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Contact Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8">
                    @if(session('success'))
                        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6 flex items-center">
                            <i data-lucide="check-circle" class="w-5 h-5 mr-2"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('frontend.contacts.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Your Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 @error('name') border-red-500 @enderror">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Your Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 @error('email') border-red-500 @enderror">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Subject -->
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                                Subject <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="subject" 
                                   name="subject" 
                                   value="{{ old('subject') }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 @error('subject') border-red-500 @enderror">
                            @error('subject')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Message -->
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                                Message <span class="text-red-500">*</span>
                            </label>
                            <textarea id="message" 
                                      name="message" 
                                      rows="6"
                                      required
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 @error('message') border-red-500 @enderror">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" 
                                class="w-full px-6 py-3 bg-teal-600 hover:bg-teal-700 text-white font-semibold rounded-lg transition duration-200">
                            <i data-lucide="send" class="w-5 h-5 inline mr-2"></i>
                            Send Message
                        </button>
                    </form>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8">
                    <h3 class="text-xl font-semibold text-gray-900 mb-6">Get in Touch</h3>
                    
                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <i data-lucide="mail" class="w-6 h-6 text-teal-600"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">Email</p>
                                <p class="text-sm text-gray-600">info@example.com</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <i data-lucide="phone" class="w-6 h-6 text-teal-600"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">Phone</p>
                                <p class="text-sm text-gray-600">+1 (555) 123-4567</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <i data-lucide="map-pin" class="w-6 h-6 text-teal-600"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">Address</p>
                                <p class="text-sm text-gray-600">123 Main Street<br>City, State 12345</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 pt-8 border-t border-gray-200">
                        <p class="text-sm text-gray-600">We typically respond within 24 hours during business days.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    lucide.createIcons();
</script>
@endpush
