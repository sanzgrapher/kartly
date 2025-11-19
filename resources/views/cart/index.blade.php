@extends('layout.public')

@section('title', 'Shopping Cart')

@section('content')
    <div class="py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Shopping Cart</h1>

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

        @if ($cartItems->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow">
                        @forelse ($cartItems as $item)
                            <div
                                class="flex gap-4 p-6 border-b border-gray-300 last:border-b-0 hover:bg-gray-50 transition">

                                <div class="flex-shrink-0 w-24 h-24 bg-gray-100 rounded overflow-hidden">
                                    <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}"
                                        class="w-full h-full object-cover">
                                </div>


                                <div class="flex-grow">
                                    <h3 class="font-semibold text-gray-800 mb-1">
                                        <a href="{{ route('products.show', $item->product->slug) }}"
                                            class="hover:text-orange-600 transition">
                                            {{ $item->product->name }}
                                        </a>
                                    </h3>
                                    <p class="text-sm text-gray-600 mb-2">
                                        Price: <span class="font-semibold">Rs {{ $item->product->price }}</span>
                                    </p>
                                    <p class="text-sm text-gray-600 mb-1">
                                        Subtotal: <span class="font-semibold">Rs
                                            {{ $item->product->price * $item->quantity }}</span>
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        Available Stock: <span
                                            class="font-semibold text-gray-700">{{ $item->product->quantity }}</span>
                                    </p>
                                </div>


                                <div class="flex flex-col items-end justify-between gap-3">
                                    <div class="flex items-center border border-gray-300 rounded overflow-hidden">
                                        <button type="button"
                                            class="qty-decrease px-3 py-1 bg-gray-100 hover:bg-gray-200 transition font-semibold text-gray-700"
                                            data-item-id="{{ $item->id }}" onclick="decreaseQty({{ $item->id }})">
                                            -
                                        </button>
                                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1"
                                            max="{{ $item->product->quantity }}" data-item-id="{{ $item->id }}"
                                            id="qty-{{ $item->id }}"
                                            class="quantity-input w-20 px-2 py-1 text-center focus:outline-none focus:ring-2 focus:ring-orange-500 border-0">
                                        <button type="button"
                                            class="qty-increase px-3 py-1 bg-gray-100 hover:bg-gray-200 transition font-semibold text-gray-700"
                                            data-item-id="{{ $item->id }}" onclick="increaseQty({{ $item->id }})">
                                            +
                                        </button>
                                    </div>

                                    <form action="{{ route('cart-items.update', $item->id) }}" method="POST"
                                        class="w-full">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="quantity" id="form-qty-{{ $item->id }}"
                                            value="{{ $item->quantity }}">
                                        <button type="submit"
                                            class="update-btn w-full px-3 py-2 bg-gray-300 text-gray-500 text-sm font-semibold rounded cursor-not-allowed transition disabled"
                                            data-item-id="{{ $item->id }}" data-original-qty="{{ $item->quantity }}"
                                            disabled>
                                            Update Cart
                                        </button>
                                    </form>

                                    <form action="{{ route('cart-items.destroy', $item->id) }}" method="POST"
                                        class="w-full" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="w-full px-3 py-2 text-red-600 hover:text-red-800 text-sm font-semibold transition border border-red-200 rounded hover:bg-red-50">
                                            Remove
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="p-6 text-center text-gray-600">
                                No items in cart
                            </div>
                        @endforelse
                    </div>
                </div>


                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow p-6 sticky top-20">
                        <h2 class="text-xl font-semibold text-gray-800 mb-6">Order Summary</h2>

                        <div class="space-y-4 mb-6 pb-6 border-b border-gray-300">
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal:</span>
                                <span>Rs {{ $total }}</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Shipping:</span>
                                <span class="text-green-600 font-semibold">Free</span>
                            </div>
                        </div>

                        <div class="flex justify-between text-xl font-bold text-gray-800 mb-6">
                            <span>Total:</span>
                            <span>Rs {{ $total }}</span>
                        </div>

                        <a href="{{ route('checkout') }}"
                            class="block w-full px-6 py-3 bg-orange-500 text-white font-semibold rounded hover:bg-orange-600 transition text-center mb-3">
                            Proceed to Checkout
                        </a>

                        <a href="{{ route('home') }}"
                            class="block w-full px-6 py-3 border border-gray-300 text-gray-800 font-semibold rounded text-center hover:bg-gray-50 transition">
                            Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-white rounded-lg shadow p-12 text-center">
                <div class="mb-6">
                    <svg class="w-20 h-20 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>

                <h2 class="text-2xl font-bold text-gray-800 mb-2">Your cart is empty</h2>
                <p class="text-gray-600 mb-8">Looks like you haven't added any products yet. Start shopping now!</p>

                <a href="{{ route('home') }}"
                    class="inline-block px-8 py-3 bg-orange-500 text-white font-semibold rounded hover:bg-orange-600 transition">
                    Continue Shopping
                </a>
            </div>
        @endif
    </div>

    <script>
        function increaseQty(itemId) {
            const input = document.getElementById('qty-' + itemId);
            const maxQty = parseInt(input.getAttribute('max'));
            let currentQty = parseInt(input.value);

            if (currentQty < maxQty) {
                input.value = currentQty + 1;
                document.getElementById('form-qty-' + itemId).value = input.value;
                updateButtonState(itemId);
            }
        }

        function decreaseQty(itemId) {
            const input = document.getElementById('qty-' + itemId);
            let currentQty = parseInt(input.value);

            if (currentQty > 1) {
                input.value = currentQty - 1;
                document.getElementById('form-qty-' + itemId).value = input.value;
                updateButtonState(itemId);
            }
        }

        function updateButtonState(itemId) {
            const input = document.getElementById('qty-' + itemId);
            const button = document.querySelector('.update-btn[data-item-id="' + itemId + '"]');
            const originalQty = parseInt(button.getAttribute('data-original-qty'));
            const currentQty = parseInt(input.value);

            if (currentQty !== originalQty) {
                button.disabled = false;
                button.classList.remove('bg-gray-300', 'text-gray-500', 'cursor-not-allowed', 'disabled');
                button.classList.add('bg-orange-500', 'text-white', 'hover:bg-orange-600');
            } else {

                button.disabled = true;
                button.classList.add('bg-gray-300', 'text-gray-500', 'cursor-not-allowed', 'disabled');
                button.classList.remove('bg-orange-500', 'text-white', 'hover:bg-orange-600');
            }
        }

        document.querySelectorAll('.quantity-input').forEach(input => {
            input.addEventListener('input', function() {
                const itemId = this.getAttribute('data-item-id');
                document.getElementById('form-qty-' + itemId).value = this.value;
                updateButtonState(itemId);
            });
        });
    </script>
@endsection
