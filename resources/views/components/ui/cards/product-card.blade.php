@props(['product', 'url' => null])

@php
    $url = $url ?? route('products.show', $product->slug ?? $product->id);
    $stock_status = $product->stock_status ?? 'In Stock';
    $original_price = $product->original_price ?? null;
    
@endphp

<div x-data="{ showQuickView: false }"
    class="group bg-white dark:bg-gray-800 rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700"
    role="article">
    <div class="relative h-50 bg-gray-900 overflow-hidden">
        <a href="{{ $url }}" class="block w-full h-full">
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
        </a>

        

        <div class="absolute top-2 right-2  space-y-2">
            @unless (request()->routeIs('admin.*'))
                <button
                    class="w-8 h-8 bg-white/10 backdrop-blur-sm rounded-full flex items-center justify-center text-white hover:bg-white/20 transition-all duration-200 focus:outline-none"
                    aria-label="Quick view" @click.prevent="showQuickView = true">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                        </path>
                    </svg>
                </button>
            @endunless
        </div>


    </div>

    {{-- Quick view modal (teleport to body) --}}
    <template x-teleport="body">
        <div x-show="showQuickView" x-cloak x-transition.opacity.duration.200
            class="fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-2" @click="showQuickView = false">
            <div x-transition.scale.duration.200
                class="max-w-5xl w-full bg-white dark:bg-gray-900 rounded-lg shadow-lg overflow-y-auto border border-gray-200 dark:border-gray-700 max-h-[90vh] relative"
                @click.stop>
                {{-- absolute close button so it doesn't affect layout width --}}
                <button
                    class="absolute top-2 right-2 z-20 p-1 rounded-full bg-white/80 hover:bg-white dark:bg-gray-800 dark:hover:bg-gray-700 shadow-sm"
                    @click="showQuickView = false" aria-label="Close quick view">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <div class="p-3">
                    {{-- lightweight quick view: minimal product info (detail-like layout) --}}
                    <x-ui.product.quick-view :product="$product" />
                </div>
            </div>
        </div>
    </template>

    <div class="p-3">
        <div class="flex items-center justify-between mb-1">
            <span
                class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">{{ $product->category->name ?? 'CATEGORY' }}</span>

        </div>

        <div class=" my-2">
            <h3 class="text-sm font-semibold text-gray-900 dark:text-white line-clamp-2 leading-5">
                <a href="{{ $url }}"
                    class="hover:text-gray-700 dark:hover:text-gray-300 transition-colors focus:outline-none">
                    {{ $product->name }}
                </a>
            </h3>
        </div>
        <hr class="my-2 border-gray-200 dark:border-gray-700">

        <div class="flex items-center justify-between">
            <div class="flex items-baseline gap-2">
                <span class="text-base font-bold text-gray-900 dark:text-white">Rs {{ $product->price }}</span>
                @if ($original_price && $original_price > $product->price)
                    <span class="text-xs text-gray-500 dark:text-gray-400 line-through">Rs {{ $original_price }}</span>
                @endif
                {{-- New pill displayed on image (top-left) only; removed from price area --}}
            </div>

            @unless (request()->routeIs('admin.*'))
                <form action="{{ route('cart.store') }}" method="POST" class="shrink-0">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit"
                        class="p-2 bg-white dark:bg-gray-700 border border-primary-500 dark:border-primary-400 text-primary dark:text-primary-400 rounded-lg hover:bg-primary hover:text-white dark:hover:bg-primary-600 dark:hover:text-white transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-1 disabled:opacity-50 disabled:cursor-not-allowed "
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
