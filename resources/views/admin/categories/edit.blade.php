@extends('layout.admin')

@section('title', 'Edit Category')

@section('content')
    <div class="bg-white rounded-lg border border-gray-300 p-4">
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Name</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}"
                    class="w-full border rounded px-3 py-2" required>
                @error('name')
                    <div class="text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Slug (optional)</label>
                <input type="text" name="slug" value="{{ old('slug', $category->slug) }}"
                    class="w-full border rounded px-3 py-2">
                @error('slug')
                    <div class="text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <button class="bg-orange-600 text-white px-4 py-2 rounded">Save</button>
                <a href="{{ route('admin.categories.index') }}" class="ml-3 text-sm text-gray-600">Cancel</a>
            </div>
        </form>
    </div>
@endsection
