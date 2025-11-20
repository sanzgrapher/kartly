<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\Payment\EsewaService;
use App\Enums\PaymentStatus;
use App\Enums\PaymentMethod;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    protected EsewaService $esewaService;

    public function __construct(EsewaService $esewaService)
    {
        $this->esewaService = $esewaService;
    }
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


    public function retryPayment($id)
    {
        $order = Order::with('payment')->findOrFail($id);

        if ($order->user_id !== Auth::id()) {
            return abort(403, 'Unauthorized');
        }


        if (!$order->payment ||$order->payment->payment_method !== PaymentMethod::ESEWA ||$order->payment->payment_status !== PaymentStatus::PENDING
        ) {
            return redirect()->route('orders.show', $id)
                ->with('error', 'This order cannot be retried.');
        }


        $this->esewaService->initiatePayment($order, $order->payment->amount);
    }
}
