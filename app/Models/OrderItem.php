<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Model
{
    use HasFactory;

    public function getRouteKeyName()
    {
        return 'id';
    }

    protected $fillable = [
        'order_id',
        'product_id',
        'seller_id',
        'quantity',
        'price',
        'status',
        'admin_transfer_proof',
        'shipped_at',
    ];

    // Relasi ke pesanan induk
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Relasi ke produk
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relasi ke penjual
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    // Cek apakah transaksi transfer telah disetujui oleh admin
    public function isTransferApproved()
    {
        return !is_null($this->admin_transfer_proof);
    }

    // Cek apakah bisa diproses oleh seller
    public function canBePreparedBySeller()
    {
        return $this->status === 'accepted_by_admin' || $this->status === 'in_process_by_customer';
    }

    // Cek apakah bisa dikonfirmasi oleh guest
    public function canBeConfirmedByBuyer()
    {
        return $this->status === 'shipped_by_customer';
    }
}
