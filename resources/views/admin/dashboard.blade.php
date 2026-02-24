<x-app-layout>
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

        {{-- Stats --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="p-4 border rounded">Users: <b>{{ $usersCount }}</b></div>
            <div class="p-4 border rounded">Banned: <b>{{ $bannedCount }}</b></div>
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
                            {{-- Don’t allow banning yourself (optional) --}}
                            @if(auth()->id() === $u->id)
                                <span class="text-gray-500">You</span>
                            @else
                                @if($u->is_banned)
                                    <form method="POST" action="/admin/users/{{ $u->id }}/toggleban">
                                        @csrf
                                        <button class="px-3 py-1 border rounded">
                                            Unban
                                        </button>
                                    </form>
                                @else
                                    <form method="POST" action="/admin/users/{{ $u->id }}/toggleban">
                                        @csrf
                                        <button class="px-3 py-1 border rounded">
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
</x-app-layout>