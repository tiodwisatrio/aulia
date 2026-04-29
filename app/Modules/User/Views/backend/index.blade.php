@extends('core::dashboard-layout')

@section('content')
<div class="space-y-6">
        <!-- Header -->
    <div class="flex items-center justify-between gap-8">
        <!-- Left: Title, Description, Button -->
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Users</h1>
            <p class="text-gray-600 mt-1">Kelola semua pengguna sistem</p>
            <div class="mt-4">
                <a href="{{ route('users.create') }}" class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded-lg font-semibold transition inline-block">
                    + Tambah Users
                </a>
            </div>
        </div>

        <!-- Right: Search -->
        <div class="flex-shrink-0">
            <form method="GET" action="{{ route('users.index') }}" class="flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari users..."
                    class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                    Cari
                </button>
            </form>
        </div>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Nama</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Email</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Role</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Dibuat</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($users as $user)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4">
                        <span class="font-medium text-gray-900">{{ $user->name }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-gray-700">{{ $user->email }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-xs font-semibold px-3 py-1 rounded-full
                            @if($user->role === 'developer') bg-purple-100 text-purple-800
                            @elseif($user->role === 'super-admin') bg-red-100 text-red-800
                            @else bg-blue-100 text-blue-800
                            @endif">
                            {{ ucfirst(str_replace('-', ' ', $user->role)) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-600">
                        {{ $user->created_at->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex gap-2">
                            <a href="{{ route('users.edit', $user) }}" class="text-blue-600 hover:text-blue-900 font-semibold text-sm">Edit</a>
                            @if(auth()->user()->id !== $user->id)
                                <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 font-semibold text-sm" onclick="return confirm('Yakin ingin menghapus user ini?')">Hapus</button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-600">
                        Belum ada user. <a href="{{ route('users.create') }}" class="text-teal-600 hover:text-teal-900 font-semibold">Buat yang pertama</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="flex justify-center">
        {{ $users->links() }}
    </div>
</div>
@endsection
