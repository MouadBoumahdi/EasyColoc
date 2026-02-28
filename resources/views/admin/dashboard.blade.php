@extends('layouts.app')

@section('title', 'Tableau de bord')

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Admin Dashboard
        </h2>
    </x-slot>

    <div class="py-6 max-w-6xl mx-auto space-y-6">

        {{-- Success message --}}
        @if(session('success'))
            <div class="p-3 bg-green-100 border border-green-300 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- Error message --}}
        @if($errors->has('error'))
            <div class="p-3 bg-red-100 border border-red-300 rounded">
                {{ $errors->first('error') }}
            </div>
        @endif

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            {{-- Total Users Card --}}
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6 border-b border-gray-200 bg-blue-50">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                            <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-5">
                            <h4 class="text-lg font-semibold text-gray-700">Total Users</h4>
                            <div class="text-3xl font-bold text-blue-600">{{ DB::table('users')->count() }}</div>
                            <p class="text-sm text-gray-500 mt-1">Registered users</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Total Colocations Card --}}
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6 border-b border-gray-200 bg-green-50">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                            <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <div class="ml-5">
                            <h4 class="text-lg font-semibold text-gray-700">Total Colocations</h4>
                            <div class="text-3xl font-bold text-green-600">{{  App\Models\Colocation::count()}}</div>
                            <p class="text-sm text-gray-500 mt-1">Active colocations</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Banned Users Card --}}
            <div class="p-4 border rounded">Banned: <b>{{ App\Models\User::where('is_banned',true)->count() }}</b></div>
        </div>

        {{-- Users table --}}
        <div class="p-4 border rounded">
            <h3 class="font-semibold mb-3">Users</h3>

            <table class="w-full text-left">
                <thead>
                    <tr class="border-b">
                        <th class="py-2">Name</th>
                        <th>Email</th>
                        <th>Admin</th>
                        <th>Banned</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                @foreach($users as $u)
                    <tr class="border-b">
                        <td class="py-2">{{ $u->name }}</td>
                        <td>{{ $u->email }}</td>
                        <td>{{ $u->is_global_admin ? 'yes' : 'no' }}</td>
                        <td>{{ $u->is_banned ? 'yes' : 'no' }}</td>

                        <td class="py-2">
                            {{-- Don't allow banning yourself (optional) --}}
                            @if(auth()->id() === $u->id)
                                <span class="text-gray-500">You</span>
                            @else
                                @if($u->is_banned)
                                    <form method="POST" action="/admin/users/{{ $u->id }}/toggleban">
                                        @csrf
                                        <button class="px-3 py-1 border rounded bg-green-500 text-white hover:bg-green-600">
                                            Unban
                                        </button>
                                    </form>
                                @else
                                    <form method="POST" action="/admin/users/{{ $u->id }}/toggleban">
                                        @csrf
                                        <button class="px-3 py-1 border rounded bg-red-500 text-white hover:bg-red-600">
                                            Ban
                                        </button>
                                    </form>
                                @endif
                            @endif
                        </td>

                    </tr>
                @endforeach
                </tbody>
            </table>

            {{-- Pagination --}}
            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection