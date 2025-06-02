<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderItem;

class OrderItemController extends Controller
{
    public function markAsReceived($id)
{
    $item = OrderItem::findOrFail($id);

    if ($item->status !== 'shipped_by_customer') {
        return back()->with('error', 'Produk ini tidak dapat ditandai sebagai diterima.');
    }

    $item->status = 'received_by_buyer';
    $item->save();

    return back()->with('success', 'Produk berhasil ditandai sebagai diterima.');
}

    public function cancelItem($id)
    {
        $item = OrderItem::findOrFail($id);

        if ($item->status !== 'in_process_by_customer') {
            return back()->with('error', 'Item ini tidak bisa dibatalkan.');
        }

        $item->status = 'cancelled_by_buyer';
        $item->save();

        return back()->with('success', 'Item berhasil dibatalkan.');
    }
}
