@extends('layout.admin')

@section('title', 'Users')

@section('content')
    @if (session('success'))
        <div class="mb-4 p-3 bg-green-100 dark:bg-green-900/30 border border-green-400 dark:border-green-700 rounded text-green-700 dark:text-green-300">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 p-3 bg-red-100 dark:bg-red-900/30 border border-red-400 dark:border-red-700 rounded text-red-700 dark:text-red-300">
            {{ session('error') }}
        </div>
    @endif

    <div class="mt-8 bg-white dark:bg-gray-800 rounded-lg border border-gray-300 dark:border-gray-700 transition-colors duration-300">
        <div class="mb-3 p-3 flex justify-between items-center">
            <div>
                <h2 class="font-semibold dark:text-white">Users</h2>
                <p class=" text-sm text-gray-400">Manage all users</p>
            </div>
            <a href="{{ route('admin.users.create') }}" class="px-3 py-2 bg-orange-600 text-white rounded hover:bg-orange-700 text-sm">
                Add User
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full table-auto text-left">
                <thead class="  border-t border-gray-200 dark:border-gray-700 dark:text-gray-300">
                    <tr>
                        <th class="p-4 text-sm">ID</th>
                        <th class="p-4 text-sm">Name</th>
                        <th class="p-4 text-sm">Email</th>
                        <th class="p-4 text-sm">Role</th>
                        <th class="p-4 text-sm">Joined</th>
                        <th class="p-4 text-sm">Action</th>
                    </tr>
                </thead>
                <tbody class="dark:text-gray-300">
                    @foreach ($users as $user)
                        <tr class="border-t  border-gray-300 dark:border-gray-700">
                            <td class="p-4 text-sm">{{ $user->id }}</td>
                            <td class="p-4 text-sm">{{ $user->name }}</td>
                            <td class="p-4 text-sm">{{ $user->email }}</td>
                            <td class="p-4 text-sm">{{ $user->role_name }}</td>
                            <td class="p-4 text-sm">{{ $user->created_at->format('M d, Y') }}</td>
                            <td class="p-4 text-sm">
                                <div class="flex items-center gap-2">
                                    <a class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-blue-600 text-white hover:bg-blue-700 active:bg-blue-800 shadow-sm hover:shadow-md transition-all duration-200 transform hover:scale-105"
                                        href="{{ route('admin.users.show', $user->id) }}">
                                        View
                                    </a>
                                    <a class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-amber-600 text-white hover:bg-amber-700 active:bg-amber-800 shadow-sm hover:shadow-md transition-all duration-200 transform hover:scale-105"
                                        href="{{ route('admin.users.edit', $user->id) }}">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                        onsubmit="return confirm('Delete this user?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-red-600 text-white hover:bg-red-700 active:bg-red-800 shadow-sm hover:shadow-md transition-all duration-200 transform hover:scale-105">Delete</button>
                                    </form>
                                </div>
                                </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class=" border border-t border-gray-200 dark:border-gray-700 p-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection
