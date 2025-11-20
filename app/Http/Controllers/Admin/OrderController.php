<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Services\Order\Contracts\OrderServiceInterface;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderServiceInterface $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index()
    {
        $orders = $this->orderService->getAllOrdersWithTotals();
        $totalOrders = $this->orderService->countTotalOrders();

        $totalRevenue = $this->orderService->getRealizedRevenue();
        $pendingOrders = $this->orderService->countByStatus('pending');


        $completedPayments = Payment::where('payment_status', 'completed')->count();

        return view('admin.orders.index', compact('orders', 'totalOrders', 'totalRevenue', 'pendingOrders', 'completedPayments'));
    }

    public function show($id)
    {
        $order = $this->orderService->getOrderWithTotals($id);

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $this->orderService->updateStatus($id, $request->status);

        return redirect()->back()->with('success', 'Order status updated successfully.');
    }

    public function updatePaymentStatus(Request $request, $id)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,failed,completed',
        ]);

        $order = Order::findOrFail($id);
        $payment = $order->payment;
        $payment->payment_status = $request->payment_status;
        $payment->save();

        return redirect()->back()->with('success', 'Payment status updated successfully.');
    }
}
