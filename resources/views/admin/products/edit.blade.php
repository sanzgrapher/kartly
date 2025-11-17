@extends('layout.admin')

@section('title', 'Edit Product')

@section('content')
    <div class="bg-white rounded-lg border border-gray-300 p-4">
        <h2 class="font-semibold mb-3">Edit Product</h2>

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Name</label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}"
                    class="w-full border rounded px-3 py-2" required>
                @error('name')
                    <div class="text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Slug (optional)</label>
                <input type="text" name="slug" value="{{ old('slug', $product->slug) }}"
                    class="w-full border rounded px-3 py-2">
                @error('slug')
                    <div class="text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Category</label>
                <select name="category_id" class="w-full border rounded px-3 py-2">
                    <option value="">-- none --</option>
                    @foreach ($categories as $c)
                        <option value="{{ $c->id }}" @if (old('category_id', $product->category_id) == $c->id) selected @endif>
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
                    <input type="number" name="price" value="{{ old('price', $product->price) }}"
                        class="w-full border rounded px-3 py-2">
                    @error('price')
                        <div class="text-sm text-red-600">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Quantity</label>
                    <input type="number" name="quantity" value="{{ old('quantity', $product->quantity) }}"
                        class="w-full border rounded px-3 py-2">
                    @error('quantity')
                        <div class="text-sm text-red-600">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Description</label>
                <textarea name="description" class="w-full border rounded px-3 py-2">{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <div class="text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Current Image</label>
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-32 mb-2 rounded">
                <div class="mt-2">
                    <label class="block text-sm font-medium mb-1">Replace Image (optional)</label>
                    <input type="file" name="image">
                    @error('image')
                        <div class="text-sm text-red-600">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div>
                <button class="bg-orange-600 text-white px-4 py-2 rounded" type="submit">Save</button>
                <a href="{{ route('admin.products.index') }}" class="ml-3 text-sm text-gray-600">Cancel</a>
            </div>
        </form>
    </div>
@endsection
