<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'buyer_name',
        'buyer_phone',
        'buyer_address',
        'payment_method',
        'transfer_proof',
        'token',
    ];

    /**
     * Relasi ke item-item pesanan.
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
