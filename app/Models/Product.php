<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory, Searchable;

    protected $fillable = [
        'name',
        'slug',
        'image',
        'price',
        'quantity',
        'description',
        'category_id',
    ];

    /**
     * Get the indexable data array for the model.
     */
    public function toSearchableArray()
    {
        return [
            'id' => (string) $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->getAttributes()['price'],
            'quantity' => (int) $this->quantity,
            'category_id' => (int) $this->category_id,
            'category_name' => $this->category?->name ?? '',
            'created_at' => $this->created_at->timestamp,
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function interactions()
    {
        return $this->hasMany(UserProductInteraction::class);
    }

    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }

        return asset('images/product-image.webp');
    }

    public function getStockStatusAttribute()
    {
        if ($this->quantity == 0) {
            return 'Out of Stock';
        } elseif ($this->quantity < 10) {
            return 'Low Stock';
        } else {
            return 'In Stock';
        }
    }



    // public function setPriceAttribute($value)
    // {
    //     $this->attributes['price'] = $value * 100; 
    // }
    // public function getPriceAttribute($value)
    // {
    //     return $value / 100; 
    // }

    protected function price(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value / 100,
            set: fn($value) => $value * 100,
        );
    }
}
