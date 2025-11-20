<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use App\Services\Order\Contracts\OrderServiceInterface;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected $orderService;

    public function __construct(OrderServiceInterface $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index()
    {
        $user = Auth::user();
        $revenue = $this->orderService->getRealizedRevenue();

        $stats = [
            'users' => User::count(),
            'orders' => $this->orderService->countTotalOrders(),
            'revenue' => $revenue,
            'products' => Product::count(),
        ];

        $recentUsers = User::latest()->take(8)->get();
        $recentProducts = Product::latest()->take(4)->get();

        return view('admin.dashboard', compact('user', 'stats', 'recentUsers', 'recentProducts'));
    }
    //
}
