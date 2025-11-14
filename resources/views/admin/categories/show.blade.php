@extends('layout.admin')

@section('title', 'Category')

@section('content')
    <div class="bg-white rounded-lg border border-gray-300 p-4">
        <div class="flex items-start justify-between">
            <div>
                <h2 class="font-semibold mb-1">{{ $category->name }}</h2>
                <p class="text-sm text-gray-600"><strong>Slug:</strong> {{ $category->slug }}</p>
                <p class="text-sm text-gray-600 mt-2">Created: {{ $category->created_at->format('M d, Y') }}</p>
            </div>

            <div class="ml-4 flex items-start space-x-2">
                <a href="{{ route('admin.categories.edit', $category->id) }}"
                    class="px-3 py-1 bg-amber-500 text-white rounded">Edit</a>

                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
                    onsubmit="return confirm('Delete this category?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded">Delete</button>
                </form>
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('admin.categories.index') }}" class="text-gray-600">Back to list</a>
        </div>
    </div>
@endsection
