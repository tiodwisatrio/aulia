@extends('core::dashboard-layout')

@section('content')
<div class="space-y-6">
    <!-- Success Header -->
    <div class="bg-green-50 border border-green-200 rounded-xl p-8 text-center">
        <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-4">
            <i data-lucide="check-circle" class="w-8 h-8 text-green-600"></i>
        </div>
        <h1 class="text-3xl font-bold text-gray-900">Module Berhasil Dibuat!</h1>
        <p class="text-gray-600 mt-2">Module <strong>{{ $moduleName }}</strong> telah di-generate dengan sukses.</p>
    </div>

    <div class="grid grid-cols-2 gap-6">
        <!-- Files Created -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
            <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i data-lucide="folder" class="w-5 h-5 text-teal-600"></i>
                Files Yang Dibuat
            </h2>
            <div class="space-y-2 max-h-96 overflow-y-auto">
                @foreach($result['files'] as $file)
                <div class="flex items-start gap-2 text-sm">
                    <i data-lucide="file" class="w-4 h-4 text-gray-400 flex-shrink-0 mt-0.5"></i>
                    <code class="text-gray-700 break-all">{{ str_replace(base_path() . '/', '', str_replace('\\', '/', $file)) }}</code>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Info & Next Steps -->
        <div class="space-y-6">
            <!-- Module Info -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <i data-lucide="info" class="w-5 h-5 text-teal-600"></i>
                    Informasi Module
                </h2>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Module:</span>
                        <span class="font-semibold text-gray-900">{{ $result['module_name'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Tabel:</span>
                        <span class="font-semibold text-gray-900">{{ $result['table_name'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total Files:</span>
                        <span class="font-semibold text-gray-900">{{ count($result['files']) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Navigasi:</span>
                        <span class="font-semibold text-green-600">Ditambahkan</span>
                    </div>
                </div>
            </div>

            <!-- Run Migration -->
            <div class="bg-amber-50 border border-amber-200 rounded-xl p-8">
                <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <i data-lucide="database" class="w-5 h-5 text-amber-600"></i>
                    Jalankan Migration
                </h2>
                <p class="text-sm text-gray-700 mb-4">Klik tombol di bawah untuk membuat tabel <strong>{{ $result['table_name'] }}</strong> di database.</p>
                <form action="{{ route('module-generator.migrate') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full bg-amber-500 hover:bg-amber-600 text-white px-6 py-3 rounded-lg font-semibold transition flex items-center justify-center gap-2"
                        onclick="return confirm('Jalankan php artisan migrate?')">
                        <i data-lucide="play" class="w-5 h-5"></i>
                        Run Migration
                    </button>
                </form>
                <p class="text-gray-500 text-xs mt-3 text-center">Sama dengan <code class="bg-amber-100 px-1 rounded">php artisan migrate</code> di terminal</p>
            </div>

            <!-- After Migration -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <i data-lucide="list-checks" class="w-5 h-5 text-teal-600"></i>
                    Setelah Migration
                </h2>
                <ol class="space-y-3 text-sm text-gray-700">
                    <li class="flex items-start gap-2">
                        <span class="bg-green-100 text-green-800 rounded-full w-6 h-6 flex items-center justify-center flex-shrink-0 text-xs font-bold">✓</span>
                        <div>
                            <p class="font-semibold">Routes sudah terdaftar</p>
                            <p class="text-gray-500 text-xs mt-1">Module siap digunakan tanpa perlu restart server</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="bg-teal-100 text-teal-800 rounded-full w-6 h-6 flex items-center justify-center flex-shrink-0 text-xs font-bold">1</span>
                        <div>
                            <p class="font-semibold">Refresh halaman</p>
                            <p class="text-gray-500 text-xs mt-1">Menu sidebar akan muncul otomatis</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="bg-teal-100 text-teal-800 rounded-full w-6 h-6 flex items-center justify-center flex-shrink-0 text-xs font-bold">2</span>
                        <div>
                            <p class="font-semibold">Kustomisasi (opsional)</p>
                            <p class="text-gray-500 text-xs mt-1">Edit views, tambah relasi, sesuaikan validasi</p>
                        </div>
                    </li>
                </ol>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex gap-4">
        <a href="{{ route('module-generator.index') }}"
            class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded-lg font-semibold transition flex items-center gap-2">
            <i data-lucide="cpu" class="w-4 h-4"></i>
            Generate Module Lain
        </a>
        <a href="{{ route('dashboard') }}"
            class="bg-gray-300 hover:bg-gray-400 text-gray-900 px-6 py-2 rounded-lg font-semibold transition flex items-center gap-2">
            <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
            Ke Dashboard
        </a>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
</script>
@endpush

@endsection
