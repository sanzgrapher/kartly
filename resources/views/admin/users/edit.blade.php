@extends('layout.admin')

@section('title', 'Edit User')

@section('content')
    <div class="bg-white rounded-lg border border-gray-300 p-4">
        <h2 class="font-semibold mb-3">Edit User</h2>

        @if ($errors->any())
            <div class="mb-4 text-red-600">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-2">
                <label class="block text-sm">Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                    class="w-full border rounded px-2 py-1" required>
            </div>

            <div class="mb-2">
                <label class="block text-sm">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                    class="w-full border rounded px-2 py-1" required>
            </div>

            <div class="mb-2">
                <label class="block text-sm">Role</label>
                <input type="text" value="customer" class="w-full border rounded px-2 py-1" disabled>
                <input type="hidden" name="role" value="customer">
            </div>

            <div class="mt-4 flex space-x-2">
                <button class="px-3 py-1 bg-blue-600 text-white rounded" type="submit">Save</button>
                <a href="{{ route('admin.users.index') }}" class="px-3 py-1 bg-gray-300 rounded">Cancel</a>
            </div>
        </form>
    </div>
@endsection
