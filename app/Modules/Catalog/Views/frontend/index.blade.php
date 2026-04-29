@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Catalogs</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($catalogs as $catalog)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition">

                    <div class="p-6">
                        <h3 class="font-semibold text-lg text-gray-900">
                            <a href="{{ route('frontend.catalogs.show', $catalog) }}" class="hover:text-teal-600">
                                {{ $catalog->title }}
                            </a>
                        </h3>
                        <p class="text-gray-600 text-sm mt-2">{{ Str::limit(strip_tags($catalog->description), 100) }}</p>
                    </div>
        </div>
        @empty
        <div class="col-span-3 text-center py-12 text-gray-600">
            Belum ada data.
        </div>
        @endforelse
    </div>

    <div class="mt-8 flex justify-center">
        {{ $catalogs->links() }}
    </div>
</div>
@endsection
