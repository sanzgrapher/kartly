@php $customer = $order->user ?? null; @endphp
@component('emails.layout', ['title' => 'New Order Alert 📦', 'subtitle' => 'A new order has been received!'])
    <h2>New Order Received 🎉</h2>
    <p>Great news! A new order has just been placed on Kartly.</p>

    <div class="info-box">
        <p><strong>Order Details:</strong></p>
        <p>Order #<span class="highlight">{{ $order->id }}</span></p>
        <p>Customer: {{ $customer->name ?? 'Guest' }} ({{ $customer->email ?? 'N/A' }})</p>
        <p>Date: {{ $order->created_at ? $order->created_at->format('M d, Y H:i') : date('M d, Y H:i') }}</p>
        @if($order->discount_amount > 0)
            <p>Subtotal: Rs {{ number_format($order->subtotal, 2) }}</p>
            <p>Discount: - Rs {{ number_format($order->discount_amount, 2) }}</p>
        @endif
        <p>Total: <span class="highlight">Rs {{ number_format($order->total, 2) }}</span></p>
    </div>

    @if ($order->items && $order->items->count() > 0)
        <h3>📦 Order Items:</h3>
        <table class="order-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td>{{ $item->product->name ?? 'Product' }}</td>
                        <td style="text-align: center;">{{ $item->quantity }}</td>
                        <td style="text-align: right;">Rs {{ $item->amount_per_item ?? 0 }}</td>
                        <td style="text-align: right; font-weight: 600;">
                            Rs {{ ($item->amount_per_item ?? 0) * $item->quantity }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div style="background-color: #fff7ed; padding: 15px; border-radius: 8px; margin: 20px 0; text-align: center;">
        <p style="font-size: 13px; color: #92400e; margin: 0;">
            <strong>Action Required:</strong> Please review and process this order in your admin panel.
        </p>
    </div>

    <p style="margin-top: 30px; font-weight: 600; color: #f97316;">The Kartly Team</p>
@endcomponent
