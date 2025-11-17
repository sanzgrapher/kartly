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

        foreach ($orders as $order) {
            $total = 0;
            foreach ($order->items as $item) {
                $total += ($item->amount_per_item ?? 0) * ($item->quantity ?? 0);
            }
            $order->total = $total;
        }

        $totalOrders = Order::count();

        $allOrders = Order::with('items')->get();
        $totalRevenue = 0;
        foreach ($allOrders as $order) {
            foreach ($order->items as $item) {
                $totalRevenue += ($item->amount_per_item ?? 0) * ($item->quantity ?? 0);
            }
        }

        $pendingOrders = Order::where('status', 'pending')->count();
        $completedPayments = Payment::where('payment_status', 'completed')->count();

        return view('admin.orders.index', compact('orders', 'totalOrders', 'totalRevenue', 'pendingOrders', 'completedPayments'));
    }

    public function show($id)
    {
        $order = Order::with(['items.product', 'user', 'payment'])->findOrFail($id);

        $total = 0;
        foreach ($order->items as $item) {
            $item->subtotal = ($item->amount_per_item ?? 0) * ($item->quantity ?? 0);
            $total += $item->subtotal;
        }
        $order->total = $total;

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
