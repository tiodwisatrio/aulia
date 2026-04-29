@extends('core::dashboard-layout')
@section('header', 'User Level')
@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-start justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Kelola Akses Modul</h1>
            <p class="text-gray-600 text-sm mt-2">Atur modul apa saja yang bisa diakses oleh setiap role. Developer selalu punya akses ke semua modul dan tidak bisa diubah.</p>
        </div>
    </div>

    <form action="{{ route('user-levels.update') }}" method="POST" id="permissionsForm">
        @csrf

        {{-- Main Card --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            {{-- Module Rows --}}
            <div class="divide-y divide-gray-100">
                @forelse($modules as $index => $mod)
                    @php
                        $perm        = $permissions->get($mod['name']);
                        $allowed     = $perm ? $perm->allowed_roles : ['admin', 'super_admin', 'developer'];
                        $hasAdmin    = in_array('admin', $allowed);
                        $hasSA       = in_array('super_admin', $allowed);
                        $rowBg       = $index % 2 == 0 ? 'bg-white' : 'bg-gray-50';
                    @endphp
                    <div class="{{ $rowBg }} hover:bg-blue-50 transition-colors duration-150 px-6 py-4 flex items-center gap-4">
                        {{-- Nama Modul --}}
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-gray-900">{{ $mod['label'] }}</p>
                            <p class="text-xs text-gray-400 font-mono mt-0.5">{{ $mod['name'] }}</p>
                        </div>

                        {{-- Role Checkboxes dengan Label --}}
                        <div class="flex items-center gap-6">
                            {{-- Admin --}}
                            <label class="flex items-center gap-2 cursor-pointer group">
                                <input type="checkbox"
                                    name="permissions[{{ $mod['name'] }}][roles][]"
                                    value="admin"
                                    {{ $hasAdmin ? 'checked' : '' }}
                                    class="w-5 h-5 text-blue-600 rounded border-gray-300 focus:ring-2 focus:ring-blue-500 cursor-pointer">
                                <span class="text-sm text-gray-700 group-hover:text-blue-600">Admin</span>
                            </label>

                            {{-- Super Admin --}}
                            <label class="flex items-center gap-2 cursor-pointer group">
                                <input type="checkbox"
                                    name="permissions[{{ $mod['name'] }}][roles][]"
                                    value="super_admin"
                                    {{ $hasSA ? 'checked' : '' }}
                                    class="w-5 h-5 text-red-500 rounded border-gray-300 focus:ring-2 focus:ring-red-400 cursor-pointer">
                                <span class="text-sm text-gray-700 group-hover:text-red-600">Super Admin</span>
                            </label>

                            {{-- Developer (Always Checked & Disabled) --}}
                            <div class="flex items-center gap-2 group">
                                <input type="checkbox"
                                    checked disabled
                                    class="w-5 h-5 text-purple-600 rounded border-gray-300 cursor-not-allowed opacity-100">
                                <input type="hidden" name="permissions[{{ $mod['name'] }}][roles][]" value="developer">
                                <span class="text-sm text-gray-500 cursor-not-allowed" title="Developer selalu punya akses">Developer</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-12 text-center">
                        <i data-lucide="inbox" class="w-12 h-12 text-gray-300 mx-auto mb-3"></i>
                        <p class="text-gray-500 text-sm">Belum ada modul yang terdaftar</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Info Box --}}
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4 flex gap-3">
            <i data-lucide="info" class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5"></i>
            <div class="text-sm text-blue-800">
                <p class="font-semibold mb-1">Cara Kerja:</p>
                <ul class="text-xs space-y-1 text-blue-700">
                    <li>✓ Centang untuk memberikan akses, hapus centang untuk membatasi</li>
                    <li>✓ Developer <strong>selalu</strong> mendapat akses ke semua modul</li>
                    <li>✓ Perubahan akan langsung diterapkan setelah menyimpan</li>
                </ul>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="mt-6 flex gap-3 items-center">
            <button type="submit"
                class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2.5 rounded-lg font-semibold transition flex items-center gap-2 shadow-sm hover:shadow">
                <i data-lucide="save" class="w-4 h-4"></i>
                Simpan Pengaturan
            </button>

            <button type="button" onclick="resetAllToDefault()"
                class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2.5 rounded-lg font-semibold transition flex items-center gap-2">
                <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                Reset ke Default
            </button>

            <div class="ml-auto">
                <button type="button" onclick="selectAllRoles()"
                    class="bg-blue-50 hover:bg-blue-100 text-blue-700 px-5 py-2.5 rounded-lg font-semibold transition text-sm flex items-center gap-2">
                    <i data-lucide="check-square" class="w-4 h-4"></i>
                    Centang Semua
                </button>
            </div>
        </div>
    </form>
</div>

<script>
function resetAllToDefault() {
    if (!confirm('Atur ulang semua modul agar bisa diakses oleh semua role (Admin, Super Admin, Developer)?')) return;

    document.querySelectorAll('input[type="checkbox"]:not([disabled])').forEach(cb => {
        cb.checked = true;
    });
}

function selectAllRoles() {
    document.querySelectorAll('input[type="checkbox"]:not([disabled])').forEach(cb => {
        cb.checked = true;
    });
}

document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
});
</script>
@endsection
