<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $orders = $user->orders()->with('payment', 'items.product')->paginate(10);

        return view('customer.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with('payment', 'items.product', 'user')->findOrFail($id);

        if ($order->user_id !== Auth::id()) {
            return abort(403, 'Unauthorized');
        }

        return view('customer.orders.show', compact('order'));
    }
}
