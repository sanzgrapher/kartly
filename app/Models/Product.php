<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

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

    public function toSearchableArray()
    {
        return [
            'id' => (string) $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => (float) $this->price,
            'quantity' => (int) $this->quantity,
            'category_id' => (int) $this->category_id,
            'created_at' => $this->created_at->timestamp,
        ];
    }

    public function typesenseCollectionSchema()
    {
        return [
            'name' => $this->searchableAs(),
            'fields' => [
                [
                    'name' => 'id',
                    'type' => 'string',
                ],
                [
                    'name' => 'name',
                    'type' => 'string',
                ],
                [
                    'name' => 'description',
                    'type' => 'string',
                ],
                [
                    'name' => 'price',
                    'type' => 'float',
                ],
                [
                    'name' => 'quantity',
                    'type' => 'int32',
                ],
                [
                    'name' => 'category_id',
                    'type' => 'int32',
                ],
                [
                    'name' => 'created_at',
                    'type' => 'int64',
                ],
            ],
            'default_sorting_field' => 'created_at',
        ];
    }

    public function typesenseSearchParameters()
    {
        return [
            'query_by' => 'name,description',
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
}
