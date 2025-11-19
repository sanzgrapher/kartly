@extends('layout.admin')

@section('title', 'User Detail')

@section('content')
    <div class="bg-white rounded-lg border border-gray-300 p-4">
        <h2 class="font-semibold mb-3">User: {{ $user->name }}</h2>

        <div class="space-y-2">
            <div><strong>ID:</strong> {{ $user->id }}</div>
            <div><strong>Name:</strong> {{ $user->name }}</div>
            <div><strong>Email:</strong> {{ $user->email }}</div>
            <p class="text-sm">Role: {{ $user->role_name }}</p>
            <div><strong>Joined:</strong> {{ $user->created_at->format('M d, Y') }}</div>
        </div>

        <div class="mt-4 flex space-x-2">
            <a href="{{ route('admin.users.edit', $user->id) }}" class="px-3 py-1 bg-amber-500 text-white rounded">Edit</a>

            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                onsubmit="return confirm('Delete this user?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded">Delete</button>
            </form>
        </div>
    </div>
@endsection
