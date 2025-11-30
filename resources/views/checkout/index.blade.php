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

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8" x-data="couponComponent()">
             <div class="lg:col-span-2">
                <form action="{{ route('checkout.store') }}" method="POST" class="space-y-8">
                    @csrf

                    <!-- Hidden input to submit coupon code with form -->
                    <input type="hidden" name="coupon_code" :value="isApplied ? couponCode : ''"/>

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

                    <!-- Coupon Section -->
                    <div class="mb-6 pb-6 border-b border-gray-300">
                        <h3 class="text-sm font-semibold text-gray-700 mb-3">Have a Coupon Code?</h3>
                        
                        <!-- Coupon Input -->
                        <div class="flex gap-2 mb-3" x-show="!isApplied">
                            <input 
                                type="text" 
                                x-model="couponCode"
                                @input="clearMessages()"
                                placeholder="Enter code"
                                class="flex-1 px-3 py-2 border border-gray-300 rounded text-sm"
                                :disabled="isValidating"
                            />
                            <button 
                                type="button"
                                @click="validateCoupon()"
                                :disabled="!couponCode || isValidating"
                                class="px-4 py-2 bg-orange-500 text-white text-sm font-semibold rounded hover:bg-orange-600 transition disabled:opacity-50 disabled:cursor-not-allowed"
                                x-text="isValidating ? 'Checking...' : 'Apply'"
                            ></button>
                        </div>

                        <!-- Error Message -->
                        <div x-show="errorMessage" 
                             x-text="errorMessage" 
                             class="text-red-600 text-sm mb-2"
                        ></div>

                        <!-- Success Message -->
                        <div x-show="isApplied" class="bg-green-50 border border-green-200 rounded p-3">
                            <div class="flex justify-between items-start mb-2">
                                <div class="text-sm">
                                    <span class="font-semibold text-green-800" x-text="couponCode"></span>
                                    <span class="text-green-600"> applied!</span>
                                </div>
                                <button 
                                    type="button"
                                    @click="removeCoupon()" 
                                    class="text-red-600 hover:underline text-xs"
                                >Remove</button>
                            </div>
                            <div class="text-xs text-gray-700">
                                <span x-show="couponDetails.type === 'percentage'">
                                    <span x-text="couponDetails.value"></span>% discount - You save Rs <span x-text="discountAmount.toFixed(2)"></span>
                                </span>
                                <span x-show="couponDetails.type === 'fixed_amount'">
                                    Flat Rs <span x-text="couponDetails.value"></span> off - You save Rs <span x-text="discountAmount.toFixed(2)"></span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Discount Line (if applied) -->
                    <div class="space-y-3 mb-6 pb-6 border-b border-gray-300">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal:</span>
                            <span>Rs <span x-text="subtotal.toFixed(2)"></span></span>
                        </div>
                        <div x-show="discountAmount > 0" class="flex justify-between text-green-600">
                            <span>Discount:</span>
                            <span>- Rs <span x-text="discountAmount.toFixed(2)"></span></span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Shipping:</span>
                            <span class="text-green-600 font-semibold">Free</span>
                        </div>
                    </div>

                    <div class="flex justify-between text-xl font-bold text-gray-800">
                        <span>Total:</span>
                        <span>Rs <span x-text="finalTotal.toFixed(2)"></span></span>
                    </div>

                    <script>
                    function couponComponent() {
                        return {
                            couponCode: '',
                            isValidating: false,
                            isApplied: false,
                            errorMessage: '',
                            discountAmount: 0,
                            couponDetails: {},
                            subtotal: {{ $subtotal }},
                            
                            get finalTotal() {
                                return this.subtotal - this.discountAmount;
                            },
                            
                            clearMessages() {
                                this.errorMessage = '';
                            },
                            
                            async validateCoupon() {
                                if (!this.couponCode.trim()) return;
                                
                                this.isValidating = true;
                                this.errorMessage = '';
                                
                                try {
                                    const response = await fetch(`/api/coupon/validate?code=${encodeURIComponent(this.couponCode)}&subtotal=${this.subtotal}`, {
                                        headers: {
                                            'Accept': 'application/json',
                                            'X-Requested-With': 'XMLHttpRequest'
                                        }
                                    });
                                    
                                    const data = await response.json();
                                    
                                    if (data.valid) {
                                        this.isApplied = true;
                                        this.discountAmount = data.discount_amount;
                                        this.couponDetails = data.coupon;
                                    } else {
                                        this.errorMessage = data.message;
                                    }
                                } catch (error) {
                                    this.errorMessage = 'Failed to validate coupon. Please try again.';
                                } finally {
                                    this.isValidating = false;
                                }
                            },
                            
                            removeCoupon() {
                                this.couponCode = '';
                                this.isApplied = false;
                                this.discountAmount = 0;
                                this.couponDetails = {};
                                this.errorMessage = '';
                            }
                        }
                    }
                    </script>
                </div>
            </div>
        </div>
    </div>


@endsection
