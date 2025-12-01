@extends('layout.public')

@section('title', $q ? 'Search: ' . $q : 'Search')

@section('content')
    <div class="mb-6 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4 shadow-sm">
        <form action="{{ route('search.index') }}" method="GET">
            <div class="space-y-4">
                <div>
                    <input type="text" name="q" value="{{ old('q', $q) }}" placeholder="Search products or categories"
                        class="w-full px-4 py-2 border border-gray-200 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-orange-200 dark:focus:ring-orange-900 bg-white dark:bg-gray-700 text-gray-900 dark:text-white" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Category</label>
                        <select name="category_id"
                            class="w-full px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-orange-200 dark:focus:ring-orange-900 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
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
                            class="w-full px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-orange-200 dark:focus:ring-orange-900 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Max Price (Rs.)</label>
                        <input type="number" name="max_price" value="{{ old('max_price', $maxPrice) }}" min="0"
                            step="0.01" placeholder="10000"
                            class="w-full px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-orange-200 dark:focus:ring-orange-900 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    </div>
                </div>

                <div class="flex gap-2">
                    <button type="submit"
                        class="px-6 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 font-medium">
                        Apply Filters
                    </button>
                    <a href="{{ route('search.index') }}"
                        class="px-6 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 font-medium">
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
                    <a href="{{ route('categories.show', $category->slug) }}"
                        class="group flex flex-col items-center text-center">
                        <div class="relative w-24 h-24 mb-3">
                            <div
                                class="absolute inset-0 rounded-full ring-2 ring-gray-100 dark:ring-gray-700 group-hover:ring-orange-500 transition-all">
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
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
                @foreach ($products as $product)
                    <x-ui.cards.product-card :product="$product" />
                @endforeach
            </div>

            <div class="flex justify-center mt-8">
                {{ $products->links('pagination::tailwind') }}
            </div>
        @else
            <div class="bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-8 text-center">
                <p class="text-gray-600 dark:text-gray-400">No products found.</p>
            </div>
        @endif
    </section>

@endsection
