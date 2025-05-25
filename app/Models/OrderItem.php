<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'seller_id',
        'quantity',
        'price',
        'status',
        'admin_transfer_proof',
        'shipped_at',
        'admin_transfer_approved_at',
        'refund_requested',
        'refund_requested_at',
        'refund_reason',
        'refund_bank_name',
        'refund_account_name',
        'refund_account_number',
        'refunded_at',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    // [GPT] Relasi dengan order_logs
    public function logs(): HasMany
    {
        return $this->hasMany(OrderLog::class);
    }
}
