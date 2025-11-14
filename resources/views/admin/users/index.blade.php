@extends('layout.admin')

@section('title', 'Users')

@section('content')
    <div class="bg-white rounded-lg border border-gray-300 p-4">
        <h2 class="font-semibold mb-3">Users</h2>
        <div class="overflow-x-auto">
            <table class="w-full table-auto text-left">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 py-2 text-sm">ID</th>
                        <th class="px-3 py-2 text-sm">Name</th>
                        <th class="px-3 py-2 text-sm">Email</th>
                        <th class="px-3 py-2 text-sm">Joined</th>
                        <th class="px-3 py-2 text-sm">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="border-t">
                            <td class="px-3 py-2 text-sm">{{ $user->id }}</td>
                            <td class="px-3 py-2 text-sm">{{ $user->name }}</td>
                            <td class="px-3 py-2 text-sm">{{ $user->email }}</td>
                            <td class="px-3 py-2 text-sm">{{ $user->created_at->format('M d, Y') }}</td>
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
                                    <button type="submit" class="px-2 py-1 text-xs bg-red-500 hover:bg-red-600 text-white rounded">Delete</button>
                                </form>
                                </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection
