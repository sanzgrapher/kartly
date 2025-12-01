@extends('layout.admin')

@section('title', 'Edit Product')

@section('content')
    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-300 dark:border-gray-700 p-4">
        <h2 class="font-semibold mb-3 dark:text-white">Edit Product</h2>

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1 dark:text-gray-300">Name</label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}"
                    class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                @error('name')
                    <div class="text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1 dark:text-gray-300">Slug (optional)</label>
                <input type="text" name="slug" value="{{ old('slug', $product->slug) }}"
                    class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                @error('slug')
                    <div class="text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1 dark:text-gray-300">Category</label>
                <select name="category_id" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
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
                    <label class="block text-sm font-medium mb-1 dark:text-gray-300">Price Rs</label>
                    <input type="number" name="price" value="{{ old('price', $product->price) }}"
                        class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    @error('price')
                        <div class="text-sm text-red-600">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1 dark:text-gray-300">Quantity</label>
                    <input type="number" name="quantity" value="{{ old('quantity', $product->quantity) }}"
                        class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    @error('quantity')
                        <div class="text-sm text-red-600">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1 dark:text-gray-300">Description</label>
                <div class="quill-editor bg-white dark:bg-gray-700 dark:text-white dark:border-gray-600" style="height: 200px; border: 1px solid #d1d5db; border-radius: 0.375rem;"></div>
                <input type="hidden" name="description" value="{{ old('description', $product->description) }}">
                @error('description')
                    <div class="text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4" x-data="{ showImagePreview: false, newImageUrl: '' }">
                <label class="block text-sm font-medium mb-1 dark:text-gray-300">Product Image</label>

                <!-- Current Image Display -->
                <div class="mb-3">
                    <div class="text-xs text-gray-600 mb-1">Current Image:</div>
                    <div class="relative inline-block">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                            class="w-32 h-32 object-cover border border-gray-300 rounded-lg">
                        <div class="absolute top-1 right-1 bg-green-500 text-white text-xs px-2 py-1 rounded">
                            Current
                        </div>
                    </div>
                </div>

                <!-- New Image Upload -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Replace Image (Optional)
                    </label>
                    <input type="file" name="image" accept="image/*"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
                        @change="
                               showImagePreview = true;
                               const file = $event.target.files[0];
                               if (file) {
                                   const reader = new FileReader();
                                   reader.onload = (e) => newImageUrl = e.target.result;
                                   reader.readAsDataURL(file);
                               } else {
                                   showImagePreview = false;
                                   newImageUrl = '';
                               }
                           ">

                    <!-- Preview New Image -->
                    <div x-show="showImagePreview" x-transition class="mt-2">
                        <div class="text-xs text-gray-600 mb-1">Preview (New Image):</div>
                        <div class="relative inline-block">
                            <img :src="newImageUrl" alt="New image preview"
                                class="w-32 h-32 object-cover border border-gray-300 rounded-lg">
                            <div class="absolute top-1 right-1 bg-blue-500 text-white text-xs px-2 py-1 rounded">
                                New
                            </div>
                        </div>
                    </div>

                    <p class="text-xs text-gray-500">
                        Leave empty to keep current image. Supported formats: JPG, PNG, GIF (Max: 5MB)
                    </p>
                </div>

                @error('image')
                    <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                @enderror
            </div>



            <div class="mt-4 flex space-x-2">
                <button class="px-3 py-1 bg-orange-600 text-white rounded" type="submit">Save</button>
                <a href="{{ route('admin.products.index') }}" class="px-3 py-1 bg-gray-300 dark:bg-gray-600 rounded dark:text-white">Cancel</a>
            </div>


        </form>
    </div>
@endsection
