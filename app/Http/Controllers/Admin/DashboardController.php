<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use App\Enums\PaymentStatus;
use App\Enums\OrderStatus;
use App\Services\Order\Contracts\OrderServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $avgOrderValue = Order::count() > 0 ? $revenue / Order::count() : 0;

        $stats = [
            'users' => User::count(),
            'orders' => $this->orderService->countTotalOrders(),
            'revenue' => $revenue,
            'products' => Product::count(),
            'avgOrderValue' => $avgOrderValue,
        ];

        // Orders per day last 30 days
        $ordersPerDay = Order::where('created_at', '>=', now()->subDays(30))
            ->select(DB::raw("DATE(created_at) as date"), DB::raw('count(*) as count'))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->date => (int) $item->count];
            });

        // Revenue per day last 30 days
        $revenuePerDay = Payment::where('payment_status', PaymentStatus::COMPLETED)
            ->where('created_at', '>=', now()->subDays(30))
            ->whereHas('order', function ($query) {
                $query->where('status', OrderStatus::DELIVERED);
            })
            ->select(DB::raw("DATE(created_at) as date"), DB::raw('sum(amount) as revenue'))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->date => (float) $item->revenue];
            });

        // Order status breakdown
        $orderStatuses = Order::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->status->value => (int) $item->count];
            });

        // Payment method breakdown
        $paymentMethods = Payment::select('payment_method', DB::raw('count(*) as count'))
            ->groupBy('payment_method')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->payment_method->value => (int) $item->count];
            });

        // Recent orders summary
        $recentOrders = Order::with(['user', 'payment'])
            ->latest()
            ->take(5)
            ->get();

        // Prepare chart-friendly arrays for last 30 days
        $ordersLabels = [];
        $ordersData = [];
        $revenueData = [];
        for ($i = 29; $i >= 0; $i--) {
            $d = now()->subDays($i)->format('Y-m-d');
            $ordersLabels[] = $d;
            $ordersData[] = $ordersPerDay->get($d, 0);
            $revenueData[] = $revenuePerDay->get($d, 0);
        }

        $recentUsers = User::latest()->take(8)->get();
        $recentProducts = Product::latest()->take(4)->get();

        return view('admin.dashboard', compact(
            'user',
            'stats',
            'recentUsers',
            'recentProducts',
            'ordersLabels',
            'ordersData',
            'revenueData',
            'orderStatuses',
            'paymentMethods',
            'recentOrders'
        ));
    }
    //
}
