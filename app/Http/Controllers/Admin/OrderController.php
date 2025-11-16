<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'items', 'payment'])->orderBy('created_at', 'desc')->paginate(20);

        $orders->each(function ($order) {
            $order->total = $order->items->sum(function ($item) {
                return ($item->amount_per_item ?? 0) * ($item->quantity ?? 0);
            });
        });

        $totalOrders = Order::count();
        $totalRevenue = Order::with('items')->get()->sum(function ($order) {
            return $order->items->sum(function ($item) {
                return ($item->amount_per_item ?? 0) * ($item->quantity ?? 0);
            });
        });
        $pendingOrders = Order::where('status', 'pending')->count();
        $completedPayments = Payment::where('payment_status', 'completed')->count();

        return view('admin.orders.index', compact('orders', 'totalOrders', 'totalRevenue', 'pendingOrders', 'completedPayments'));
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

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Order status updated successfully.');
    }
}
