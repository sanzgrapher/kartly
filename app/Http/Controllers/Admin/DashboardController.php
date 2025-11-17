<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $revenue = 0;
        $orders = Order::with('items')->get();
        
        foreach ($orders as $order) {
            foreach ($order->items as $item) {
            $revenue += ($item->amount_per_item ?? 0) * ($item->quantity ?? 0);
            }
        }

        $stats = [
            'users' => User::count(),
            'orders' => Order::count(),
            'revenue' => $revenue,
            'products' => Product::count(),
        ];

        $recentUsers = User::latest()->take(8)->get();
        $recentProducts = Product::latest()->take(4)->get();

        return view('admin.dashboard', compact('user', 'stats', 'recentUsers', 'recentProducts'));
    }
    //
}
