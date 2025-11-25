@props(['product', 'url' => null])

@php
  $url = $url ?? route('products.show', $product->slug ?? $product->id);
@endphp

<div class="block bg-white rounded-lg border border-gray-200 hover:shadow-md transition-shadow relative group">
    <a href="{{ $url }}" class="block" aria-label="View {{ $product->name }}">
        <div class="h-40 rounded-tl-lg rounded-tr-lg bg-gray-100 overflow-hidden flex items-center justify-center">
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="object-cover h-full w-full">
        </div>

        <div class="mt-2 pb-4 px-3">
            <div class="text-xs text-gray-500">{{ $product->category->name ?? 'n/a' }}</div>
            <h3 class="text-sm font-semibold text-gray-800 truncate">{{ $product->name }}</h3>
            <div class="mt-4 font-bold text-sm text-green-600">Rs {{ $product->price }}</div>
        </div>
    </a>
    @unless(request()->routeIs('admin.*'))
        <form action="{{ route('cart.store') }}" method="POST" class="absolute bottom-2 right-2 z-10">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="quantity" value="1">
            <button type="submit" class="p-2 bg-orange-600 text-white rounded-full hover:bg-orange-700 transition-colors shadow-sm" aria-label="Add to cart">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6.29977 5H21L19 12H7.37671M20 16H8L6 3H3M9 20C9 20.5523 8.55228 21 8 21C7.44772 21 7 20.5523 7 20C7 19.4477 7.44772 19 8 19C8.55228 19 9 19.4477 9 20ZM20 20C20 20.5523 19.5523 21 19 21C18.4477 21 18 20.5523 18 20C18 19.4477 18.4477 19 19 19C19.5523 19 20 19.4477 20 20Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </button>
        </form>
    @endunless
</div>
