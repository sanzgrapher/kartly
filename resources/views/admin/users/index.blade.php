@extends('layout.admin')

@section('title', 'Users')

@section('content')
    <div class="mt-8 bg-white rounded-lg border border-gray-300">
        <div class="mb-3 p-3">
            <h2 class="font-semibold ">Users</h2>
            <p class=" text-sm text-gray-400">Manage all users</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full table-auto text-left">
                <thead class="  border-t border-gray-200">
                    <tr>
                        <th class="p-4 text-sm">ID</th>
                        <th class="p-4 text-sm">Name</th>
                        <th class="p-4 text-sm">Email</th>
                        <th class="p-4 text-sm">Role</th>
                        <th class="p-4 text-sm">Joined</th>
                        <th class="p-4 text-sm">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="border-t  border-gray-300">
                            <td class="p-4 text-sm">{{ $user->id }}</td>
                            <td class="p-4 text-sm">{{ $user->name }}</td>
                            <td class="p-4 text-sm">{{ $user->email }}</td>
                            <td class="p-4 text-sm">{{ $user->role_name }}</td>
                            <td class="p-4 text-sm">{{ $user->created_at->format('M d, Y') }}</td>
                            <td class="flex px-4 py-2 space-x-2">
                                <a class="px-2 py-1 text-xs text-white bg-blue-500 rounded hover:bg-blue-600"
                                    href="{{ route('admin.users.show', $user->id) }}" title="View">
                                    View
                                </a>
                                <a class="px-2 py-1 text-xs text-white rounded bg-amber-500 hover:bg-amber-600"
                                    href="{{ route('admin.users.edit', $user->id) }}" title="Edit">
                                    Edit
                                </a>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                    onsubmit="return confirm('Delete this user?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-2 py-1 text-xs bg-red-500 hover:bg-red-600 text-white rounded">Delete</button>
                                </form>
                                </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class=" border border-t border-gray-200 p-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection
