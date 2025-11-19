@extends('layout.public')

@section('title', 'My Orders')

@section('content')
    <div class="container mx-auto flex flex-col min-h-screen">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-0 flex-1">

            <div class="md:col-span-1">
                @include('customer.partials.sidebar')
            </div>


            <div class="md:col-span-3 bg-white rounded-r-lg border border-l-0 border-gray-200 p-6">
                <div class="mb-8">
                    <h1 class="text-3xl font-semibold mb-2">My Orders</h1>
                    <p class="text-gray-600">Track and manage all your orders</p>
                </div>

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

                @if ($orders->count() > 0)
                    <div class="mt-8 bg-white rounded-lg border border-gray-300">

                        <div class="overflow-x-auto">
                            <table class="w-full table-auto text-left">
                                <thead class="  border-t border-gray-200">
                                    <tr>
                                        <th class="p-4 text-sm">ID</th>
                                        <th class="p-4 text-sm">Date</th>
                                        <th class="p-4 text-sm">Total</th>
                                        <th class="p-4 text-sm">Order Status</th>
                                        <th class="p-4 text-sm">Payment Status</th>
                                        <th class="p-4 text-sm">Payment Method</th>
                                        <th class="p-4 text-sm">Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr class="border-t  border-gray-300">
                                            <td class="p-4 text-sm">{{ $order->id }}</td>

                                            <td class="p-4 text-sm">{{ $order->created_at->format('M d, Y') }}</td>
                                            <td class="p-4 text-sm">Rs {{ $order->total ?? 0 }}</td>
                                            <td
                                                class="p-4 text-sm {{ $order->status->value == 'pending' ? 'text-yellow-600' : ($order->status->value == 'processing' ? 'text-blue-600' : ($order->status->value == 'shipped' ? 'text-orange-600' : ($order->status->value == 'delivered' ? 'text-green-600' : 'text-red-600'))) }}">
                                                {{ $order->status->value ?? 'n/a' }}</td>
                                            <td
                                                class="p-4 text-sm {{ ($order->payment->payment_status ?? 'pending') == 'pending' ? 'text-yellow-600' : (($order->payment->payment_status ?? '') == 'completed' ? 'text-green-600' : 'text-red-600') }}">
                                                {{ $order->payment->payment_status ?? 'n/a' }}</td>
                                            <td
                                                class="p-4 text-sm {{ ($order->payment->payment_method ?? '') == 'cash_on_delivery' ? 'text-green-600' : (($order->payment->payment_method ?? '') == 'esewa' ? 'text-blue-600' : 'text-gray-600') }}">
                                                {{ $order->payment->payment_method ?? 'n/a' }}</td>
                                            <td class="flex px-4 py-2 space-x-2">
                                                <a class="px-2 py-1 text-xs text-white bg-blue-500 rounded hover:bg-blue-600"
                                                    href="{{ route('orders.show', $order->id) }}" title="View">
                                                    View
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="mt-4 p-4">
                                {{ $orders->links() }}
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-white rounded-lg border border-gray-300 p-8 text-center mt-8">
                        <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">No Orders Yet</h3>

                        <a href="{{ route('home') }}"
                            class="inline-block px-6 py-3 bg-orange-500 text-white font-semibold rounded-lg hover:bg-orange-600 transition">
                            Continue Shopping
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
