<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of active and non-expired coupons for marketing page
     */
    public function index()
    {
        $coupons = Coupon::where('is_active', true)
            ->where('valid_from', '<=', now())
            ->where('valid_until', '>=', now())
            ->where(function ($query) {
                $query->whereNull('usage_limit')
                    ->orWhereColumn('usage_count', '<', 'usage_limit');
            })
            ->orderBy('valid_until', 'asc')
            ->get();

        return view('coupons.index', compact('coupons'));
    }
}
