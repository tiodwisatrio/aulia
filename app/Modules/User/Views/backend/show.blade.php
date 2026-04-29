@extends('core::dashboard-layout')
@section('header', 'Detail User')
@section('content')
<div class="space-y-6">
    <div class="flex items-center gap-3">
        <a href="{{ route('users.index') }}" class="text-gray-500 hover:text-gray-700">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <h1 class="text-2xl font-bold text-gray-900">Detail User</h1>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 max-w-lg space-y-4">
        <div>
            <p class="text-xs text-gray-500 mb-0.5">Nama</p>
            <p class="font-medium text-gray-900">{{ $user->name }}</p>
        </div>
        <div>
            <p class="text-xs text-gray-500 mb-0.5">Email</p>
            <p class="text-gray-700">{{ $user->email }}</p>
        </div>
        <div>
            <p class="text-xs text-gray-500 mb-0.5">Role</p>
            <span class="text-xs font-semibold px-3 py-1 rounded-full
                @if($user->role === 'developer') bg-purple-100 text-purple-800
                @elseif($user->role === 'super_admin') bg-red-100 text-red-800
                @else bg-blue-100 text-blue-800
                @endif">
                {{ ucfirst(str_replace('_', ' ', $user->role)) }}
            </span>
        </div>
        <div>
            <p class="text-xs text-gray-500 mb-0.5">Dibuat</p>
            <p class="text-gray-700">{{ $user->created_at->format('d M Y, H:i') }}</p>
        </div>
        <div class="flex gap-3 pt-2">
            @can('modify-user', $user)
            <a href="{{ route('users.edit', $user) }}" class="bg-teal-600 hover:bg-teal-700 text-white px-5 py-2 rounded-lg text-sm font-semibold transition">
                Edit
            </a>
            @endcan
            <a href="{{ route('users.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2 rounded-lg text-sm font-semibold transition">
                Kembali
            </a>
        </div>
    </div>
</div>
@endsection
