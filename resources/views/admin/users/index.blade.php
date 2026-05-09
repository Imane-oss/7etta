@extends('admin.layout')

@section('title', 'Users Management')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Users Management</h1>
    
    <form method="GET" action="{{ route('admin.users') }}" class="relative w-64">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search user..." class="w-full border border-gray-300 rounded-md pl-10 pr-4 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-black focus:border-black bg-white">
        <i class="bi bi-search absolute left-3 top-2.5 text-gray-400"></i>
    </form>
</div>

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
@endif
@if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('error') }}</span>
    </div>
@endif

<!-- Users Table -->
<div class="glass-card overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="border-b border-gray-200 bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                <th class="p-4 pl-6">User</th>
                <th class="p-4">Email</th>
                <th class="p-4">Role</th>
                <th class="p-4">Status</th>
                <th class="p-4 pr-6 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($users as $user)
            @php
                $initials = strtoupper(collect(explode(' ', $user->name))->map(fn($n) => substr($n, 0, 1))->take(2)->implode(''));
            @endphp
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="p-4 pl-6 flex items-center">
                    @if($user->role === 'admin')
                    <div class="h-8 w-8 rounded-full bg-black text-white flex items-center justify-center font-bold text-xs mr-3">{{ $initials }}</div>
                    <span class="font-medium text-black text-sm">{{ $user->name }}</span>
                    @else
                    <div class="h-8 w-8 rounded-full bg-gray-200 text-gray-700 flex items-center justify-center font-bold text-xs mr-3">{{ $initials }}</div>
                    <span class="font-medium text-gray-900 text-sm">{{ $user->name }}</span>
                    @endif
                </td>
                <td class="p-4 text-sm text-gray-600">{{ $user->email }}</td>
                <td class="p-4">
                    @if($user->role === 'admin')
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-black text-white shadow-sm">
                        Admin
                    </span>
                    @else
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-500 text-white shadow-sm">
                        Customer
                    </span>
                    @endif
                </td>
                <td class="p-4">
                    @if($user->is_banned)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200 shadow-sm">
                        <span class="w-1.5 h-1.5 rounded-full bg-red-500 mr-1.5"></span> Banned
                    </span>
                    @else
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 border border-emerald-200 shadow-sm">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span> Active
                    </span>
                    @endif
                </td>
                <td class="p-4 pr-6 text-right space-x-2 flex justify-end">
                    @if($user->role === 'admin')
                    <button class="text-sm text-gray-400 border border-gray-200 rounded px-2 py-1 bg-gray-50 cursor-not-allowed" disabled>Make Admin</button>
                    <button class="text-sm text-red-400 border border-red-100 rounded px-2 py-1 bg-red-50 cursor-not-allowed" disabled>Ban</button>
                    @else
                    <form action="{{ route('admin.users.admin', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to make this user an Admin?');">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="text-sm text-black hover:text-white transition-colors border border-gray-300 rounded px-2 py-1 bg-white shadow-sm hover:bg-black">Make Admin</button>
                    </form>
                    
                    <form action="{{ route('admin.users.ban', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to {{ $user->is_banned ? 'unban' : 'ban' }} this user?');">
                        @csrf
                        @method('PUT')
                        @if($user->is_banned)
                        <button type="submit" class="text-sm text-green-600 hover:text-white transition-colors border border-green-200 rounded px-2 py-1 bg-white shadow-sm hover:bg-green-600">Unban</button>
                        @else
                        <button type="submit" class="text-sm text-red-600 hover:text-white transition-colors border border-red-200 rounded px-2 py-1 bg-white shadow-sm hover:bg-red-600">Ban</button>
                        @endif
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="p-8 text-center text-gray-500">
                    No users found matching "{{ request('search') }}".
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    @if($users->hasPages())
    <div class="p-4 border-t border-gray-100 bg-gray-50">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection
