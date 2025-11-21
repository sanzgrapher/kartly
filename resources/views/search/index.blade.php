@extends('layout.public')

@section('title', $q ? 'Search: ' . $q : 'Search')

@section('content')
    <div class="mb-6">
        <form action="{{ route('search.index') }}" method="GET" class="flex items-center gap-2">
            <input type="text" name="q" value="{{ old('q', $q) }}" placeholder="Search products or categories"
                class="w-full md:w-1/2 px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-orange-200" />
            <button type="submit" class="px-4 py-2 bg-orange-600 text-white rounded-lg">Search</button>
        </form>
    </div>

    @if ($q)
        <div class="mb-6">
            <h2 class="text-xl font-semibold">Results for "{{ $q }}"</h2>
        </div>
    @endif

    @if (isset($categories) && $categories->count() > 0)
        <section class="mb-8">
            <h3 class="text-lg font-semibold mb-4">Categories</h3>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @foreach ($categories as $category)
                    <a href="{{ route('categories.show', $category->slug) }}"
                        class="group flex flex-col items-center text-center">
                        <div class="relative w-24 h-24 mb-3">
                            <div
                                class="absolute inset-0 rounded-full ring-2 ring-gray-100 group-hover:ring-orange-500 transition-all">
                            </div>
                            <div class="w-full h-full rounded-full overflow-hidden bg-gray-50">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($category->name) }}&size=200&background=FFF0E5&color=ea580c&bold=true"
                                    alt="{{ $category->name }}" class="w-full h-full object-cover">
                            </div>
                        </div>
                        <div class="text-sm font-medium text-gray-900 group-hover:text-orange-600">{{ $category->name }}
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    <section>
        <h3 class="text-lg font-semibold mb-4">Products</h3>

        @if ($products->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8 mb-8">
                @foreach ($products as $product)
                    <x-ui.cards.product-card :product="$product" />
                @endforeach
            </div>

            <div class="flex justify-center mt-8">
                {{ $products->links('pagination::tailwind') }}
            </div>
        @else
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-8 text-center">
                <p class="text-gray-600">No products found.</p>
            </div>
        @endif
    </section>

@endsection
