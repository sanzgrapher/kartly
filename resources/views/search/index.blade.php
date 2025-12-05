@extends('layout.public')

@section('title', $q ? 'Search: ' . $q : 'Search')

@section('content')
    <div class="flex flex-col lg:flex-row gap-6">
        <!-- LEFT: Filters Sidebar -->
        <aside class="w-full lg:w-64 shrink-0">
            <div
                class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden sticky top-4">
                <!-- Header -->
                <div class="p-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                    <h2 class="flex items-center gap-2 text-lg font-bold text-gray-800 dark:text-white">
                        <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                            </path>
                        </svg>
                        Filters
                    </h2>
                </div>

                <!-- Filter Form -->
                <form action="{{ route('search.index') }}" method="GET" class="p-4">
                    <div class="space-y-6">
                        <!-- Search Input -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Search Query
                            </label>
                            <input type="text" name="q" value="{{ old('q', $q) }}"
                                placeholder="Search products..."
                                class="w-full px-3 py-2 text-sm border border-gray-200 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-orange-200 dark:focus:ring-orange-900 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500" />
                        </div>

                         <div x-data="{
                            open: false,
                            search: '',
                            selected: {{ $selectedCategoryId ?: 'null' }},
                            selectedName: '{{ $selectedCategoryId ? $allCategories->find($selectedCategoryId)?->name : 'All Categories' }}',
                            categories: {{ $allCategories->map(fn($c) => ['id' => $c->id, 'name' => $c->name])->toJson() }},
                            get filteredCategories() {
                                if (!this.search) return this.categories;
                                return this.categories.filter(cat =>
                                    cat.name.toLowerCase().includes(this.search.toLowerCase())
                                );
                            },
                            selectCategory(id, name) {
                                this.selected = id;
                                this.selectedName = name;
                                this.open = false;
                                this.search = '';
                            }
                        }" @click.away="open = false" class="relative">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Category
                            </label>

                            <input type="hidden" name="category_id" :value="selected">

                            <button type="button" @click="open = !open"
                                class="w-full px-3 py-2 text-sm border border-gray-200 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-orange-200 dark:focus:ring-orange-900 bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-left flex items-center justify-between">
                                <span x-text="selectedName" class="truncate"></span>
                                <svg class="w-4 h-4 transition-transform" :class="open && 'rotate-180'" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7">
                                    </path>
                                </svg>
                            </button>

                            <div x-show="open" x-transition
                                class="absolute z-50 w-full mt-1 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg shadow-lg overflow-hidden">
                                 <div class="p-2 border-b border-gray-200 dark:border-gray-600">
                                    <input type="text" x-model="search" placeholder="Search categories..."
                                        class="w-full px-3 py-1.5 text-sm border border-gray-200 dark:border-gray-600 rounded focus:ring-2 focus:ring-orange-200 dark:focus:ring-orange-900 bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500"
                                        @click.stop>
                                </div>

                                 <div class="max-h-60 overflow-y-auto">
                                    <button type="button" @click="selectCategory(null, 'All Categories')"
                                        class="w-full px-3 py-2 text-left text-sm hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors"
                                        :class="selected === null &&
                                            'bg-orange-50 dark:bg-orange-900/20 text-orange-600 dark:text-orange-400 font-semibold'">
                                        All Categories
                                    </button>

                                    <template x-for="cat in filteredCategories" :key="cat.id">
                                        <button type="button" @click="selectCategory(cat.id, cat.name)"
                                            class="w-full px-3 py-2 text-left text-sm hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors text-gray-900 dark:text-white"
                                            :class="selected === cat.id &&
                                                'bg-orange-50 dark:bg-orange-900/20 text-orange-600 dark:text-orange-400 font-semibold'"
                                            x-text="cat.name">
                                        </button>
                                    </template>

                                    <div x-show="filteredCategories.length === 0"
                                        class="px-3 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                        No categories found
                                    </div>
                                </div>
                            </div>
                        </div>

                         <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Price Range (Rs.)
                            </label>
                            <div class="space-y-3">
                                <div>
                                    <label class="text-xs text-gray-500 dark:text-gray-400 mb-1 block">Min Price</label>
                                    <input type="number" name="min_price" value="{{ old('min_price', $minPrice) }}"
                                        min="0" step="0.01" placeholder="0"
                                        class="w-full px-3 py-2 text-sm border border-gray-200 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-orange-200 dark:focus:ring-orange-900 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                </div>
                                <div>
                                    <label class="text-xs text-gray-500 dark:text-gray-400 mb-1 block">Max Price</label>
                                    <input type="number" name="max_price" value="{{ old('max_price', $maxPrice) }}"
                                        min="0" step="0.01" placeholder="10000"
                                        class="w-full px-3 py-2 text-sm border border-gray-200 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-orange-200 dark:focus:ring-orange-900 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                </div>
                            </div>
                        </div>

                         <div class="space-y-2 pt-2">
                            <button type="submit"
                                class="w-full px-4 py-2.5 bg-orange-600 text-white text-sm font-semibold rounded-lg hover:bg-orange-700 transition-colors duration-200 shadow-sm">
                                Apply Filters
                            </button>
                            <a href="{{ route('search.index') }}"
                                class="block w-full px-4 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 text-sm font-semibold rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-200 text-center">
                                Clear All
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </aside>

         <main class="flex-1 min-w-0">
            @if ($q)
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                        Results for "<span class="text-orange-600">{{ $q }}</span>"
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Found {{ $products->total() }} {{ Str::plural('product', $products->total()) }}
                    </p>
                </div>
            @endif

            {{-- @if (isset($categories) && $categories->count() > 0) --}}
            {{-- <section class="mb-8">
                    <h3 class="text-lg font-semibold mb-4 dark:text-white">Categories</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach ($categories as $category)
                            <a href="{{ route('categories.show', $category->slug) }}"
                                class="group flex items-center gap-3 px-4 py-3 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 hover:border-orange-500 dark:hover:border-orange-500 hover:shadow-md transition-all duration-300">

                                <!-- Icon Image -->
                                <div
                                    class="shrink-0 w-12 h-12 rounded-lg overflow-hidden bg-orange-50 dark:bg-orange-900/20 flex items-center justify-center">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($category->name) }}&size=100&background=FFF0E5&color=ea580c&bold=true"
                                        alt="{{ $category->name }}" class="w-full h-full object-cover">
                                </div>

                                <!-- Category Name -->
                                <span
                                    class="flex-1 text-sm font-semibold text-gray-900 dark:text-white group-hover:text-orange-600 dark:group-hover:text-orange-400 transition-colors duration-300">
                                    {{ $category->name }}
                                </span>

                                <!-- Arrow Icon -->
                                <svg class="w-4 h-4 text-gray-400 group-hover:text-orange-600 group-hover:translate-x-1 transition-all duration-300"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                    </path>
                                </svg>
                            </a>
                        @endforeach
                    </div>
                </section> --}}
            {{-- @endif --}}

            <section>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold dark:text-white">Products</h3>
                    <span class="text-sm text-gray-500 dark:text-gray-400">
                        {{ $products->count() }} of {{ $products->total() }}
                    </span>
                </div>

                @if ($products->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                        @foreach ($products as $product)
                            <x-ui.cards.product-card :product="$product" />
                        @endforeach
                    </div>

                    <div class="flex justify-center mt-8">
                        {{ $products->links('pagination::tailwind') }}
                    </div>
                @else
                    <div
                        class="bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-12 text-center">
                        <svg class="w-16 h-16 mx-auto text-gray-300 dark:text-gray-600 mb-4" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No products found</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">Try adjusting your search or filters</p>
                        <a href="{{ route('search.index') }}"
                            class="inline-block px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors">
                            Clear Filters
                        </a>
                    </div>
                @endif
            </section>
        </main>
    </div>

@endsection
