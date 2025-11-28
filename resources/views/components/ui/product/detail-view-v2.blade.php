@props(['product'])

<div class="grid grid-cols-1 lg:grid-cols-5 gap-8 mb-8">
    <div class="lg:col-span-3 flex gap-4" x-data="{ currentImage: '{{ $product->image_url }}' }">
        <div class="flex flex-col justify-between w-[120px] h-[500px]">
            <div class="bg-gray-50 rounded border-2 border-blue-400 w-[120px] h-[120px] cursor-pointer"
                @click="currentImage = '{{ $product->image_url }}'">
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
            </div>
            <div class="bg-gray-50 rounded border-2 hover:border-blue-400 w-[120px] h-[120px] cursor-pointer"
                @click="currentImage = 'https://placehold.co/600x400?text=Img\n1'">
                <img src="https://placehold.co/600x400?text=Img\n1" alt="{{ $product->name }}"
                    class="w-full h-full object-cover">
            </div>
            <div class="bg-gray-50 rounded border-2 hover:border-blue-400 w-[120px] h-[120px] cursor-pointer"
                @click="currentImage = 'https://placehold.co/600x400?text=Img\n2'">
                <img src="https://placehold.co/600x400?text=Img\n2" alt="{{ $product->name }}"
                    class="w-full h-full object-cover">
            </div>
            <div class="bg-gray-50 rounded border-2 hover:border-blue-400 w-[120px] h-[120px] cursor-pointer"
                @click="currentImage = 'https://placehold.co/600x400?text=Img\n3'">
                <img src="https://placehold.co/600x400?text=Img\n3" alt="{{ $product->name }}"
                    class="w-full h-full object-cover">
            </div>
        </div>

        <div class="w-full bg-gray-50 rounded-2xl h-[500px]">
            <img :src="currentImage" alt="{{ $product->name }}" class="w-full h-full object-cover">
        </div>
    </div>

    <div class="lg:col-span-2 space-y-3" x-data="{
    
        category: '{{ $product->category->name }}',
        selectedColor: 'green',
        selectedSize: 'M',
        showBuyModal: false,
        colors: [
            { name: 'gray', class: 'bg-gray-400' },
            { name: 'green', class: 'bg-green-500' },
            { name: 'blue', class: 'bg-blue-500' }
        ],
        sizes: ['XS', 'S', 'M', 'L', 'XL']
    }">
        @if ($product->category)
            <div class="text-sm">
                {{-- <a href="{{ route('categories.show', $product->category->slug) }}"
                    class="text-primary-600 hover:underline font-medium">
                    {{ $product->category->name }}
                </a> --}}
                <a   x-text="category" href="{{ route('categories.show', $product->category->slug) }}"
                    class="text-primary-600 hover:underline font-medium">
                    
                </a>
            </div>
        @endif

        <h1 class="text-2xl font-bold text-gray-900">{{ $product->name }}</h1>

        <div class="flex items-center space-x-2">
            <div class="flex items-center space-x-1">

                <svg class="w-4 h-4 text-primary-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
                <svg class="w-4 h-4 text-primary-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
                <svg class="w-4 h-4 text-primary-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>

                <svg class="w-4 h-4 text-gray-300" viewBox="0 0 20 20" fill="none" stroke="currentColor"
                    stroke-width="1.5" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
                <svg class="w-4 h-4 text-gray-300" viewBox="0 0 20 20" fill="none" stroke="currentColor"
                    stroke-width="1.5" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
                <svg class="w-4 h-4 text-gray-300" viewBox="0 0 20 20" fill="none" stroke="currentColor"
                    stroke-width="1.5" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>

            </div>
            <span class="text-sm text-gray-600">(150 Reviews)</span>&nbsp;| &nbsp;
            <span class="text-sm text-green-600 font-medium"> In Stock</span> &nbsp;|&nbsp;
            <span
                class="font-semibold {{ $product->stock_status == 'In Stock' ? 'text-green-600' : ($product->stock_status == 'Low Stock' ? 'text-yellow-600' : 'text-red-600') }}">
                {{ $product->quantity }} left
            </span>
        </div>

        <div class="text-3xl font-bold text-gray-900">
            Rs {{ $product->price }}
        </div>

        <p class="text-sm text-gray-600 leading-relaxed">
            {{ $product->description }} <br>
            High quality product with premium materials for exceptional durability and performance. Perfect for everyday
            use with modern design and functionality.
        </p>

        <hr class="border-gray-200">

        <div class="space-y-4">
            <div class="flex items-center space-x-4">
                <h3 class="text-xl font-medium text-gray-900">Colours:</h3>
                <div class="flex space-x-3">
                    <template x-for="color in colors">
                        <button class='w-7 h-7 rounded-full border-2 -all' type="button"
                            @click="selectedColor = color.name"
                            :class="[color.class,
                                selectedColor === color.name ?
                                'border-primary-500 ' :
                                'border-gray-300 '
                            ]"></button>
                    </template>
                </div>
            </div>

            <div class="flex items-center space-x-4">
                <h3 class="text-xl font-medium text-gray-900">Size:</h3>
                <div class="flex space-x-3">
                    <template x-for="size in sizes" :key="size">
                        <button class='px-3 py-1.5 border rounded-lg text-sm font-medium' type="button"
                            @click="selectedSize = size"
                            :class="selectedSize === size ?
                                'border-primary-500 bg-primary-500 text-white' :
                                'border-gray-300 text-gray-700'"
                            x-text="size"></button>
                    </template>
                </div>
            </div>
        </div>

        <form action="{{ route('cart.store') }}" method="POST" class="space-y-4" x-data="{
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

            <div class="flex items-center space-x-2">
                <div class="flex items-center border border-gray-300 rounded-lg ">
                    <button type="button"
                        :class="[
                            'px-3 py-2  font-semibold',
                            quantity <= 1 ?
                            'bg-gray-100 text-gray-400 cursor-not-allowed' :
                            'bg-gray-50 hover:bg-primary-500 hover:text-white text-gray-700'
                        ]"
                        @click="decrease()" :disabled="quantity <= 1">
                        -
                    </button>
                    <input type="number" name="quantity" x-model="quantity" @input="validate()" min="1"
                        max="{{ $product->quantity }}" value="1"
                        class="w-14 px-2 py-2 text-center focus:outline-none focus:ring-2 focus:ring-primary-500 border-0 text-xl font-semibold"
                        @if ($product->stock_status == 'Out of Stock') disabled @endif>
                    <button type="button"
                        :class="[
                            'px-3 py-2  font-semibold',
                            quantity >= maxStock ?
                            'bg-gray-100 text-gray-400 cursor-not-allowed' :
                            'bg-gray-50 hover:bg-primary-500 hover:text-white text-gray-700'
                        ]"
                        @click="increase()" :disabled="quantity >= maxStock">
                        +
                    </button>
                </div>

                <button type="button"
                    class="p-2 border border-gray-300 rounded-lg hover:border-primary-500 hover:text-primary-500 ">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                </button>
            </div>

            <div class="grid grid-cols-2 gap-2">
                <button type="button"
                    class="py-4 bg-primary-500 text-white font-semibold text-xl rounded-lg hover:bg-primary-600 disabled:bg-gray-400 disabled:cursor-not-allowed"
                    @click="showBuyModal = true" @if ($product->stock_status == 'Out of Stock') disabled @endif>
                    Buy Now
                </button>

                <button type="submit"
                    class="py-4  border border-primary-500 text-primary-500 font-semibold text-xl rounded-lg hover:bg-primary-50  disabled:bg-gray-100 disabled:cursor-not-allowed"
                    @if ($product->stock_status == 'Out of Stock') disabled @endif>
                    Add to Cart
                </button>
            </div>
        </form>

        <div class="border border-gray-200 rounded-lg p-3 space-y-2 bg-gray-50">
            <div class="flex items-center space-x-3">

                <div>
                    <h4 class="font-semibold text-gray-900 text-sm">Free Delivery</h4>
                    <p class="text-xs text-gray-600">Enter your postal code for Delivery Availability</p>
                </div>
            </div>

            <hr>
            <div class="flex items-center space-x-3">

                <div>
                    <h4 class="font-semibold text-gray-900 text-sm">Return Delivery</h4>
                    <p class="text-xs text-gray-600">Free 30 Days Delivery Returns. <span
                            class="text-primary-600 underline ">Details</span></p>
                </div>
            </div>
        </div>



        @error('quantity')
            <div class="p-3 bg-red-50 border border-red-300 rounded-lg">
                <p class="text-sm text-red-700">{{ $message }}</p>
            </div>
        @enderror

        <template x-teleport="body">
            <div x-show="showBuyModal" class="fixed inset-0 z-50   bg-opacity-50 flex items-center justify-center p-4"
                @click="showBuyModal = false">
                <div class="bg-white rounded-lg p-6 max-w-md w-full" @click.stop>
                    <h3 class="text-xl font-bold mb-4">Confirm Your Purchase</h3>

                    <div class="space-y-3">
                        <div>
                            <span class="text-gray-600">Product:</span>
                            <span class="font-medium">{{ $product->name }}</span>
                        </div>

                        <div>
                            <span class="text-gray-600">Price:</span>
                            <span class="font-medium">Rs {{ $product->price }}</span>
                        </div>

                        <div>
                            <span class="text-gray-600">Color:</span>


                            <span class="font-medium capitalize" x-text="selectedColor"></span>

                        </div>

                        <div>
                            <span class="text-gray-600">Size:</span>
                            <span class="font-medium" x-text="selectedSize"></span>
                        </div>

                    </div>

                    <div class="flex space-x-3 mt-6">
                        <button class="flex-1 bg-gray-200 text-gray-700 py-2 rounded-lg hover:bg-gray-300"
                            @click="showBuyModal = false">
                            Cancel
                        </button>

                    </div>
                </div>
            </div>
        </template>
    </div>
</div>
