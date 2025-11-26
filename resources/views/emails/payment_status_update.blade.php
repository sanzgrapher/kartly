@php $user = $user ?? $order->user; @endphp
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payment Status Update</title>
</head>
<body>
    <h1>Payment Update</h1>
    <p>Hi {{ $user->name ?? 'Customer' }},</p>
    <p>The payment for your order (ID: {{ $order->id }}) is now: <strong>{{ $order->payment->payment_status ?? 'unknown' }}</strong>.</p>
    <p>If this was unexpected, please contact support.</p>
</body>
</html>
