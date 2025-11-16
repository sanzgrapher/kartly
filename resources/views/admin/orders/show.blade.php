@extends('layout.admin')

@section('title', 'Order #' . $order->id)

@section('content')
    <div class="bg-white rounded-lg border border-gray-300 p-4">
        <h2 class="font-semibold mb-3">Order #{{ $order->id }}</h2>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <p><strong>User:</strong> {{ $order->user->name ?? 'n/a' }}</p>
                <p><strong>Order Status:</strong> <span class="{{ $order->status == 'pending' ? 'text-yellow-600' : ($order->status == 'processing' ? 'text-blue-600' : ($order->status == 'shipped' ? 'text-orange-600' : ($order->status == 'delivered' ? 'text-green-600' : 'text-red-600'))) }}">{{ $order->status ?? 'n/a' }}</span></p>
                <p><strong>Payment Status:</strong> <span class="{{ $order->payment->payment_status == 'pending' ? 'text-yellow-600' : ($order->payment->payment_status == 'completed' ? 'text-green-600' : 'text-red-600') }}">{{ $order->payment->payment_status ?? 'n/a' }}</span></p>
                <p><strong>Shipping Address:</strong><br>{{ $order->shipping_address ?? 'n/a' }}</p>
                <p><strong>Payment Method:</strong> {{ $order->payment->payment_method ?? 'n/a' }}</p>
                <p><strong>Created:</strong> {{ $order->created_at->format('M d, Y H:i') }}</p>
            </div>
            <div>
                <div class="mt-4">
                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="flex items-end space-x-2">
                        @csrf
                        @method('PATCH')
                        <div class="flex-1">
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Update Status</label>
                            <select name="status" id="status" class="block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <div>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-3 rounded-md transition duration-150 text-sm">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @if(session('success'))
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
                            <td class="px-3 py-2 text-sm">${{ number_format($item->amount_per_item / 100, 2) }}</td>
                            <td class="px-3 py-2 text-sm">{{ $item->quantity ?? 'n/a' }}</td>
                            <td class="px-3 py-2 text-sm">${{ number_format($item->subtotal / 100, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4 text-right">



            <strong>Total:</strong> ${{ number_format($order->total / 100, 2) }}
        </div>
    </div>
@endsection
