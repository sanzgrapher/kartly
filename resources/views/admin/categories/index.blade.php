@extends('layout.admin')

@section('title', 'Categories')

@section('content')
    <div class="bg-white rounded-lg border border-gray-300 p-4">
        <div class="flex items-center justify-between mb-3">
            <h2 class="font-semibold">Categories</h2>
            <a href="{{ route('admin.categories.create') }}"
                class="inline-block bg-orange-600 text-white px-3 py-1 rounded">New Category</a>
        </div>
       
        <div class="overflow-x-auto">
            <table class="w-full table-auto text-left">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 py-2 text-sm">ID</th>
                        <th class="px-3 py-2 text-sm">Name</th>
                        <th class="px-3 py-2 text-sm">Slug</th>
                        <th class="px-3 py-2 text-sm">Created</th>
                        <th class="px-3 py-2 text-sm">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $c)
                        <tr class="border-t">
                            <td class="px-3 py-2 text-sm">{{ $c->id }}</td>
                            <td class="px-3 py-2 text-sm">{{ $c->name }}</td>
                            <td class="px-3 py-2 text-sm">{{ $c->slug }}</td>
                            <td class="px-3 py-2 text-sm">{{ $c->created_at->format('M d, Y') }}</td>
                            <td class="flex px-4 py-2 space-x-2">
                                <a class="px-2 py-1 text-xs text-white bg-blue-500 rounded hover:bg-blue-600"
                                    href="{{ route('admin.categories.show', $c->id) }}" title="View">
                                    View
                                </a>

                                <a class="px-2 py-1 text-xs text-white rounded bg-amber-500 hover:bg-amber-600"
                                    href="{{ route('admin.categories.edit', $c->id) }}" title="Edit">
                                    Edit
                                </a>

                                <form class="inline" action="{{ route('admin.categories.destroy', $c->id) }}" method="POST"
                                    onsubmit="return confirm('Delete this category?');">
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
        </div>
    </div>
@endsection
