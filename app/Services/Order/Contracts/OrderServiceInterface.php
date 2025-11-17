<?php

namespace App\Services\Order\Contracts;

use App\Models\Order;
use App\Models\Cart;

interface OrderServiceInterface
{
	public function attachTotalsToOrder($order);
	public function calculateTotalRevenue($orders);
	public function updateStatus($orderId, string $status);
	public function getOrderWithTotals($orderId);
	public function countTotalOrders();
	public function countByStatus(string $status);
}
