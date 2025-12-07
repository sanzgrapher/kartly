@php $user = $user ?? $order->user; @endphp
@component('emails.layout', ['title' => 'Order Status Update 📦', 'subtitle' => 'Your order has been updated!'])
    <h2>Order Status Update 🎯</h2>
    <p>Hi {{ $user->name ?? 'Customer' }},</p>
    <p>Great news! Your order status has been updated.</p>

    <div class="info-box">
        <p><strong>Order Information:</strong></p>
        <p>Order #<span class="highlight">{{ $order->id ?? 'N/A' }}</span></p>
        <p>Status: <span
                class="highlight">{{ ucfirst($order->status instanceof \App\Enums\OrderStatus ? $order->status->value : $order->status ?? 'Unknown') }}</span>
        </p>
        <p>Updated: {{ $order->updated_at ? $order->updated_at->format('M d, Y H:i') : date('M d, Y H:i') }}</p>
    </div>

 

    <div
        style="background-color: #fff7ed; padding: 15px; border-radius: 8px; margin: 20px 0; text-align: center; border-left: 4px solid #f97316;">
        <p style="font-size: 13px; color: #92400e; margin: 0;">
            📍 Track your order anytime in your account dashboard
        </p>
    </div>

    <p style="margin-top: 20px;">Thank you for your patience and for shopping with Kartly!</p>

    <p style="margin-top: 30px; font-weight: 600; color: #f97316;">The Kartly Team</p>
@endcomponent
