@extends('layout.admin')

@section('title', 'Order #' . $order->id)

@section('content')
    <div class="mt-4  bg-white dark:bg-gray-800 rounded-lg border border-gray-300 dark:border-gray-700 p-4 transition-colors duration-300">
        <div class="mb-3 p-3">
            <h2 class="font-semibold dark:text-white">Update Order Status</h2>
            <p class=" text-sm text-gray-400">Up the order and payment status</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                @if ($order->status->value !== 'cancelled')
                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST"
                        class="flex items-end space-x-2">
                        @csrf
                        @method('PATCH')
                        <div class="flex-1">
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Update Status</label>
                            <select name="status" id="status"
                                class="block w-full pl-3 pr-10 py-2 text-base border border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md dark:bg-gray-700 dark:text-white">
                                <option value="{{ $order->status->value }}" selected>{{ ucfirst($order->status->value) }}
                                </option>

                                @if ($order->status->value == 'pending')
                                    <option value="processing">Processing</option>
                                    <option value="cancelled">Cancelled</option>
                                @elseif($order->status->value == 'processing')
                                    <option value="shipped">Shipped</option>
                                    <option value="cancelled">Cancelled</option>
                                @elseif($order->status->value == 'shipped')
                                    <option value="delivered">Delivered</option>
                                    <option value="cancelled">Cancelled</option>
                                @endif
                            </select>
                        </div>
                        <div>
                            <button type="submit"
                                class="bg-orange-600 hover:bg-orange-700 text-white font-medium py-2 px-3 rounded-md transition duration-150 text-sm">
                                Update
                            </button>
                        </div>
                    </form>
                @endif
            </div>
            <div>

                @if (
                    $order->status->value !== 'cancelled' &&
                        $order->payment->payment_status->value !== 'completed' &&
                        $order->payment->payment_method->value == 'cash_on_delivery')
                    <form action="{{ route('admin.orders.updatePaymentStatus', $order->id) }}" method="POST"
                        class="flex items-end space-x-2">
                        @csrf
                        @method('PATCH')
                        <div class="flex-1">
                            <label for="payment_status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Update Payment
                                Status</label>
                            <select name="payment_status" id="payment_status"
                                class="block w-full pl-3 pr-10 py-2 text-base border border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md dark:bg-gray-700 dark:text-white">
                                <option value="pending"
                                    {{ $order->payment->payment_status->value == 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="failed"
                                    {{ $order->payment->payment_status->value == 'failed' ? 'selected' : '' }}>Failed
                                </option>
                                <option value="completed"
                                    {{ $order->payment->payment_status->value == 'completed' ? 'selected' : '' }}>Completed
                                </option>
                            </select>
                        </div>
                        <div>
                            <button type="submit"
                                class="bg-orange-600 hover:bg-orange-700 text-white font-medium py-2 px-3 rounded-md transition duration-150 text-sm">
                                Update
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>

    </div>
    <div class="mt-4 bg-white dark:bg-gray-800 rounded-lg border border-gray-300 dark:border-gray-700 p-4 transition-colors duration-300">
        <h2 class="font-semibold mb-3 dark:text-white">Order #{{ $order->id }}</h2>

        <div class="grid grid-cols-2 gap-4 mb-4 dark:text-gray-300">
            <div>
                <p class="mt-2"><strong>User:</strong> {{ $order->user->name ?? 'n/a' }}</p>
                    <strong>Order Status:</strong> 
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                        {{ $order->status->value == 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                           ($order->status->value == 'processing' ? 'bg-blue-100 text-blue-800' : 
                           ($order->status->value == 'shipped' ? 'bg-orange-100 text-orange-800' : 
                           ($order->status->value == 'delivered' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'))) }}">
                        {{ ucfirst($order->status->value ?? 'n/a') }}
                    </span>
                </p>
                <p class="text-sm text-gray-700 dark:text-gray-300 mb-2">
                    <strong>Payment Status:</strong> 
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                        {{ $order->payment->payment_status->value == 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                           ($order->payment->payment_status->value == 'completed' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                        {{ ucfirst($order->payment->payment_status->value ?? 'n/a') }}
                    </span>
                </p>

            </div>
            <div>
                <div class="">
                    <p class="mt-2"><strong>Shipping Address:</strong><br>{{ $order->shipping_address ?? 'n/a' }}</p>
                    <p class="mt-2"><strong>Payment Method:</strong> {{ $order->payment->payment_method ?? 'n/a' }}</p>
                    <p class="mt-2"><strong>Created:</strong> {{ $order->created_at->format('M d, Y H:i') }}</p>



                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <h3 class="font-medium mb-2 dark:text-white">Items</h3>
        <div class="overflow-x-auto">
            <table class="w-full table-auto text-left">
                <thead class="bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-700 dark:text-gray-300">
                    <tr>
                        <th class="px-3 py-2 text-sm">Product</th>
                        <th class="px-3 py-2 text-sm">Price</th>
                        <th class="px-3 py-2 text-sm">Qty</th>
                        <th class="px-3 py-2 text-sm">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->items as $item)
                        <tr class="border-t border-gray-300 dark:border-gray-700 dark:text-gray-300">
                            <td class="px-3 py-2 text-sm">{{ $item->product->name ?? 'n/a' }}</td>
                            <td class="px-3 py-2 text-sm">Rs {{ $item->amount_per_item }}</td>
                            <td class="px-3 py-2 text-sm">{{ $item->quantity ?? 'n/a' }}</td>
                            <td class="px-3 py-2 text-sm">Rs {{ $item->subtotal }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="text-right mt-4 space-y-2">
            @if($order->discount_amount > 0)
                <p class="text-gray-600 dark:text-gray-400">Subtotal: Rs {{ number_format($order->subtotal, 2) }}</p>
                <p class="text-green-600 dark:text-green-400">Discount: - Rs {{ number_format($order->discount_amount, 2) }}</p>
            @endif
            <p class="text-xl font-bold dark:text-white">Total: Rs {{ number_format($order->total, 2) }}</p>
        </div>
    </div>




@endsection
