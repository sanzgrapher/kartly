@extends('layout.admin')

@section('title', 'Order #' . $order->id)

@section('content')
    <div class="bg-white rounded-lg border p-4">
        <h2 class="font-semibold mb-3">Order #{{ $order->id }}</h2>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <p><strong>User:</strong> {{ $order->user->name ?? 'n/a' }}</p>
                <p><strong>Status:</strong> {{ $order->status ?? 'n/a' }}</p>
            </div>
            <div>

                <p><strong>Shipping Address:</strong><br>{{ $order->shipping_address ?? 'n/a' }}</p>

                <p><strong>Created:</strong> {{ $order->created_at->format('M d, Y H:i') }}</p>
            </div>
        </div>

        <h3 class="font-medium mb-2">Items</h3>
        <div class="overflow-x-auto">
            <table class="w-full table-auto text-left">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 py-2 text-sm">Product</th>
                        <th class="px-3 py-2 text-sm">Price</th>
                        <th class="px-3 py-2 text-sm">Qty</th>
                        <th class="px-3 py-2 text-sm">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->items as $item)
                        <tr class="border-t">
                            <td class="px-3 py-2 text-sm">{{ $item->product->name ?? 'n/a' }}</td>
                            <td class="px-3 py-2 text-sm">{{ $item->amount_per_item ?? 'n/a' }}</td>
                            <td class="px-3 py-2 text-sm">{{ $item->quantity ?? 'n/a' }}</td>
                            <td class="px-3 py-2 text-sm">{{ $item->subtotal ?? 'n/a' }}</td>
                        </tr>
                    @endforeach    
                </tbody>     
            </table>
        </div>

        <div class="mt-4 text-right">



            <strong>Total:</strong> {{ $order->total ?? 'n/a' }}
        </div>
    </div>
@endsection
