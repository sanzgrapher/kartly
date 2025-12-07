<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CouponService
{
    /**
     * Validate coupon and return result
     */
    public function validateCoupon(string $code, User $user, float $subtotal): array
    {
        $coupon = Coupon::where('code', strtoupper($code))->first();

        if (!$coupon) {
            return ['valid' => false, 'message' => 'Invalid coupon code.'];
        }

        if (!$coupon->is_active) {
            return ['valid' => false, 'message' => 'This coupon is no longer active.'];
        }

        $now = Carbon::now();
        if ($now->lt($coupon->valid_from) || $now->gt($coupon->valid_until)) {
            return ['valid' => false, 'message' => 'This coupon has expired.'];
        }

        if ($coupon->usage_limit && $coupon->usage_count >= $coupon->usage_limit) {
            return ['valid' => false, 'message' => 'This coupon has reached its usage limit.'];
        }

        if ($coupon->per_user_limit) {
            $userUsageCount = CouponUsage::where('coupon_id', $coupon->id)
                ->where('user_id', $user->id)
                ->count();

            if ($userUsageCount >= $coupon->per_user_limit) {
                return ['valid' => false, 'message' => 'You have already used this coupon the maximum number of times.'];
            }
        }

        if ($coupon->min_purchase_amount && $subtotal < $coupon->min_purchase_amount) {
            return [
                'valid' => false,
                'message' => "Minimum purchase of Rs " . number_format($coupon->min_purchase_amount, 2) . " required."
            ];
        }

        $discountAmount = $this->calculateDiscount($coupon, $subtotal);

        return [
            'valid' => true,
            'message' => 'Coupon applied successfully!',
            'discount_amount' => $discountAmount,
            'coupon' => [
                'id' => $coupon->id,
                'code' => $coupon->code,
                'type' => $coupon->type,
                'value' => $coupon->value,
            ]
        ];
    }

    /**
     * Calculate discount amount
     */
    public function calculateDiscount(Coupon $coupon, float $subtotal): float
    {
        if ($coupon->type === 'percentage') {
            $discount = ($subtotal * $coupon->value) / 100;

            // Apply max discount cap if set
            if ($coupon->max_discount_amount && $discount > $coupon->max_discount_amount) {
                $discount = $coupon->max_discount_amount;
            }

            return round($discount, 2);
        }

        // Fixed amount - cannot exceed subtotal
        return min($coupon->value, $subtotal);
    }

    /**
     * Record coupon usage
     */
    public function recordUsage(Coupon $coupon, User $user, int $orderId, float $discountAmount): void
    {
        DB::transaction(function () use ($coupon, $user, $orderId, $discountAmount) {
            // Double-check coupon is still valid and within limits
            if (!$coupon->is_active) {
                throw new \Exception('Coupon is no longer active.');
            }

            if ($coupon->usage_limit && $coupon->usage_count >= $coupon->usage_limit) {
                throw new \Exception('Coupon has reached its usage limit.');
            }

            CouponUsage::create([
                'coupon_id' => $coupon->id,
                'user_id' => $user->id,
                'order_id' => $orderId,
                'discount_amount' => $discountAmount,
            ]);

            $coupon->increment('usage_count');
        });
    }

    /**
     * Refund coupon usage (for order cancellation)
     */
    public function refundUsage(int $orderId): void
    {
        $usage = CouponUsage::where('order_id', $orderId)->first();

        if ($usage) {
            // Prevent usage_count from going negative
            if ($usage->coupon->usage_count > 0) {
                $usage->coupon->decrement('usage_count');
            }
            $usage->delete();
        }
    }

    /**
     * Check if coupon can be applied to a specific order
     */
    public function canApplyToOrder(Coupon $coupon, User $user, float $subtotal): bool
    {
        $validation = $this->validateCoupon($coupon->code, $user, $subtotal);
        return $validation['valid'];
    }

    /**
     * Check if coupon can be modified (edited or deleted)
     */
    public function canBeModified(Coupon $coupon): bool
    {
        return $coupon->usage_count === 0;
    }
}
