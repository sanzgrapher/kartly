<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    /** @use HasFactory<\Database\Factories\AddressFactory> */
    use HasFactory;
    protected $fillable = [
        'user_id',
        'country',
        'state',
        'city',
        'street_address_1',
        'street_address_2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
