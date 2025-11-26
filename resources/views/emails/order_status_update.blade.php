@php $user = $user ?? $order->user; @endphp
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Order Status Update</title>
</head>
<body>
    <h1>Order Status Updated</h1>
    <p>Hi {{ $user->name ?? 'Customer' }},</p>
    <p>Your order (ID: {{ $order->id }}) status is now: <strong>{{ $order->status }}</strong>.</p>
    <p>If you have any questions, reply to this email or contact support.</p>
</body>
</html>
