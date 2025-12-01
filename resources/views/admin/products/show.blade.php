@extends('layout.admin')

@section('title', 'Product')

@section('content')
    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-300 dark:border-gray-700 p-4 transition-colors duration-300">
        <div class="flex items-start justify-between mb-4">
            <div>
                <h2 class="text-xl font-semibold dark:text-white">{{ $product->name }}</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400">{{ optional($product->category)->name ?? 'n/a' }}</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.products.edit', $product->id) }}"
                    class="px-3 py-1 bg-amber-500 text-white rounded text-sm">Edit</a>
                <a href="{{ route('admin.products.index') }}" class="px-3 py-1 text-sm text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200">Back</a>
            </div>
        </div>

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded">
                <p class="text-green-800 font-semibold">{{ session('success') }}</p>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded">
                <p class="text-red-800 font-semibold">{{ session('error') }}</p>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-1">
                <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full object-cover rounded">
                </div>
            </div>

            <div class="md:col-span-2">
                <div class="mb-4">
                    <h3 class="font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">Description</h3>
                    <div class="text-gray-800 dark:text-gray-200 prose prose-sm max-w-none dark:prose-invert">{!! $product->description ?? 'n/a' !!}</div>
                </div>

                <div class="grid grid-cols-2 gap-4 text-sm text-gray-700 dark:text-gray-300 mb-6">
                    <div>
                        <h4 class="text-xs text-gray-500">ID</h4>
                        <div class="mt-1">{{ $product->id }}</div>
                    </div>
                    <div>
                        <h4 class="text-xs text-gray-500">Slug</h4>
                        <div class="mt-1">{{ $product->slug ?? 'n/a' }}</div>
                    </div>

                    <div>
                        <h4 class="text-xs text-gray-500">Price</h4>
                        <div class="mt-1">
                            Rs {{ $product->price }}
                        </div>
                    </div>
                    <div>
                        <h4 class="text-xs text-gray-500">Quantity</h4>
                        <div class="mt-1">{{ $product->quantity }}</div>
                    </div>
                    <div>
                        <h4 class="text-xs text-gray-500">Stock Status</h4>
                        <div class="mt-1">
                            @if ($product->stock_status == 'In Stock')
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">{{ $product->stock_status }}</span>
                            @elseif($product->stock_status == 'Low Stock')
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">{{ $product->stock_status }}</span>
                            @else
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">{{ $product->stock_status }}</span>
                            @endif
                        </div>
                    </div>

                    <div>
                        <h4 class="text-xs text-gray-500 dark:text-gray-400">Created</h4>
                        <div class="mt-1 text-sm text-gray-600 dark:text-gray-300">{{ $product->created_at->format('M d, Y') }}</div>
                    </div>
                    <div>
                        <h4 class="text-xs text-gray-500 dark:text-gray-400">Updated</h4>
                        <div class="mt-1 text-sm text-gray-600 dark:text-gray-300">{{ $product->updated_at->format('M d, Y') }}</div>
                    </div>
                </div>

                <!-- Stock Management Section -->
                <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-6">
                    <h3 class="font-semibold text-gray-800 dark:text-white mb-4">Stock Management</h3>

                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4 space-y-4">
                        <!-- Add Stock -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Add Stock</label>
                            <form action="{{ route('admin.products.updateStock', $product->id) }}" method="POST"
                                class="flex gap-3">
                                @csrf
                                @method('PATCH')
                                <input type="number" name="adjustment" id="add_stock" min="1" value="20"
                                    placeholder="Quantity"
                                    class="flex-1 px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                                <button type="submit"
                                    class="px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors duration-150 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Add
                                </button>
                            </form>
                        </div>

                        <!-- Remove Stock -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Remove Stock</label>
                            <form action="{{ route('admin.products.updateStock', $product->id) }}" method="POST"
                                class="flex gap-3"
                                onsubmit="document.getElementById('remove_adjustment').value = -Math.abs(document.getElementById('remove_input').value)">
                                @csrf
                                @method('PATCH')
                                <input type="number" id="remove_input" min="1" max="{{ $product->quantity }}"
                                    value="10" placeholder="Quantity"
                                    class="flex-1 px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                                <input type="hidden" name="adjustment" id="remove_adjustment" value="-10">
                                <button type="submit"
                                    class="px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors duration-150 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4">
                                        </path>
                                    </svg>
                                    Remove
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
