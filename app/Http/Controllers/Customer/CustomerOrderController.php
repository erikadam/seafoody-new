<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerOrderController extends Controller
{
   public function index()
{
    // Ambil order_items di mana seller_id = user login
    $order_items = \App\Models\OrderItem::with(['product', 'order.user'])
        ->where('seller_id', auth()->id())
        ->latest()
        ->get();

    return view('customer.orders.index', compact('order_items'));
}


    public function updateStatus(Request $request, $id)
    {
        $orderItem = OrderItem::findOrFail($id);
        $status = $request->input('status');

        $allowedStatuses = [
            'shipped_by_customer',
            'received_by_buyer',
        ];

        if (!in_array($status, $allowedStatuses)) {
            return back()->with('error', 'Status tidak valid.');
        }

        $orderItem->status = $status;
        $orderItem->save();

        return back()->with('success', 'Status berhasil diperbarui.');
    }

    public function markAsProcessing($id)
    {
        $item = OrderItem::findOrFail($id);

        if (
            $item->status === 'accepted_by_admin' &&
            $item->order->payment_method === 'transfer'
        ) {
            $item->status = 'in_process_by_customer';
            $item->save();
        }

        return back()->with('success', 'Barang telah disiapkan.');
    }

    public function prepareOrder($id)
{
    $item = \App\Models\OrderItem::findOrFail($id);

    // Hanya izinkan jika status sudah diterima admin (untuk transfer)
    if ($item->status !== 'accepted_by_admin') {
        return back()->with('error', 'Status belum valid untuk disiapkan.');
    }

    $item->status = 'in_process_by_customer';
    $item->save();

    return back()->with('status', 'Pesanan telah disiapkan. Silakan serahkan ke admin.');
}

/**
 * Penjual klik "Serahkan ke Admin"
 */
public function handoverToAdmin($id)
{
    $item = \App\Models\OrderItem::findOrFail($id);

    // Hanya izinkan jika status in_process_by_customer
    if ($item->status !== 'in_process_by_customer') {
        return back()->with('error', 'Pesanan belum siap diserahkan.');
    }

    $item->status = 'shipped_by_admin';
    $item->save();

    return back()->with('status', 'Pesanan telah diserahkan ke admin.');
}

    // ✅ Tetap: Serahkan ke Pembeli (COD)
    public function handoverBuyerCOD($id)
{
    $item = OrderItem::findOrFail($id);
    // Logika validasi dan perubahan status
    if ($item->status === 'in_process_by_customer' &&
        ($item->order->payment_method === 'cash' || $item->order->payment_method === 'cod')) {
        $item->status = 'shipped_by_customer';
        $item->save();
        return back()->with('success', 'Pesanan telah diserahkan ke pembeli. Menunggu konfirmasi pembeli.');
    }
    return back()->with('error', 'Aksi tidak valid.');
}

    public function approveRefund($id)
    {
        $item = OrderItem::findOrFail($id);
        $item->status = 'refunded';
        $item->save();

        return redirect()->back()->with('success', 'Permintaan refund disetujui.');
    }

    public function approveRefundRequest($id)
    {
        $item = OrderItem::findOrFail($id);
        $item->status = 'refunded';
        $item->save();

        return redirect()->back()->with('success', 'Permintaan refund disetujui.');
    }

    public function confirmRefundReceived($id)
    {
        $item = OrderItem::findOrFail($id);

        if ($item->status === 'return_approved') {
            $item->status = 'completed';
            $item->save();

            return back()->with('success', 'Bukti refund diterima. Transaksi selesai.');
        }

        return back()->with('error', 'Status refund tidak valid.');
    }
}
