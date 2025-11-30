<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\OrderStatus;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'shipping_address',
        'coupon_id',
        'discount_amount',
        'subtotal',
    ];


    protected $casts = [
        'status' => OrderStatus::class,
        'discount_amount' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function orderItem()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function items()
    {
        return $this->orderItem();
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function getTotalAttribute()
    {
        if ($this->payment) {
            return $this->payment->amount;
        }

        // Use stored subtotal and discount if available
        if ($this->subtotal > 0) {
            return $this->subtotal - ($this->discount_amount ?? 0);
        }

        return $this->items()->get()->sum(function ($item) {
            return $item->amount_per_item * $item->quantity;
        });
    }
}
