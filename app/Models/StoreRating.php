<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreRating extends Model
{
    protected $fillable = ['user_id', 'customer_id', 'rating', 'review'];

    public function seller()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}

