@php $user = $user ?? $order->user; @endphp
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Order Confirmation</title>
</head>
<body>
    <h1>Thank you for your order, {{ $user->name ?? 'Customer' }}!</h1>
    <p>Order ID: {{ $order->id }}</p>
    <p>Order Total: {{ number_format($order->total ?? 0, 2) }}</p>
    <p>We are processing your order and will update you when its status changes.</p>
</body>
</html>
