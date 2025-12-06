@extends('layout.admin')

@section('title', 'Products')

@section('content')
    <div class="mt-8 bg-white dark:bg-gray-800 rounded-lg border border-gray-300 dark:border-gray-700 transition-colors duration-300">
        <div class="mb-3 p-3">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="font-semibold dark:text-white">Products</h2>
                    <p class=" text-sm text-gray-400">Manage all products</p>
                </div>
                <a href="{{ route('admin.products.create') }}"
                    class="inline-block bg-orange-600 text-white px-3 py-1 rounded">
                    + New Product</a>
            </div>
        </div>

        <div class="border-t border-gray-200 dark:border-gray-700 p-4 bg-gray-50 dark:bg-gray-900/50">
            <form action="{{ route('admin.products.index') }}" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                    <!-- Search -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Search</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Product name..."
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-orange-200 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Category</label>
                        <select name="category_id"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-orange-200 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            <option value="">All Categories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Stock Status</label>
                        <select name="stock_status"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-orange-200 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            <option value="">All</option>
                            <option value="in_stock" {{ request('stock_status') === 'in_stock' ? 'selected' : '' }}>
                                In Stock (≥10)
                            </option>
                            <option value="low_stock" {{ request('stock_status') === 'low_stock' ? 'selected' : '' }}>
                                Low Stock (1-9)
                            </option>
                            <option value="out_of_stock" {{ request('stock_status') === 'out_of_stock' ? 'selected' : '' }}>
                                Out of Stock
                            </option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Min Stock</label>
                        <input type="number" name="stock_low" value="{{ request('stock_low') }}" min="0"
                            placeholder="Min"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-orange-200 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Max Stock</label>
                        <input type="number" name="stock_high" value="{{ request('stock_high') }}" min="0"
                            placeholder="Max"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-orange-200 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    </div>
                </div>

                <div class="flex gap-2">
                    <button type="submit"
                        class="px-4 py-2 bg-orange-600 text-white rounded hover:bg-orange-700 text-sm font-medium">
                        Apply Filters
                    </button>
                    <a href="{{ route('admin.products.index') }}"
                        class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-200 rounded hover:bg-gray-400 dark:hover:bg-gray-500 text-sm font-medium">
                        Clear
                    </a>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full table-auto text-left">
                <thead class="border-t border-gray-200 dark:border-gray-700 dark:text-gray-300">
                    <tr>
                        <th class="p-4 text-sm">ID</th>
                        <th class="p-4 text-sm">Image</th>
                        <th class="p-4 text-sm">Name</th>
                        <th class="p-4 text-sm">Price</th>
                        <th class="p-4 text-sm">Stock</th>
                        <th class="p-4 text-sm">Created</th>
                        <th class="p-4 text-sm">Actions</th>
                    </tr>
                </thead>

                <tbody class="dark:text-gray-300">
                    @foreach ($products as $p)
                        <tr class="border-t border-gray-300 dark:border-gray-700">
                            <td class="p-4 text-sm">{{ $p->id }}</td>
                            <td class="p-4 text-sm">
                                <img src="{{ $p->image_url }}" alt="{{ $p->name }}"
                                    class="w-16 h-12 object-cover rounded">
                            </td>
                            <td class="p-4 text-sm">{{ $p->name }}</td>
                            <td class="p-4 text-sm">
                                Rs {{ $p->price }}
                            </td>
                            <td class="p-4 text-sm">
                                @if ($p->stock_status == 'In Stock')
                                    <span class="text-green-600 font-medium">{{ $p->quantity }} units</span>
                                @elseif($p->stock_status == 'Low Stock')
                                    <span class="text-yellow-600 font-medium">{{ $p->quantity }} units</span>
                                @else
                                    <span class="text-red-600 font-medium">{{ $p->quantity }} units</span>
                                @endif
                            </td>
                            <td class="p-4 text-sm">{{ $p->created_at->format('M d, Y') }}</td>
                            <td class="p-4 text-sm">
                                <div class="flex items-center gap-2">
                                    <a class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-blue-600 text-white hover:bg-blue-700 active:bg-blue-800 shadow-sm hover:shadow-md transition-all duration-200 transform hover:scale-105"
                                        href="{{ route('admin.products.show', $p->id) }}">View</a>

                                    <a class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-amber-600 text-white hover:bg-amber-700 active:bg-amber-800 shadow-sm hover:shadow-md transition-all duration-200 transform hover:scale-105"
                                        href="{{ route('admin.products.edit', $p->id) }}">Edit</a>

                                    <form class="inline" action="{{ route('admin.products.destroy', $p->id) }}" method="POST"
                                        onsubmit="return confirm('Delete this product?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-red-600 text-white hover:bg-red-700 active:bg-red-800 shadow-sm hover:shadow-md transition-all duration-200 transform hover:scale-105"
                                            type="submit">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4 p-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>
@endsection
