<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class User extends Authenticatable
{
     use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'requested_seller',
        'is_approved',
        'status',
        'avatar',
        'store_logo',
        'store_description',
        'store_address',
        'is_suspended',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    // Sebagai penjual
public function storeRatings()
{
    return $this->hasMany(StoreRating::class, 'user_id');
}

// Sebagai pembeli
public function givenRatings()
{
    return $this->hasMany(StoreRating::class, 'customer_id');
}
public function products()
{
    return $this->hasMany(Product::class, 'user_id');
}

public function orderLogs(): \Illuminate\Database\Eloquent\Relations\HasMany
{
    return $this->hasMany(OrderLog::class, 'performed_by');
}

}

