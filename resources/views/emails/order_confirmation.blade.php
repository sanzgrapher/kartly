@php $user = $user ?? $order->user; @endphp
@component('emails.layout', ['title' => 'Order Confirmed ✓', 'subtitle' => 'Thank you for your purchase!'])
    <h2>Order Confirmed! 🎉</h2>
    <p>Hi {{ $user->name ?? 'Customer' }},</p>
    <p>Great news! We've received your order and are getting it ready to ship. You can track your order status anytime by
        logging into your account.</p>

    <div class="info-box">
        <p><strong>Order Details:</strong></p>
        <p>Order #<span class="highlight">{{ $order->id ?? 'N/A' }}</span></p>
        <p>Date: {{ $order->created_at ? $order->created_at->format('M d, Y') : date('M d, Y') }}</p>
        <p>Total: <span class="highlight">Rs {{ $order->total_amount ?? ($order->total ?? 0) }}</span></p>
    </div>

    @if ($order->items && $order->items->count() > 0)
        <h3>📦 Order Items:</h3>
        <table class="order-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td>{{ $item->product->name ?? 'Product' }}</td>
                        <td style="text-align: center;">{{ $item->quantity }}</td>
                        <td style="text-align: right;">Rs {{ $item->amount_per_item ?? 0 }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div style="background-color: #fff7ed; padding: 15px; border-radius: 8px; margin: 20px 0; text-align: center;">
        <p style="font-size: 13px; color: #92400e; margin: 0;">
            <strong>Next Step:</strong> We'll send you a shipping confirmation with tracking details as soon as your order
            is on its way.
        </p>
    </div>

    <p style="margin-top: 20px;">You can view your full order details and track your shipment anytime by logging into your
        Kartly account.</p>

    <p style="margin-top: 30px; font-weight: 600; color: #f97316;">The Kartly Team</p>
@endcomponent
