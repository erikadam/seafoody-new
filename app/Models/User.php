<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public function products()
{
    return $this->hasMany(\App\Models\Product::class, 'user_id');
}

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_approved',
        'role',
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


}

