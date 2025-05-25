<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // [GPT] Daftar kolom yang boleh di mass assignment
    protected $fillable = [
        'user_id',        // [GPT] ID pembeli (user)
        'product_id',     // [GPT] ID produk utama di order
        'buyer_name',     // [GPT] Nama pembeli
        'buyer_phone',    // [GPT] Telepon pembeli
        'buyer_address',  // [GPT] Alamat pembeli
        'payment_method', // [GPT] Metode pembayaran (cash/transfer)
        'transfer_proof', // [GPT] Path bukti transfer (jika transfer)
        'product_list',   // [GPT] JSON daftar produk beserta kuantitas
        'total_price',    // [GPT] Total harga semua item
        'token',          // [GPT] Token unik untuk pelacakan
        'status',// status memiliki default pada migration, tidak perlu mass assignment
    ];

    // [GPT] Relasi ke user (pembeli)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // [GPT] Relasi ke item pesanan
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
