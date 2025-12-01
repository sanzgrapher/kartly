@extends('layout.admin')

@section('title', 'Create Product')

@section('content')
    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-300 dark:border-gray-700 p-4">
        <h2 class="font-semibold mb-3 dark:text-white">Create Product</h2>

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1 dark:text-gray-300">Name</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                    required>
                @error('name')
                    <div class="text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1 dark:text-gray-300">Slug (optional)</label>
                <input type="text" name="slug" value="{{ old('slug') }}" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                @error('slug')
                    <div class="text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1 dark:text-gray-300">Category</label>
                <select name="category_id" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
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
                    <label class="block text-sm font-medium mb-1 dark:text-gray-300">Price Rs</label>
                    <input type="number" name="price" value="{{ old('price') }}"
                        class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    @error('price')
                        <div class="text-sm text-red-600">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1 dark:text-gray-300">Quantity</label>
                    <input type="number" name="quantity" value="{{ old('quantity', 0) }}"
                        class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    @error('quantity')
                        <div class="text-sm text-red-600">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1 dark:text-gray-300">Description</label>
                <div class="quill-editor bg-white dark:bg-gray-700 dark:text-white dark:border-gray-600" style="height: 200px; border: 1px solid #d1d5db; border-radius: 0.375rem;"></div>
                <input type="hidden" name="description" value="{{ old('description') }}">
                @error('description')
                    <div class="text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4" x-data="{ imageUrl: '' }">
                <label class="block text-sm font-medium mb-1 dark:text-gray-300">Product Image</label>
                <input type="file" name="image" accept="image/*" required
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
                    @change="
                           const file = $event.target.files[0];
                           if (file) {
                               const reader = new FileReader();
                               reader.onload = (e) => imageUrl = e.target.result;
                               reader.readAsDataURL(file);
                           } else {
                               imageUrl = '';
                           }
                       ">

                <!-- Preview Image -->
                <div x-show="imageUrl" x-transition class="mt-3">
                    <div class="text-xs text-gray-600 mb-1">Preview:</div>
                    <div class="relative inline-block">
                        <img :src="imageUrl" alt="Image preview"
                            class="w-32 h-32 object-cover border border-gray-300 rounded-lg">
                        <div class="absolute top-1 right-1 bg-blue-500 text-white text-xs px-2 py-1 rounded">
                            Preview
                        </div>
                    </div>
                </div>

                <p class="text-xs text-gray-500 mt-1">
                    Supported formats: JPG, PNG, GIF (Max: 5MB)
                </p>

                @error('image')
                    <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mt-4 flex space-x-2">
                <button class="px-3 py-1 bg-orange-600 text-white rounded" type="submit">Create</button>
                <a href="{{ route('admin.products.index') }}" class="px-3 py-1 bg-gray-300 dark:bg-gray-600 rounded dark:text-white">Cancel</a>
            </div>


        </form>
    </div>
@endsection
