@extends('layout.admin')

@section('title', 'Categories')

@section('content')
    <div class="mt-8 bg-white dark:bg-gray-800 rounded-lg border border-gray-300 dark:border-gray-700">
        <div class="mb-3 p-3">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="font-semibold dark:text-white">Categories</h2>
                    <p class=" text-sm text-gray-400">Manage all categories</p>
                </div>
                <a href="{{ route('admin.categories.create') }}"
                    class="inline-block bg-orange-600 text-white px-3 py-1 rounded">New Category</a>
            </div>

            <form action="{{ route('admin.categories.index') }}" method="GET" class="mt-4">
                <div class="flex gap-2">
                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search categories..."
                        class="flex-1 px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded focus:ring-2 focus:ring-orange-200 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    <button type="submit" class="px-4 py-2 text-sm bg-orange-600 text-white rounded hover:bg-orange-700">
                        Search
                    </button>
                    @if ($search)
                        <a href="{{ route('admin.categories.index') }}"
                            class="px-4 py-2 text-sm bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200 rounded hover:bg-gray-300 dark:hover:bg-gray-500">
                            Clear
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full table-auto text-left">
                <thead class="  border-t border-gray-200 dark:border-gray-700 dark:text-gray-300">
                    <tr>
                        <th class="p-4 text-sm">ID</th>
                        <th class="p-4 text-sm">Name</th>
                        <th class="p-4 text-sm">Slug</th>
                        <th class="p-4 text-sm">Created</th>
                        <th class="p-4 text-sm">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $c)
                        <tr class="border-t  border-gray-300 dark:border-gray-700 dark:text-gray-300">
                            <td class="p-4 text-sm">{{ $c->id }}</td>
                            <td class="p-4 text-sm">{{ $c->name }}</td>
                            <td class="p-4 text-sm">{{ $c->slug }}</td>
                            <td class="p-4 text-sm">{{ $c->created_at->format('M d, Y') }}</td>
                            <td class="flex px-4 py-2 space-x-2">
                                <a class="px-2 py-1 text-xs text-white bg-blue-500 rounded hover:bg-blue-600"
                                    href="{{ route('admin.categories.show', $c->id) }}" title="View">
                                    View
                                </a>

                                <a class="px-2 py-1 text-xs text-white rounded bg-amber-500 hover:bg-amber-600"
                                    href="{{ route('admin.categories.edit', $c->id) }}" title="Edit">
                                    Edit
                                </a>

                                <form class="inline" action="{{ route('admin.categories.destroy', $c->id) }}"
                                    method="POST" onsubmit="return confirm('Delete this category?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-2 py-1 text-xs text-white bg-red-500 rounded hover:bg-red-600"
                                        type="submit" title="Delete">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            </table>

            <div class=" border border-t border-gray-200 dark:border-gray-700 p-4">

                {{ $categories->links('vendor.pagination.tailwind') }}


            </div>

        </div>
    </div>
@endsection
