@props(['product', 'url' => null])

@php
    $url = $url ?? route('products.show', $product->slug ?? $product->id);
    $rating = $product->rating ?? 4.5;
    $review_count = $product->review_count ?? 150;
    $stock_status = $product->stock_status ?? 'In Stock';
    $original_price = $product->original_price ?? null;
@endphp

<div class="group bg-white rounded-xl overflow-hidden border border-gray-200" role="article">
    <div class="relative h-50 bg-gray-900 overflow-hidden">
        <a href="{{ $url }}" class="block w-full h-full">
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
        </a>

        <div class="absolute top-2 right-2  space-y-2">
            <button
                class="w-8 h-8 bg-white/10 backdrop-blur-sm rounded-full flex items-center justify-center text-white hover:bg-white/20 transition-all duration-200 focus:outline-none"
                aria-label="Add to wishlist">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                    </path>
                </svg>
            </button>
            <button
                class="  w-8 h-8 bg-white/10 backdrop-blur-sm rounded-full flex items-center justify-center text-white hover:bg-white/20 transition-all duration-200 focus:outline-none"
                aria-label="Add to wishlist">
                {{-- make an eye svg --}}
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                    </path>
                </svg>

            </button>
        </div>


    </div>

    <div class="p-3">
        <div class="flex items-center justify-between mb-1">
            <span  class="text-xs font-medium text-gray-500 uppercase tracking-wide">{{ $product->category->name ?? 'CATEGORY' }}</span>

        </div>

        <div class=" my-2">
            <h3 class="text-sm font-semibold text-gray-900 line-clamp-2 leading-5">
                <a href="{{ $url }}" class="hover:text-gray-700 transition-colors focus:outline-none">
                    {{ $product->name }}
                </a>
            </h3>
        </div>
        <hr class="my-2 border-gray-200">

        <div class="flex items-center justify-between">
            <div class="flex items-baseline gap-2">
                <span class="text-base font-bold text-gray-900">Rs {{ $product->price }}</span>
                @if ($original_price && $original_price > $product->price)
                    <span class="text-xs text-gray-500 line-through">Rs {{ $original_price }}</span>
                @endif
                <span>-</span>
                @if ($rating && $review_count)
                    <div class="flex items-center gap-1">
                        <svg class="w-3 h-3 text-yellow-400 fill-current" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                        <span class="text-xs text-gray-600 font-medium">{{ $rating }}</span>
                        <span class="text-xs text-gray-400">({{ $review_count }})</span>
                    </div>
                @endif
            </div>

            @unless (request()->routeIs('admin.*'))
                <form action="{{ route('cart.store') }}" method="POST" class="shrink-0">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit"
                        class="p-2 bg-white-900 border border-primary-500 text-primary rounded-lg hover:bg-primary hover:text-white transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-1 disabled:opacity-50 disabled:cursor-not-allowed "
                        {{ $stock_status === 'Out of Stock' ? 'disabled' : '' }}
                        aria-label="Add {{ $product->name }} to cart">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M6.29977 5H21L19 12H7.37671M20 16H8L6 3H3M9 20C9 20.5523 8.55228 21 8 21C7.44772 21 7 20.5523 7 20C7 19.4477 7.44772 19 8 19C8.55228 19 9 19.4477 9 20ZM20 20C20 20.5523 19.5523 21 19 21C18.4477 21 18 20.5523 18 20C18 19.4477 18.4477 19 19 19C19.5523 19 20 19.4477 20 20Z"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            </path>
                        </svg>
                    </button>
                </form>
            @endunless
        </div>
    </div>
</div>
