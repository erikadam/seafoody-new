<?php

namespace App\Traits;

use App\Models\OrderLog;
use Illuminate\Support\Facades\Auth;

trait LogsOrderStatus
{
    public function logOrderStatus($orderItem, $action, $note = null)
    {
        OrderLog::create([
            'order_item_id' => $orderItem->id,
            'action' => $action,
            'note' => $note,
            'performed_by' => Auth::id(),
        ]);
    }
}
