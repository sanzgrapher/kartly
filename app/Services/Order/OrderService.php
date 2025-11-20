<?php

namespace App\Services\Order;

use App\Services\Order\Contracts\OrderServiceInterface;
use App\Models\Order;
use App\Models\Payment;
use App\Enums\PaymentStatus;
use App\Enums\OrderStatus;

class OrderService implements OrderServiceInterface
{


    public function attachTotalsToOrder($order)
    {
        $total = 0;
        foreach ($order->items as $item) {
            $item->subtotal = ($item->amount_per_item ?? 0) * ($item->quantity ?? 0);
            $total += $item->subtotal;
        }
        $order->total = $total;

        return $order;
    }

    public function calculateTotalRevenue($orders)
    {
        $totalRevenue = 0;
        foreach ($orders as $order) {
            foreach ($order->items as $item) {
                $totalRevenue += ($item->amount_per_item ?? 0) * ($item->quantity ?? 0);
            }
        }

        return $totalRevenue;
    }

    public function updateStatus($orderId, string $status)
    {
        $order = Order::findOrFail($orderId);
        $order->update(['status' => $status]);

        return $order;
    }

    public function getOrderWithTotals($orderId)
    {
        $order = Order::with(['items.product', 'user', 'payment'])->findOrFail($orderId);

        return $this->attachTotalsToOrder($order);
    }

    public function countByStatus(string $status)
    {
        return Order::where('status', $status)->count();
    }
    public function countTotalOrders()
    {
        return  Order::count();
    }


    public function getAllOrdersWithTotals()
    {
        $orders = Order::with(['items.product', 'user', 'payment'])->paginate(15);

        foreach ($orders as $order) {
            $this->attachTotalsToOrder($order);
        }

        return $orders;
    }

    public function getRealizedRevenue()
    {
        return Payment::where('payment_status', PaymentStatus::COMPLETED)
            ->whereHas('order', function ($query) {
                $query->where('status', OrderStatus::DELIVERED);
            })
            ->sum('amount');
    }
}
