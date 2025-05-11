<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'buyer_name',
        'buyer_phone',
        'buyer_address',
        'payment_method',
        'transfer_proof',
        'status',
        'token',
        'user_id',          // ✅ WAJIB ADA INI
        'product_list',
        'total_price',
        'product_id',
    ];

    public function product()
{
    return $this->belongsTo(Product::class, 'product_id');
}
public function user()
{
    return $this->belongsTo(User::class);
}

}
