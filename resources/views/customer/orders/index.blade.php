@extends('layout.public')

@section('title', 'My Orders')

@section('content')
    <div class="container mx-auto flex flex-col min-h-screen">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-0 flex-1">

            <div class="md:col-span-1">
                @include('customer.partials.sidebar')
            </div>


            <div
                class="md:col-span-3 bg-white dark:bg-gray-800 rounded-r-lg border border-l-0 border-gray-200 dark:border-gray-700 p-6">
                <div class="mb-8">
                    <h1 class="text-3xl font-semibold mb-2 dark:text-white">My Orders</h1>
                    <p class="text-gray-600 dark:text-gray-400">Track and manage all your orders</p>
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
                    <div class="mt-8 bg-white dark:bg-gray-800 rounded-lg border border-gray-300 dark:border-gray-700">

                        <div class="overflow-x-auto">
                            <table class="w-full table-auto text-left">
                                <thead class="  border-t border-gray-200 dark:border-gray-700 dark:text-gray-300">
                                    <tr>
                                        <th class="p-4 text-sm text-left">ID</th>
                                        <th class="p-4 text-sm text-left">Date</th>
                                        <th class="p-4 text-sm text-left">Total</th>
                                        <th class="p-4 text-sm text-left">Order Status</th>
                                        <th class="p-4 text-sm text-left">Payment Status</th>
                                        <th class="p-4 text-sm text-left">Payment Method</th>
                                        <th class="p-4 text-sm text-left">Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr class="border-t  border-gray-300 dark:border-gray-700 dark:text-gray-300">
                                            <td class="p-4 text-sm">{{ $order->id }}</td>

                                            <td class="p-4 text-sm">{{ $order->created_at->format('M d, Y') }}</td>
                                            <td class="p-4 text-sm">Rs {{ number_format($order->total, 2) }}</td>
                                            <td class="p-4 text-sm">
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    {{ $order->status->value == 'pending'
                                                        ? 'bg-yellow-100 text-yellow-800'
                                                        : ($order->status->value == 'processing'
                                                            ? 'bg-blue-100 text-blue-800'
                                                            : ($order->status->value == 'shipped'
                                                                ? 'bg-orange-100 text-orange-800'
                                                                : ($order->status->value == 'delivered'
                                                                    ? 'bg-green-100 text-green-800'
                                                                    : 'bg-red-100 text-red-800'))) }}">
                                                    {{ ucfirst($order->status->value ?? 'n/a') }}
                                                </span>
                                            </td>
                                            <td class="p-4 text-sm">
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    {{ ($order->payment->payment_status->value ?? 'pending') == 'pending'
                                                        ? 'bg-yellow-100 text-yellow-800'
                                                        : (($order->payment->payment_status->value ?? '') == 'completed'
                                                            ? 'bg-green-100 text-green-800'
                                                            : 'bg-red-100 text-red-800') }}">
                                                    {{ ucfirst($order->payment->payment_status->value ?? 'n/a') }}
                                                </span>
                                            </td>
                                            <td class="p-4 text-sm">
                                                @if ($order->payment && $order->payment->payment_method)
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $order->payment->payment_method->badgeClass() }}">
                                                        {{ $order->payment->payment_method->label() }}
                                                    </span>
                                                @else
                                                    <span class="text-gray-500 dark:text-gray-400">N/A</span>
                                                @endif
                                            </td>
                                            <td class="p-4 text-sm">
                                                <a class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-blue-600 text-white hover:bg-blue-700 active:bg-blue-800 shadow-sm hover:shadow-md transition-all duration-200 transform hover:scale-105"
                                                    href="{{ route('orders.show', $order->id) }}">
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
                    <div
                        class="bg-white dark:bg-gray-800 rounded-lg border border-gray-300 dark:border-gray-700 p-8 text-center mt-8">
                        <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">No Orders Yet</h3>

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
