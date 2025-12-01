@props(['product'])

<div class="grid grid-cols-1 lg:grid-cols-5 gap-6 mb-4">
    <x-ui.product.image-gallery :product="$product" class="lg:col-span-3 flex gap-3" />

    <div class="lg:col-span-2 flex flex-col justify-between h-full py-2">
        <div class="space-y-4">
            @if ($product->category)
                <a href="{{ route('categories.show', $product->category->slug) }}"
                    class="text-sm text-primary-600 hover:underline font-medium">
                    {{ $product->category->name }}
                </a>
            @endif

            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ $product->name }}</h1>

            @php
                $isNew =
                    isset($product->created_at) &&
                    \Illuminate\Support\Carbon::now()->diffInDays(
                        \Illuminate\Support\Carbon::parse($product->created_at),
                    ) < 5;
            @endphp
            <div class="flex items-center space-x-2">
                <span class="text-sm text-green-600 font-medium"> {{ $product->stock_status ?? 'In Stock' }}</span>
                @if ($isNew)
                    <span class="text-sm bg-green-100 text-green-800 px-2 py-0.5 rounded-full">New</span>
                @endif
            </div>

            <div
                class="relative text-sm text-gray-600 dark:text-gray-300 leading-relaxed prose prose-sm max-w-none dark:prose-invert mt-2 min-h-[100px]">
                <div class="max-h-[120px] overflow-hidden">
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
            <div class="flex items-center  ">
                @unless (request()->routeIs('admin.*'))
                    <form class="space-x-8 w-full" action="{{ route('cart.store') }}" method="POST" class="space-y-0"
                        x-data="{
                            quantity: 1,
                            maxStock: {{ $product->quantity ?? 999 }},
                            increase() {
                                if (this.quantity < this.maxStock) {
                                    this.quantity++;
                                }
                            },
                            decrease() {
                                if (this.quantity > 1) {
                                    this.quantity--;
                                }
                            },
                            validate() {
                                let qty = parseInt(this.quantity);
                                if (isNaN(qty) || qty < 1) {
                                    this.quantity = 1;
                                } else if (qty > this.maxStock) {
                                    this.quantity = this.maxStock;
                                } else {
                                    this.quantity = qty;
                                }
                            }
                        }">
                        @csrf
                        <div>
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" x-bind:value="quantity">

                        </div>

                        <div class="space-y-4 w-full">
                            <div
                                class="inline-flex items-center border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 overflow-hidden">
                                <button type="button"
                                    :class="'px-3 py-2 font-semibold ' + (quantity <= 1 ?
                                        'bg-gray-100 dark:bg-gray-800 text-gray-400 cursor-not-allowed' :
                                        'bg-gray-50 dark:bg-gray-700 hover:bg-primary-500 hover:text-white text-gray-700 dark:text-gray-200'
                                    )"
                                    @click="decrease()" :disabled="quantity <= 1">
                                    -
                                </button>
                                <input type="number" name="quantity_input" x-model="quantity" @input="validate()"
                                    min="1" :max="{{ $product->quantity ?? 999 }}" value="1"
                                    class="w-14 px-2 py-2 text-center focus:outline-none focus:ring-2 focus:ring-primary-500 border-0 text-xl font-semibold bg-transparent dark:text-white">
                                <button type="button"
                                    :class="'px-3 py-2 font-semibold ' + (quantity >= maxStock ?
                                        'bg-gray-100 dark:bg-gray-800 text-gray-400 cursor-not-allowed' :
                                        'bg-gray-50 dark:bg-gray-700 hover:bg-primary-500 hover:text-white text-gray-700 dark:text-gray-200'
                                    )"
                                    @click="increase()" :disabled="quantity >= maxStock">
                                    +
                                </button>
                            </div>

                            <div class="grid grid-cols-2 gap-2 mt-3 w-full">
                                <button type="submit"
                                    class="py-4 grid-cols-1  border border-primary-500 dark:border-primary-400 text-primary-500 dark:text-primary-400 font-semibold text-xl rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/20 disabled:bg-gray-100 disabled:cursor-not-allowed"
                                    @if ($product->stock_status == 'Out of Stock') disabled @endif>
                                    Add to Cart
                                </button>

                                <a href="{{ route('products.show', $product->slug ?? $product->id) }}"
                                    class="py-4 grid-cols-1 w-full inline-flex items-center justify-center border rounded-lg text-sm"
                                    aria-label="View details for {{ $product->name }}">
                                    View details
                                </a>
                            </div>
                        </div>
                    </form>
                @endunless
            </div>
        </div>

    </div>
</div>
