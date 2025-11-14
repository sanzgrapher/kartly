<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'items'])->orderBy('created_at', 'desc')->paginate(20);

        $orders->each(function ($order) {
            $order->total = $order->items->sum(function ($item) {
                return ($item->amount_per_item ?? 0) * ($item->quantity ?? 0);
            });
        });

        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['items.product', 'user', 'payment'])->findOrFail($id);

        $order->items->each(function ($item) {
            $item->subtotal = (float) ($item->amount_per_item ?? 0) * (int) ($item->quantity ?? 0);
        });

        $order->total = $order->items->sum('subtotal');

        return view('admin.orders.show', compact('order'));
    }
}
