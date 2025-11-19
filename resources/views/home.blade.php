@extends('layout.public')

@section('title', 'Home - Shop Our Products')

@section('content')


    @if ($categories->count() > 0)
        <section class="mb-12">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">categories</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                @foreach ($categories as $category)
                    <a href="{{ route('categories.show', $category->slug) }}"
                        class="group bg-white border border-gray-200 rounded-lg p-4 text-center hover:shadow-md transition-shadow">
                        <div class="rounded-md mb-3 overflow-hidden flex justify-center">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($category->name) }}&size=160&background=ef4444&color=fff"
                                alt="{{ $category->name }}"
                                class="w-20 h-20 object-cover group-hover:opacity-80 transition-opacity rounded">
                        </div>
                        <h3 class="font-semibold text-gray-800 text-sm truncate">{{ $category->name }}</h3>
                        <p class="text-xs text-gray-500 mt-1">
                            {{ $category->products_count ?? $category->products->count() }} products</p>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    <section>
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Featured Products</h2>

        @if ($products->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                @foreach ($products as $product)
                    <x-ui.cards.product-card :product="$product" />
                @endforeach
            </div>

            <div class="flex justify-center mt-8">
                {{ $products->links('pagination::tailwind') }}
            </div>
        @else
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-8 text-center">
                <p class="text-gray-600">No products available at the moment.</p>
            </div>
        @endif
    </section>
@endsection
