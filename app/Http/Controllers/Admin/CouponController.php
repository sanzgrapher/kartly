<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        if ($search) {
            $coupons = Coupon::where('code', 'like', '%' . $search . '%')
                ->orWhere('type', 'like', '%' . $search . '%')
                ->orderBy('created_at', 'desc')
                ->paginate(10)
                ->withQueryString();
        } else {
            $coupons = Coupon::orderBy('created_at', 'desc')
                ->paginate(10);
        }

        return view('admin.coupons.index', compact('coupons', 'search'));
    }

    public function create()
    {
        return view('admin.coupons.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|string|max:10|regex:/^[A-Z0-9]+$/|unique:coupons,code',
            'type' => 'required|in:percentage,fixed_amount',
            'value' => 'required|numeric|min:0',
            'min_purchase_amount' => 'nullable|numeric|min:0',
            'max_discount_amount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:0',
            'per_user_limit' => 'nullable|integer|min:0|min:1',
            'valid_from' => 'required|date|after_or_equal:now',
            'valid_until' => 'required|date|after:valid_from',
            'is_active' => 'boolean',
        ], [
            'code.regex' => 'Coupon code must contain only uppercase letters and numbers (no spaces or special characters).',
            'code.max' => 'Coupon code must not exceed 10 characters.',
        ]);

        if ($data['type'] === 'percentage' && ($data['value'] < 0 || $data['value'] > 100)) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['value' => 'Percentage value must be between 0 and 100.']);
        }

        if (isset($data['per_user_limit']) && isset($data['usage_limit']) && $data['per_user_limit'] > $data['usage_limit']) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['per_user_limit' => 'Per user limit cannot be greater than total usage limit.']);
        }

        $data['code'] = strtoupper($data['code']);
        $data['is_active'] = $request->has('is_active');

        Coupon::create($data);

        return redirect()->route('admin.coupons.index')->with('success', 'Coupon created successfully.');
    }

    public function show($id)
    {
        $coupon = Coupon::findOrFail($id);

        $orders = $coupon->orders()->with('user')->latest()->paginate(10);

        $stats = [
            'total_orders' => $coupon->orders()->count(),
            'total_discount' => $coupon->orders()->sum('discount_amount'),
            'unique_users' => $coupon->usages()->distinct('user_id')->count(),
            'usage_rate' => $coupon->usage_limit ? ($coupon->usage_count / $coupon->usage_limit) * 100 : null,
        ];

        return view('admin.coupons.show', compact('coupon', 'orders', 'stats'));
    }

    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);

        return view('admin.coupons.edit', compact('coupon'));
    }

    public function update(Request $request, $id)
    {
        $coupon = Coupon::findOrFail($id);

        if ($coupon->usage_count > 0) {
            $data = $request->validate([
                'valid_until' => 'required|date|after:' . $coupon->valid_from->toDateString(),
                'usage_limit' => 'nullable|integer|min:' . $coupon->usage_count,
                'is_active' => 'boolean',
            ]);

                $coupon->update([
                'valid_until' => $data['valid_until'],
                'usage_limit' => $data['usage_limit'] ?? $coupon->usage_limit,
                'is_active' => $request->has('is_active')
            ]);

            return redirect()->route('admin.coupons.index')
                ->with('success', 'Coupon dates and limits updated successfully.');
        }

        $data = $request->validate([
            'code' => 'required|string|max:10|regex:/^[A-Z0-9]+$/|unique:coupons,code,' . $id,
            'type' => 'required|in:percentage,fixed_amount',
            'value' => 'required|numeric|min:0',
            'min_purchase_amount' => 'nullable|numeric|min:0',
            'max_discount_amount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:0',
            'per_user_limit' => 'nullable|integer|min:0',
            'valid_from' => 'required|date',
            'valid_until' => 'required|date|after:valid_from',
            'is_active' => 'boolean',
        ], [
            'code.regex' => 'Coupon code must contain only uppercase letters and numbers (no spaces or special characters).',
            'code.max' => 'Coupon code must not exceed 10 characters.',
        ]);

        if (strtotime($data['valid_from']) > strtotime($data['valid_until'])) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['valid_until' => 'End date must be after start date.']);
        }

        if ($data['usage_limit'] !== null && $data['usage_limit'] < $coupon->usage_count) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['usage_limit' => 'Usage limit cannot be lower than current usage count (' . $coupon->usage_count . ').']);
        }

        if ($data['type'] === 'percentage' && ($data['value'] < 0 || $data['value'] > 100)) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['value' => 'Percentage value must be between 0 and 100.']);
        }

        if (isset($data['per_user_limit']) && isset($data['usage_limit']) && $data['per_user_limit'] > $data['usage_limit']) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['per_user_limit' => 'Per user limit cannot be greater than total usage limit.']);
        }

        $data['code'] = strtoupper($data['code']);
        $data['is_active'] = $request->has('is_active');

        $coupon->update($data);

        return redirect()->route('admin.coupons.index')->with('success', 'Coupon updated successfully.');
    }

    public function toggleActive($id)
    {
        $coupon = Coupon::findOrFail($id);

        $coupon->update([
            'is_active' => !$coupon->is_active
        ]);

        $status = $coupon->is_active ? 'activated' : 'deactivated';
        return redirect()->route('admin.coupons.index')
            ->with('success', "Coupon {$status} successfully.");
    }

    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);

        if ($coupon->usage_count > 0) {
            return redirect()->route('admin.coupons.index')
                ->with('error', 'Cannot delete coupon that has been used.');
        }
        if ($coupon->orders()->exists()) {
            return redirect()->route('admin.coupons.index')
                ->with('error', 'Cannot delete coupon that has associated orders.');
        }
        if ($coupon->usages()->exists()) {
            return redirect()->route('admin.coupons.index')
                ->with('error', 'Cannot delete coupon with existing usage records.');
        }

        $coupon->delete();

        return redirect()->route('admin.coupons.index')->with('success', 'Coupon deleted successfully.');
    }
}
