<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    use HasUuids;

    

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    
    public function getRoleNameAttribute()
    {
        return $this->role?->name;
    }

    public function isAdmin(): bool
    {
        return $this->role?->name === 'admin';
    }

    public function isSeller(): bool
    {
        return $this->role?->name === 'seller';
    }
    
    public function hasShop(): bool
    {
        return $this->isSeller() && $this->seller !== null;
    }

    public function getShopAttribute()
    {
        return $this->seller;
    }

    public function isCustomer(): bool
    {
        return $this->role?->name === 'customer';
    }
    

    





}
