@php $customer = $order->user ?? null; @endphp
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Order Received</title>
</head>
<body>
    <h1>New Order Received</h1>
    <p>Order ID: {{ $order->id }}</p>
    <p>Customer: {{ $customer->name ?? 'Guest' }} ({{ $customer->email ?? 'N/A' }})</p>
    <p>Total: {{ number_format($order->total ?? 0, 2) }}</p>
    <p>Please review the order in the admin panel.</p>
</body>
</html>
