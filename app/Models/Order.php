<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id',
        'product_id',
        'buyer_name',
        'buyer_phone',
        'buyer_address',
        'payment_method',
        'payment_proof',
        'product_list',
        'total_price',
        'token',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
{
    return $this->hasMany(OrderItem::class);
}

    public function orderItems()
{
    return $this->hasMany(OrderItem::class, 'order_id');
}
}
