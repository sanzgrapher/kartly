<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Invoice #{{ $order->id }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            font-size: 14px;
            color: #333;
            line-height: 1.5;
        }
        .container {
            width: 100%;
            margin: 0 auto;
        }
        .header {
            margin-bottom: 30px;
            border-bottom: 2px solid #eee;
            padding-bottom: 20px;
        }
        .company-logo {
            font-size: 24px;
            font-weight: bold;
            color: #f97316; /* Orange-500 to match brand */
            text-transform: uppercase;
        }
        .invoice-title {
            font-size: 28px;
            font-weight: bold;
            float: right;
            color: #ccc;
            text-transform: uppercase;
        }
        .row {
            clear: both;
            margin-bottom: 20px;
        }
        .col-left {
            float: left;
            width: 60%;
        }
        .col-right {
            float: right;
            width: 35%;
            text-align: right;
        }
        .meta-table {
            width: 100%;
            text-align: right;
        }
        .meta-table td {
            padding: 3px 0;
        }
        .bill-to p {
            margin: 0;
            padding: 0;
        }
        table.items {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }
        table.items th {
            text-align: left;
            padding: 10px;
            background-color: #f8f8f8;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }
        table.items td {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .totals {
            margin-top: 20px;
            float: right;
            width: 40%;
        }
        .totals table {
            width: 100%;
            border-collapse: collapse;
        }
        .totals td {
            padding: 5px 0;
            text-align: right;
        }
        .total-row td {
            font-weight: bold;
            font-size: 16px;
            border-top: 2px solid #333;
            padding-top: 10px;
        }
        .footer {
            margin-top: 50px;
            border-top: 1px solid #eee;
            padding-top: 20px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="col-left">
                <div class="company-logo">Kartly</div>
            </div>
            <div class="col-right">
                <div class="invoice-title">INVOICE</div>
            </div>
            <div style="clear: both;"></div>
        </div>

        <div class="row">
            <div class="col-left">
                <strong>Bill To:</strong>
                <div class="bill-to">
                    <p>{{ $order->user->name }}</p>
                    <p>{{ $order->user->email }}</p>
                    <p>{{ $order->shipping_address }}</p>
                </div>
            </div>
            <div class="col-right">
                <table class="meta-table">
                    <tr>
                        <td><strong>Invoice #:</strong></td>
                        <td>ORD-{{ $order->id }}</td>
                    </tr>
                    <tr>
                        <td><strong>Date:</strong></td>
                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Payment Method:</strong></td>
                        <td>{{ ucfirst($order->payment->payment_method?->value ?? 'N/A') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Status:</strong></td>
                        <td>{{ ucfirst($order->payment->payment_status?->value ?? 'N/A') }}</td>
                    </tr>
                </table>
            </div>
            <div style="clear: both;"></div>
        </div>

        <table class="items">
            <thead>
                <tr>
                    <th width="50%">Item</th>
                    <th width="15%" class="text-center">Quantity</th>
                    <th width="15%" class="text-right">Price</th>
                    <th width="20%" class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                <tr>
                    <td>{{ $item->product->name ?? 'Product' }}</td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-right">Rs {{ number_format($item->amount_per_item, 2) }}</td>
                    <td class="text-right">Rs {{ number_format(($item->amount_per_item * $item->quantity), 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="totals">
            <table>
                <tr>
                    <td>Subtotal:</td>
                    <td>Rs {{ number_format($order->subtotal ?? $order->items->sum(fn($i) => $i->amount_per_item * $i->quantity), 2) }}</td>
                </tr>
                @if ($order->discount_amount > 0)
                <tr>
                    <td style="color: green;">Discount:</td>
                    <td style="color: green;">- Rs {{ number_format($order->discount_amount, 2) }}</td>
                </tr>
                @endif
                <tr class="total-row">
                    <td>Total:</td>
                    <td>Rs {{ number_format($order->total, 2) }}</td>
                </tr>
            </table>
        </div>
        <div style="clear: both;"></div>

        <div class="footer">
            <p>Thank you for your business!</p>
         </div>
    </div>
</body>
</html>
