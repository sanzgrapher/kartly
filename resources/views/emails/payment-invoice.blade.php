@php $user = $user ?? $order->user; @endphp
@component('emails.layout', ['title' => 'Payment Invoice', 'subtitle' => 'Payment Confirmation & Invoice'])
    <h2>Payment Received! ✓</h2>
    <p>Hi {{ $user->name ?? 'Customer' }},</p>
    <p>Thank you for your payment. Your transaction has been successfully processed. Below is your invoice for this purchase.</p>

    <div class="info-box">
        <p><strong>Invoice Details:</strong></p>
        <p>Order #<span class="highlight">{{ $order->id ?? 'N/A' }}</span></p>
        <p>Invoice Date: {{ now()->format('M d, Y') }}</p>
        <p>Payment Method: {{ ucfirst($order->payment->payment_method?->value ?? 'N/A') }}</p>
        <p>Payment Status: <span class="highlight">{{ ucfirst($order->payment->payment_status?->value ?? 'N/A') }}</span></p>
    </div>

    @if ($order->items && $order->items->count() > 0)
        <h3>📦 Items Purchased:</h3>
        <table class="order-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td>{{ $item->product->name ?? 'Product' }}</td>
                        <td style="text-align: center;">{{ $item->quantity }}</td>
                        <td style="text-align: right;">Rs {{ number_format($item->amount_per_item ?? 0, 2) }}</td>
                        <td style="text-align: right;">Rs {{ number_format(($item->amount_per_item ?? 0) * $item->quantity, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div style="background-color: #f3f4f6; padding: 15px; border-radius: 8px; margin: 20px 0;">
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="padding: 8px 0; text-align: right; font-size: 14px;"><strong>Subtotal:</strong></td>
                <td style="padding: 8px 0; text-align: right; font-size: 14px; width: 120px;">Rs {{ number_format($subtotal, 2) }}</td>
            </tr>
            @if ($discount > 0)
                <tr>
                    <td style="padding: 8px 0; text-align: right; font-size: 14px; color: #059669;"><strong>Discount:</strong></td>
                    <td style="padding: 8px 0; text-align: right; font-size: 14px; color: #059669; width: 120px;">- Rs {{ number_format($discount, 2) }}</td>
                </tr>
            @endif
            <tr style="border-top: 2px solid #d1d5db;">
                <td style="padding: 12px 0; text-align: right; font-size: 16px; font-weight: bold;">Total Paid:</td>
                <td style="padding: 12px 0; text-align: right; font-size: 16px; font-weight: bold; color: #f97316; width: 120px;">Rs {{ number_format($total, 2) }}</td>
            </tr>
        </table>
    </div>

    <div style="background-color: #ecfdf5; padding: 15px; border-radius: 8px; margin: 20px 0; text-align: center;">
        <p style="font-size: 13px; color: #065f46; margin: 0;">
            <strong>✓ Payment Confirmed</strong><br>
            Your payment has been successfully processed and your order is being prepared for shipment.
        </p>
    </div>

    

    <p style="margin-top: 30px; font-weight: 600; color: #f97316;">The Kartly Team</p>
@endcomponent
