@props(['product'])

<div class="grid grid-cols-1 lg:grid-cols-5 gap-6 ">
    <x-ui.product.product-image :product="$product" class="lg:col-span-3" />

    <div class="lg:col-span-2 flex flex-col justify-between h-full py-2">
        <div class="space-y-4">
            @if ($product->category)
                <a href="{{ route('categories.show', $product->category->slug) }}"
                    class="text-sm text-primary-600 hover:underline font-medium">
                    {{ $product->category->name }}
                </a>
            @endif

            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ $product->name }}</h1>

            <div class="flex items-center space-x-2">
                <span class="text-sm text-green-600 font-medium"> {{ $product->stock_status ?? 'In Stock' }}</span>

            </div>

            <div
                class="relative text-sm text-gray-600 dark:text-gray-300 leading-relaxed prose prose-sm max-w-none dark:prose-invert mt-2 min-h-[50px]">
                <div class="max-h-[50px] overflow-hidden">
                    <div class="description-content">
                        {!! $product->description !!}
                    </div>
                </div>
                <!-- Fade overlay -->
                <div
                    class="absolute bottom-0 left-0 right-0 h-8 bg-gradient-to-t from-white dark:from-gray-900 to-transparent pointer-events-none">
                </div>
            </div>

            <hr class="border-gray-200 dark:border-gray-700 mt-3">


        </div>

        <div class="space-y-8">
            <div class="text-3xl font-bold text-gray-900 dark:text-white mt-3">
                Rs {{ $product->price }}
            </div>
            <div class="flex items-center w-full">
                @unless (request()->routeIs('admin.*'))
                    <div class="w-full space-y-4">
                        @livewire('add-to-cart', [
                            'productId' => $product->id,
                            'maxStock' => $product->quantity ?? 999,
                            'stockStatus' => $product->stock_status,
                            'showQuantitySelector' => true,
                        ])

                        <a href="{{ route('products.show', $product->slug ?? $product->id) }}"
                            class="py-4 w-full inline-flex items-center justify-center border border-gray-300 dark:border-gray-600 rounded-lg text-sm hover:bg-gray-50 dark:hover:bg-gray-800 transition"
                            aria-label="View details for {{ $product->name }}">
                            View details
                        </a>
                    </div>
                @endunless
            </div>
        </div>

    </div>
</div>
