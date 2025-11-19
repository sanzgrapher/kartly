@extends('layout.public')

@section('title', 'Checkout')

@section('content')
    <div class="py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Checkout</h1>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded">
                <p class="text-red-800 font-semibold mb-2">Error:</p>
                @foreach ($errors->all() as $error)
                    <p class="text-sm text-red-700">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded">
                <p class="text-red-800 font-semibold">{{ session('error') }}</p>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
             <div class="lg:col-span-2">
                <form action="{{ route('checkout.store') }}" method="POST" class="space-y-8">
                    @csrf

                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-6">Payment Method</h2>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="flex items-center p-3 border border-gray-300 rounded">
                                <input type="radio" name="payment_method" value="cash_on_delivery"
                                    class="w-4 h-4 text-orange-500"
                                    {{ old('payment_method') == 'cash_on_delivery' ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-800">Cash on Delivery (COD)</span>
                            </label>

                            <label class="flex items-center p-3 border border-gray-300 rounded">
                                <input type="radio" name="payment_method" value="esewa" class="w-4 h-4 text-orange-500"
                                    {{ old('payment_method') == 'esewa' ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-800">eSewa</span>
                            </label>
                        </div>
                        @error('payment_method')
                            <p class="text-red-600 text-sm mt-3">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-6">Shipping Address</h2>

                        @if ($addresses->count() > 0)
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-4">Select a Shipping
                                    Address</label>
                                <div class="space-y-3">
                                    @foreach ($addresses as $address)
                                        <label class="flex items-start p-3 border border-gray-300 rounded">
                                            <input type="radio" name="address_id" value="{{ $address->id }}"
                                                class="mt-1 w-4 h-4 text-orange-500"
                                                {{ old('address_id') == $address->id ? 'checked' : '' }}>
                                            <div class="ml-3">
                                                <p class="text-gray-800">{{ $address->street_address_1 }}</p>
                                                @if ($address->street_address_2)
                                                    <p class="text-sm text-gray-600">{{ $address->street_address_2 }}</p>
                                                @endif
                                                <p class="text-sm text-gray-600">{{ $address->city }},
                                                    {{ $address->state }}
                                                    - {{ $address->country }}</p>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="my-6 border-t border-gray-300 pt-6">
                                <a href="{{ route('addresses.create') }}" target="_blank"
                                    class="inline-block text-orange-600 hover:text-orange-700 font-semibold text-sm">
                                    + Add New Address
                                </a>
                                <p class="text-xs text-gray-500 mt-2">(Opens in new tab)</p>
                            </div>

                            <div class="pt-4">
                                <a href="{{ route('addresses.index') }}" target="_blank"
                                    class="text-blue-600 hover:text-blue-700 font-semibold text-sm">
                                    Manage All Addresses
                                </a>
                            </div>
                        @else
                            <p class="text-gray-600 mb-6">You don't have any saved addresses.</p>
                            <a href="{{ route('addresses.create') }}" target="_blank"
                                class="inline-block px-6 py-3 bg-orange-500 text-white font-semibold rounded-lg hover:bg-orange-600 transition">
                                + Add Shipping Address
                            </a>
                            <p class="text-xs text-gray-500 mt-2">(Opens in new tab, then return to checkout)</p>
                        @endif
                    </div>

                    <a href="{{ route('cart.index') }}"
                        class="inline-flex items-center text-orange-600 hover:text-orange-700 font-semibold text-sm">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                            </path>
                        </svg>
                        Back to Cart
                    </a>

                    <button type="submit"
                        class="w-full px-6 py-3 bg-orange-500 text-white font-bold rounded-lg hover:bg-orange-600 transition">
                        Place Order
                    </button>
                </form>
            </div>


            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow p-6 sticky top-20">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">Order Summary</h2>


                    <div class="mb-6 pb-6 border-b border-gray-300 max-h-64 overflow-y-auto">
                        @foreach ($cartItems as $item)
                            <div
                                class="flex justify-between items-start mb-4 pb-4 border-b border-gray-300 last:border-b-0">
                                <div class="flex-grow">
                                    <p class="font-semibold text-gray-800 text-sm">{{ $item->product->name }}</p>
                                    <p class="text-xs text-gray-600 mt-1">Qty: {{ $item->quantity }}</p>
                                </div>
                                <p class="font-semibold text-gray-800 text-sm">Rs
                                    {{ $item->product->price * $item->quantity }}</p>
                            </div>
                        @endforeach
                    </div>


                    <div class="space-y-3 mb-6 pb-6 border-b border-gray-300">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal:</span>
                            <span>Rs {{ $subtotal }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Shipping:</span>
                            <span class="text-green-600 font-semibold">Free</span>
                        </div>
                    </div>

                    <div class="flex justify-between text-xl font-bold text-gray-800">
                        <span>Total:</span>
                        <span>Rs {{ $subtotal }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
