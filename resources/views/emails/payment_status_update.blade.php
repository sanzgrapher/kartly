@php $user = $user ?? $order->user; @endphp
@component('emails.layout', [
    'title' => 'Payment Status Update 💳',
    'subtitle' => 'Your payment has been processed!',
])
    <h2>Payment Status Update 💰</h2>
    <p>Hi {{ $user->name ?? 'Customer' }},</p>
    <p>We've received an update regarding the payment for your order.</p>

    <div class="info-box">
        <p><strong>Order Information:</strong></p>
        <p>Order #<span class="highlight">{{ $order->id }}</span></p>
        <p>Status: <span class="highlight">{{ ucfirst($order->payment->payment_status ?? 'Unknown') }}</span></p>
        <p>Method: {{ $order->payment->payment_method ?? 'N/A' }}</p>
        <p>Amount: <span class="highlight">Rs {{ $order->total ?? 0 }}</span></p>
    </div>

    @if (strtolower($order->payment->payment_status ?? '') === 'completed')
        <div
            style="background-color: #fff7ed; padding: 15px; border-radius: 8px; margin: 20px 0; text-align: center; border-left: 4px solid #f97316;">
            <p style="font-size: 13px; color: #92400e; margin: 0;">
                ✅ <strong>Payment Successful!</strong> Your order is being prepared for shipment.
            </p>
        </div>
    @elseif(strtolower($order->payment->payment_status ?? '') === 'pending')
        <div
            style="background-color: #fff7ed; padding: 15px; border-radius: 8px; margin: 20px 0; text-align: center; border-left: 4px solid #f97316;">
            <p style="font-size: 13px; color: #92400e; margin: 0;">
                ⏳ <strong>Payment Pending</strong> - We're processing your payment. We'll notify you once it's confirmed.
            </p>
        </div>
    @elseif(strtolower($order->payment->payment_status ?? '') === 'failed')
        <div
            style="background-color: #fee2e2; padding: 15px; border-radius: 8px; margin: 20px 0; text-align: center; border-left: 4px solid #f97316;">
            <p style="font-size: 13px; color: #92400e; margin: 0;">
                ❌ <strong>Payment Failed</strong> - Unfortunately, your payment could not be processed. Please try again.
            </p>
        </div>
    @endif

    <p style="margin-top: 20px;">If you have any questions or need assistance, please don't hesitate to reach out to our
        support team.</p>

    <p style="margin-top: 30px; font-weight: 600; color: #f97316;">The Kartly Team</p>
@endcomponent
