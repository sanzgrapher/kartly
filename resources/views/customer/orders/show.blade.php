@extends('layout.public')

@section('title', 'Order #' . $order->id)

@section('content')
    <div class="container mx-auto flex flex-col min-h-screen">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-0 flex-1">

            <div class="md:col-span-1">
                @include('customer.partials.sidebar')
            </div>


            <div class="md:col-span-3 bg-white rounded-r-lg border border-l-0 border-gray-200 p-6">
                <div class="mt-4  bg-white rounded-lg border border-gray-300 p-4">
                    <div class="mb-3 p-3">
                        <h2 class="font-semibold ">Order #{{ $order->id }}</h2>
                        <p class=" text-sm text-gray-400">View order and payment details</p>
                    </div>
                </div>

                <div class="mt-4 bg-white rounded-lg border border-gray-300 p-4">
                    <h2 class="font-semibold mb-3">Order #{{ $order->id }}</h2>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <p class="mt-2"><strong>Order Status:</strong> <span
                                    class="{{ $order->status->value == 'pending' ? 'text-yellow-600' : ($order->status->value == 'processing' ? 'text-blue-600' : ($order->status->value == 'shipped' ? 'text-orange-600' : ($order->status->value == 'delivered' ? 'text-green-600' : 'text-red-600'))) }}">{{ $order->status->value ?? 'n/a' }}</span>
                            </p>
                            <p class="mt-2"><strong>Payment Status:</strong> <span
                                    class="{{ ($order->payment?->payment_status ?? 'pending') == 'pending' ? 'text-yellow-600' : (($order->payment?->payment_status ?? '') == 'completed' ? 'text-green-600' : 'text-red-600') }}">{{ $order->payment->payment_status ?? 'n/a' }}</span>
                            </p>
                        </div>
                        <div>
                            <div class="">
                                <p class="mt-2"><strong>Shipping
                                        Address:</strong><br>{{ $order->shipping_address ?? 'n/a' }}</p>
                                <p class="mt-2"><strong>Payment Method:</strong>
                                    {{ $order->payment->payment_method ?? 'n/a' }}</p>
                                <p class="mt-2"><strong>Created:</strong> {{ $order->created_at->format('M d, Y H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <h3 class="font-medium mb-2">Items</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full table-auto text-left">
                            <thead class="bg-gray-50 border-t border-gray-200">
                                <tr>
                                    <th class="px-3 py-2 text-sm">Product</th>
                                    <th class="px-3 py-2 text-sm">Price</th>
                                    <th class="px-3 py-2 text-sm">Qty</th>
                                    <th class="px-3 py-2 text-sm">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->items as $item)
                                    <tr class="border-t border-gray-300">
                                        <td class="px-3 py-2 text-sm">{{ $item->product->name ?? 'n/a' }}</td>
                                        <td class="px-3 py-2 text-sm">Rs {{ $item->amount_per_item }}</td>
                                        <td class="px-3 py-2 text-sm">{{ $item->quantity ?? 'n/a' }}</td>
                                        <td class="px-3 py-2 text-sm">Rs {{ $item->amount_per_item * $item->quantity }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="text-right mt-4">
                        <strong>Total:</strong> Rs {{ $order->total ?? 0 }}
                    </div>
                </div>

                @if ($order->payment)
                    <div class="mt-4 bg-white rounded-lg border border-gray-300 p-4">
                        <h2 class="font-semibold mb-3">Payment Information</h2>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="mt-2"><strong>Payment Method:</strong>
                                    {{ $order->payment->payment_method ?? 'n/a' }}</p>
                            </div>
                            <div>
                                <p class="mt-2"><strong>Payment Status:</strong> <span
                                        class="{{ $order->payment->payment_status == 'pending' ? 'text-yellow-600' : ($order->payment->payment_status == 'completed' ? 'text-green-600' : 'text-red-600') }}">{{ $order->payment->payment_status ?? 'n/a' }}</span>
                                </p>
                            </div>
                        </div>

                        <p class="mt-2"><strong>Transaction Code:</strong>
                            {{ $order->payment->transaction_code ?? 'n/a' }}</p>
                        <p class="mt-2"><strong>Amount:</strong> Rs {{ $order->payment->amount ?? 0 }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
