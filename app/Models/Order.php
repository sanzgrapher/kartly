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
    ];


    protected $casts = [
        'status' => OrderStatus::class,
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

    public function getTotalAttribute()
    {

        if ($this->payment) {
            return $this->payment->amount;
        }

        return $this->items()->get()->sum(function ($item) {
            return $item->amount_per_item * $item->quantity;
        });
    }
}
