<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// [GPT] Verifikasi email dibuat opsional

class User extends Authenticatable
{
     use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
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

}

