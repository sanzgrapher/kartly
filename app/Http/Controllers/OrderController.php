<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\Payment\EsewaService;
use App\Services\Order\Contracts\OrderServiceInterface;
use App\Enums\PaymentStatus;
use App\Enums\PaymentMethod;
use App\Enums\OrderStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    protected EsewaService $esewaService;
    protected OrderServiceInterface $orderService;

    public function __construct(EsewaService $esewaService, OrderServiceInterface $orderService)
    {
        $this->esewaService = $esewaService;
        $this->orderService = $orderService;
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

    public function cancel($id)
    {
        $order = Order::with('items.product')->findOrFail($id);

        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        if ($order->status !== OrderStatus::PENDING) {
            return back()->with('error', 'Only pending orders can be cancelled.');
        }

        try {
            DB::beginTransaction();

            $this->orderService->updateStatus($id, OrderStatus::CANCELLED->value);

            DB::commit();

            return back()->with('success', 'Order cancelled successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to cancel order: ' . $e->getMessage());
        }
    }
}
