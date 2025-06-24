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
    public function approveRefundByCustomer($id)
{
    $item = OrderItem::findOrFail($id);

    if ($item->order->payment_method !== 'cash' || $item->status !== 'return_requested') {
        return back()->with('error', 'Permintaan refund tidak valid.');
    }

    $item->status = 'refunded';
    $item->refunded_at = now();
    $item->save();

    return back()->with('success', 'Refund disetujui dan status diubah menjadi refunded.');
}
public function rejectRefundByCustomer($id)
{
    $item = OrderItem::findOrFail($id);

    if ($item->order->payment_method !== 'cash' || $item->status !== 'return_requested') {
        return back()->with('error', 'Permintaan refund tidak valid.');
    }

    // Anggap sebelumnya sudah diterima → rollback ke received_by_buyer
    $item->status = 'received_by_buyer';
    $item->save();

    return back()->with('success', 'Refund ditolak dan status dikembalikan.');
}

}
