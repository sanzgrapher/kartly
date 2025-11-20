<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $totalOrders = $user->orders()->count();
        $totalSpent = $user->payments()->where('payment_status', \App\Enums\PaymentStatus::COMPLETED)->sum('amount') ?? 0;

        return view('customer.dashboard', compact('user', 'totalOrders', 'totalSpent'));
    }
}
