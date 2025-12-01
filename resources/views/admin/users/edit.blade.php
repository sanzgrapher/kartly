@extends('layout.admin')

@section('title', 'Edit User')

@section('content')
    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-300 dark:border-gray-700 p-4">
        <h2 class="font-semibold mb-3 dark:text-white">Edit User</h2>

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



            <div class="grid grid-cols-2 gap-4">
                <div class="mb-2">
                    <label class="block text-sm dark:text-gray-300">Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" {{-- class="w-full border rounded px-2 py-1" required> --}}
                        class="mt-1 w-full border border-gray-600 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                        required>
                </div>

                <div class="mb-2">
                    <label class="block text-sm dark:text-gray-300">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                        class="mt-1 w-full border rounded px-3 py-2 border-gray-600 focus:outline-none focus:ring-2 focus:ring-orange-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                        required>
                </div>
            </div>


            <div class="grid grid-cols-2">
                <div class="mb-2 ">
                    <label class="block text-sm dark:text-gray-300">Role</label>
                    <input type="text" value="customer"
                        class="mt-1 w-full border  text-gray-600 bg-gray-100 dark:bg-gray-700 dark:text-gray-400 border-gray-400 dark:border-gray-600 cursor-not-allowed rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-300"
                        disabled>
                    <input type="hidden" name="role" value="customer">
                </div>
            </div>

            <div class="mt-4 flex space-x-2">
                <button class="px-3 py-1 bg-orange-600 text-white rounded" type="submit">Save</button>
                <a href="{{ route('admin.users.index') }}" class="px-3 py-1 bg-gray-300 dark:bg-gray-600 rounded dark:text-white">Cancel</a>
            </div>
        </form>
    </div>
@endsection
