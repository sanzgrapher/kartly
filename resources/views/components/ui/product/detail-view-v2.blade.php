@props(['product'])

<div class="grid grid-cols-1 lg:grid-cols-5 gap-8 mb-8">
    <x-ui.product.product-image :product="$product" class="lg:col-span-3" />

    <div class="lg:col-span-2 flex flex-col justify-between h-full">
        <div class="space-y-5">
            @if ($product->category)
                <div class="text-sm">
                    <a href="{{ route('categories.show', $product->category->slug) }}"
                        class="text-primary-600 hover:underline font-medium">
                        {{ $product->category->name }}
                    </a>
                </div>
            @endif


           
            <div class="flex items-center space-x-2">
                <span class="text-sm text-green-600 font-medium">{{ $product->stock_status ?? 'In Stock' }}</span>
                <span
                    class="font-semibold {{ $product->stock_status == 'In Stock' ? 'text-green-600' : ($product->stock_status == 'Low Stock' ? 'text-yellow-600' : 'text-red-600') }}">
                    {{ $product->quantity }} left
                </span>

            </div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $product->name }}</h1>

            <div class="relative text-sm text-gray-600 dark:text-gray-300 leading-relaxed prose prose-sm max-w-none dark:prose-invert"
                x-data="{ showDescModal: false }">
                <div class="max-h-[200px] overflow-hidden relative">
                    <div class="description-content min-h-12">
                        {!! $product->description !!}

                    </div>
                    <!-- Fade overlay positioned within the content container -->
                    <div
                        class="absolute bottom-0 left-0 right-0 h-24 bg-gradient-to-t from-white dark:from-gray-900 to-transparent pointer-events-none z-10">
                    </div>
                </div>
                <!-- Read more button outside the faded container -->
                <button @click="showDescModal = true"
                    class="relative z-20 inline-flex items-center gap-1 mt-3 px-3 py-2   dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 hover:bg-primary-100 dark:hover:bg-primary-900/40 rounded-lg text-sm font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500">
                    Read more
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <!-- Description Modal -->
                <template x-teleport="body">
                    <div x-show="showDescModal" x-cloak x-transition.opacity.duration.200
                        class="fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-4"
                        @click="showDescModal = false">
                        <div x-transition.scale.duration.200
                            class="max-w-2xl w-full bg-white dark:bg-gray-900 rounded-lg shadow-lg max-h-[80vh] overflow-y-auto border border-gray-200 dark:border-gray-700"
                            @click.stop>
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-4">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Product Description
                                    </h3>
                                    <button @click="showDescModal = false"
                                        class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                                <div
                                    class="prose prose-sm max-w-none dark:prose-invert text-gray-600 dark:text-gray-300">
                                    {!! $product->description !!}
                                    <br>
                                    High quality product with premium materials for exceptional durability and
                                    performance.
                                    Perfect for everyday
                                    use with modern design and functionality.
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <div class="space-y-3 mt-6">
            <hr class="border-gray-200 dark:border-gray-700">

            <div class="text-3xl font-bold text-gray-900 dark:text-white">
                Rs {{ $product->price }}
            </div>

            {{-- removed colour and size selection per UI change request --}}

            <form action="{{ route('cart.store') }}" method="POST" x-data="{
                quantity: 1,
                maxStock: {{ $product->quantity }},
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
                <input type="hidden" name="product_id" value="{{ $product->id }}">

                <div class="flex items-stretch w-full space-x-2">
                    <div class="flex items-center border border-gray-300 dark:border-gray-600 rounded-lg">
                        <button type="button"
                            :class="[
                                'h-full',
                                'rounded-l-lg',
                                'px-4 py-2 font-semibold',
                                quantity <= 1 ?
                                'bg-gray-100 dark:bg-gray-800 text-gray-400 cursor-not-allowed' :
                                'bg-gray-50 dark:bg-gray-700 hover:bg-primary-500 hover:text-white text-gray-700 dark:text-gray-200'
                            ]"
                            @click="decrease()" :disabled="quantity <= 1">
                            -
                        </button>
                        <input type="number" name="quantity" x-model="quantity" @input="validate()" min="1"
                            max="{{ $product->quantity }}" value="1"
                            class="w-14 px-2 py-2 text-center mx-1 focus:outline-none focus:ring-2 focus:ring-primary-500 border-0 text-xl font-semibold bg-transparent dark:text-white"
                            @if ($product->stock_status == 'Out of Stock') disabled @endif>
                        <button type="button"
                            :class="[
                                'h-full',
                                'rounded-r-lg',
                                'px-4 py-2 font-semibold',
                                quantity >= maxStock ?
                                'bg-gray-100 dark:bg-gray-800 text-gray-400 cursor-not-allowed' :
                                'bg-gray-50 dark:bg-gray-700 hover:bg-primary-500 hover:text-white text-gray-700 dark:text-gray-200'
                            ]"
                            @click="increase()" :disabled="quantity >= maxStock">
                            +
                        </button>
                    </div>
                    <div class="w-full">
                        <button type="submit"
                            class="w-full h-full py-3 border border-primary-500 dark:border-primary-400 text-primary-500 dark:text-primary-400 font-semibold text-xl rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/20 disabled:bg-gray-100 disabled:cursor-not-allowed"
                            @if ($product->stock_status == 'Out of Stock') disabled @endif>
                            Add to Cart
                        </button>
                    </div>
                </div>
            </form>

            @error('quantity')
                <div class="p-3 bg-red-50 border border-red-300 rounded-lg">
                    <p class="text-sm text-red-700">{{ $message }}</p>
                </div>
            @enderror
        </div>


    </div>
</div>
