@extends('layout.public')

@section('title', 'Home - Shop Our Products')

@section('content')

    <section class="mb-12 ">
        <div class="grid  grid-cols-4 gap-4">
            <div class=" col-span-4  md:col-span-1 mb-4 shadow p-3 h-full rounded  ">
                <h2 class="text-2xl mb-2  text-gray-800">Categories</h2>
                @if ($categories->count() > 0)
                    <ul class="space-y-1">
                        @foreach ($categories as $category)
                            <li>
                                <a href="{{ route('categories.show', $category->slug) }}"
                                    class="flex items-center gap-3 px-2  py-1 rounded-md hover:bg-orange-100 {{ request()->routeIs('admin.categories.*') ? 'bg-orange-200 text-orange-600' : '' }}">
                                    <span class="text-sm font-bold">{{ $category->name }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
            <div class="col-span-4 md:col-span-3 bg-orange-100">
                <img class="h-full object-cover" src="https://i.ibb.co/vCyRmg2t/image.png" alt="">
            </div>
        </div>
    </section>

 

    @if ($categories->count() > 0)
        <section class="mb-12">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Categories</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                @foreach ($categories as $category)
                    <a href="{{ route('categories.show', $category->slug) }}"
                        class="group    rounded-lg   text-center ">
                        <div class="rounded-md mb-3 overflow-hidden flex justify-center">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($category->name) }}&size=160&background=ef4444&color=fff"
                                alt="{{ $category->name }}"
                                class="w-15 h-15 rounded-full object-cover group-hover:opacity-80 hover:border-orange-700 hover:border-solid transition-opacity ">
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
                <p class="text-gray-600">No products available at the moment.</p>
            </div>
        @endif
    </section>
@endsection
