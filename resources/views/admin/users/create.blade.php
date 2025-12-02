@extends('layout.admin')

@section('title', 'Add User')

@section('content')
    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-300 dark:border-gray-700 p-4 transition-colors duration-300">
        <h2 class="font-semibold mb-3 dark:text-white">Add User</h2>

        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 dark:bg-red-900/30 border border-red-400 dark:border-red-700 rounded text-red-700 dark:text-red-300">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mb-4 p-3 bg-blue-100 dark:bg-blue-900/30 border border-blue-400 dark:border-blue-700 rounded text-blue-700 dark:text-blue-300">
            <p class="text-sm">
                <strong>Note:</strong> A password reset link will be sent to the user's email address. They will need to set their own password using this link.
            </p>
        </div>

        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-2 gap-4">
                <div class="mb-2">
                    <label class="block text-sm dark:text-gray-300">Name</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="mt-1 w-full border border-gray-600 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                        required>
                </div>

                <div class="mb-2">
                    <label class="block text-sm dark:text-gray-300">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="mt-1 w-full border rounded px-3 py-2 border-gray-600 focus:outline-none focus:ring-2 focus:ring-orange-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                        required>
                </div>
            </div>

            <div class="grid grid-cols-2">
                <div class="mb-2">
                    <label class="block text-sm dark:text-gray-300">Role</label>
                    <select name="role"
                        class="mt-1 w-full border border-gray-600 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        @foreach (\App\Enums\UserRole::cases() as $role)
                            <option value="{{ $role->value }}" {{ old('role') == $role->value ? 'selected' : '' }}>
                                {{ ucfirst($role->value) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mt-4 flex space-x-2">
                <button class="px-3 py-1 bg-orange-600 text-white rounded" type="submit">Create User</button>
                <a href="{{ route('admin.users.index') }}" class="px-3 py-1 bg-gray-300 dark:bg-gray-600 rounded dark:text-white">Cancel</a>
            </div>
        </form>
    </div>
@endsection
