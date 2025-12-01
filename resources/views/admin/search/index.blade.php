@extends('layout.admin')

@section('title', $q ? 'Search: ' . $q : 'Search')

@section('content')
    <div class="mb-6 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg p-4">
        <form action="{{ route('admin.search.index') }}" method="GET">
            <div class="space-y-4">
                <div>
                    <input type="text" name="q" value="{{ old('q', $q) }}" placeholder="Search products or categories"
                        class="w-full px-4 py-2 border border-gray-200 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-orange-200 dark:bg-gray-700 dark:text-white" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Category</label>
                        <select name="category_id"
                            class="w-full px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-orange-200 dark:bg-gray-700 dark:text-white">
                            <option value="">All Categories</option>
                            @foreach ($allCategories as $cat)
                                <option value="{{ $cat->id }}" {{ $selectedCategoryId == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Min Price (Rs.)</label>
                        <input type="number" name="min_price" value="{{ old('min_price', $minPrice) }}" min="0"
                            step="0.01" placeholder="0"
                            class="w-full px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-orange-200 dark:bg-gray-700 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Max Price (Rs.)</label>
                        <input type="number" name="max_price" value="{{ old('max_price', $maxPrice) }}" min="0"
                            step="0.01" placeholder="10000"
                            class="w-full px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-orange-200 dark:bg-gray-700 dark:text-white">
                    </div>
                </div>

                <div class="flex gap-2">
                    <button type="submit"
                        class="px-6 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 font-medium">
                        Apply Filters
                    </button>
                    <a href="{{ route('admin.search.index') }}"
                        class="px-6 py-2 bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-400 dark:hover:bg-gray-500 font-medium">
                        Clear
                    </a>
                </div>
            </div>
        </form>
    </div>

    @if ($q)
        <div class="mb-6">
            <h2 class="text-xl font-semibold dark:text-white">Results for "{{ $q }}"</h2>
        </div>
    @endif

    @if (isset($categories) && $categories->count() > 0)
        <section class="mb-8">
            <h3 class="text-lg font-semibold mb-4 dark:text-white">Categories</h3>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @foreach ($categories as $category)
                    <a href="{{ route('admin.categories.edit', $category->id) }}"
                        class="group flex flex-col items-center text-center hover:opacity-75 transition">
                        <div class="relative w-24 h-24 mb-3">
                            <div
                                class="absolute inset-0 rounded-full ring-2 ring-gray-100 group-hover:ring-orange-500 transition-all">
                            </div>
                            <div class="w-full h-full rounded-full overflow-hidden bg-gray-50">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($category->name) }}&size=200&background=FFF0E5&color=ea580c&bold=true"
                                    alt="{{ $category->name }}" class="w-full h-full object-cover">
                            </div>
                        </div>
                        <div class="text-sm font-medium text-gray-900 dark:text-gray-300 group-hover:text-orange-600 dark:group-hover:text-orange-400">{{ $category->name }}
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    <section>
        <h3 class="text-lg font-semibold mb-4 dark:text-white">Products</h3>

        @if ($products->count() > 0)
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-300 dark:border-gray-700 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full table-auto text-left">
                        <thead class="border-b border-gray-200 dark:border-gray-700 dark:text-gray-300">
                            <tr>
                                <th class="p-4 text-sm">ID</th>
                                <th class="p-4 text-sm">Name</th>
                                <th class="p-4 text-sm">Category</th>
                                <th class="p-4 text-sm">Price</th>
                                <th class="p-4 text-sm">Stock</th>
                                <th class="p-4 text-sm">Action</th>
                            </tr>
                        </thead>
                        <tbody class="dark:text-gray-300">
                            @foreach ($products as $product)
                                <tr class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="p-4 text-sm">{{ $product->id }}</td>
                                    <td class="p-4 text-sm font-medium">{{ $product->name }}</td>
                                    <td class="p-4 text-sm">{{ $product->category->name ?? '-' }}</td>
                                    <td class="p-4 text-sm">Rs {{ number_format($product->price, 0) }}</td>
                                    <td class="p-4 text-sm">{{ $product->stock }}</td>
                                    <td class="p-4 text-sm">
                                        <a href="{{ route('admin.products.edit', $product->id) }}"
                                            class="px-2 py-1 text-xs text-white bg-blue-500 rounded hover:bg-blue-600">Edit</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="border-t border-gray-200 dark:border-gray-700 p-4">
                    {{ $products->links() }}
                </div>
            </div>
        @else
            <div class="bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-8 text-center">
                <p class="text-gray-600 dark:text-gray-400">No products found.</p>
            </div>
        @endif
    </section>

@endsection
