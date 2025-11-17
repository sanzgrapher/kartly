@extends('layout.admin')

@section('title', 'Create Product')

@section('content')
    <div class="bg-white rounded-lg border border-gray-300 p-4">
        <h2 class="font-semibold mb-3">Create Product</h2>

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Name</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded px-3 py-2"
                    required>
                @error('name')
                    <div class="text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Slug (optional)</label>
                <input type="text" name="slug" value="{{ old('slug') }}" class="w-full border rounded px-3 py-2">
                @error('slug')
                    <div class="text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Category</label>
                <select name="category_id" class="w-full border rounded px-3 py-2">
                    <option value="">-- none --</option>
                    @foreach ($categories as $c)
                        <option value="{{ $c->id }}" @if (old('category_id') == $c->id) selected @endif>
                            {{ $c->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4 grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Price Rs</label>
                    <input type="number" name="price" value="{{ old('price') }}"
                        class="w-full border rounded px-3 py-2">
                    @error('price')
                        <div class="text-sm text-red-600">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Quantity</label>
                    <input type="number" name="quantity" value="{{ old('quantity', 0) }}"
                        class="w-full border rounded px-3 py-2">
                    @error('quantity')
                        <div class="text-sm text-red-600">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Description</label>
                <textarea name="description" class="w-full border rounded px-3 py-2">{{ old('description') }}</textarea>
                @error('description')
                    <div class="text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Image (optional)</label>
                <input type="file" name="image">
                @error('image')
                    <div class="text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <button class="bg-orange-600 text-white px-4 py-2 rounded" type="submit">Create</button>
                <a href="{{ route('admin.products.index') }}" class="ml-3 text-sm text-gray-600">Cancel</a>
            </div>
        </form>
    </div>
@endsection
