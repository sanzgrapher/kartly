@extends('layout.public')

@section('title', $product->name . ' - Shop')

@section('content')

    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded">
            <p class="text-red-800 font-semibold mb-2">Error:</p>
            @foreach ($errors->all() as $error)
                <p class="text-sm text-red-700">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    @if (session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded">
            <p class="text-green-800 font-semibold">{{ session('success') }}</p>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded">
            <p class="text-red-800 font-semibold">{{ session('error') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">

        <div class="bg-gray-100 rounded-lg overflow-hidden flex items-center justify-center h-96">
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
        </div>

        <div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $product->name }}</h1>

            <p class="text-sm text-gray-600 mb-4">
                @if ($product->category)
                    <a href="{{ route('categories.show', $product->category->slug) }}"
                        class="text-orange-600 hover:underline px-3">
                        {{ $product->category->name }}
                    </a>
                @endif
                |

                @if ($product->stock_status == 'In Stock')
                    <span class="inline-block px-3 py-1   text-green-800 rounded-full text-sm ">
                        {{ $product->stock_status }}
                    </span>
                @elseif($product->stock_status == 'Low Stock')
                    <span class="inline-block px-3 py-1   text-yellow-800 rounded-full text-sm ">
                        {{ $product->stock_status }}
                    </span>
                @else
                    <span class="inline-block px-3 py-1   text-red-800 rounded-full text-sm ">
                        {{ $product->stock_status }}
                    </span>
                @endif

                |

                <span class="font-semibold px-3 text-gray-800">{{ $product->quantity }}</span>

            </p>







            @if ($product->description)
                <div class="border-t py-6 border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-800 mb-3">Description</h2>
                    <p class="text-gray-700 leading-relaxed">{{ $product->description }}</p>
                </div>
            @endif
            
            <div class="mb-6">
                <p class="text-4xl text-orange-600">Rs {{ $product->price }}</p>
            </div>
            



            @auth

                <form action="{{ route('cart.store') }}" method="POST" class="flex items-center gap-4 mb-6">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="flex items-center border border-gray-300 rounded overflow-hidden">
                        <button type="button"
                            class="qty-decrease px-3 py-1 bg-gray-100 hover:bg-gray-200 transition font-semibold text-gray-700"
                            data-item-id="product" onclick="decreaseQty()">
                            −
                        </button>
                        <input type="number" name="quantity" id="productQuantity" min="1"
                            max="{{ $product->quantity }}" value="1"
                            class="w-20 px-2 py-1 text-center focus:outline-none focus:ring-2 focus:ring-orange-500 border-0"
                            @if ($product->stock_status == 'Out of Stock') disabled @endif>
                        <button type="button"
                            class="qty-increase px-3 py-1 bg-gray-100 hover:bg-gray-200 transition font-semibold text-gray-700"
                            data-item-id="product" onclick="increaseQty()">
                            +
                        </button>
                    </div>
                    <button type="submit"
                        class="px-6 py-3 bg-orange-500 text-white font-semibold rounded hover:bg-orange-600 transition disabled:bg-gray-400 disabled:cursor-not-allowed"
                        @if ($product->stock_status == 'Out of Stock') disabled @endif>
                        Add to Cart
                    </button>
                </form>
                @error('quantity')
                    <div class="p-3 bg-red-50 border border-red-300 rounded mb-6">
                        <p class="text-sm text-red-700">{{ $message }}</p>
                    </div>
                @enderror

                <script>
                    const maxQty = {{ $product->quantity }};
                    const quantityInput = document.getElementById('productQuantity');

                    function increaseQty() {
                        let currentQty = parseInt(quantityInput.value);
                        if (currentQty < maxQty) {
                            quantityInput.value = currentQty + 1;
                        }
                    }

                    function decreaseQty() {
                        let currentQty = parseInt(quantityInput.value);
                        if (currentQty > 1) {
                            quantityInput.value = currentQty - 1;
                        }
                    }
                </script>
            @else
                <div class="my-6 p-4 bg-blue-50 border border-gray-200 rounded">
                    <p class="text-sm text-blue-800">
                        <a href="{{ route('login') }}" class="font-semibold text-blue-600 hover:underline">Sign in</a>
                        to add this product to your cart
                    </p>
                </div>
            @endauth



        </div>
    </div>

    @if ($product->category && $product->category->products()->where('id', '!=', $product->id)->count() > 0)
        <div class="border-t pt-12">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Related Products</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach ($product->category->products()->where('id', '!=', $product->id)->limit(4)->get() as $relatedProduct)
                    <x-ui.cards.product-card :product="$relatedProduct" />
                @endforeach
            </div>
        </div>
    @endif
@endsection
