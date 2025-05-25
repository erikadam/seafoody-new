<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use App\Traits\LogsOrderStatus;
class CustomerOrderController extends Controller
{   use LogsOrderStatus;
    // Menampilkan daftar pesanan yang masuk untuk penjual yang sedang login
    public function index()
    {
        $orderItems = OrderItem::with(['order', 'product'])
            ->where('seller_id', Auth::id())
            ->latest()
            ->get();

        return view('customer.orders.index', compact('orderItems'));
    }

    // Update status pesanan oleh penjual (siapkan, kirim, selesai)
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:in_process_by_customer,shipped_by_customer,completed'
        ]);

        $orderItem = OrderItem::where('id', $id)
            ->where('seller_id', Auth::id())
            ->firstOrFail();

        // Validasi status transisi
        $validTransitions = [
            'accepted_by_admin' => 'in_process_by_customer',
            'in_process_by_customer' => 'shipped_by_customer',
            'shipped_by_customer' => 'completed',
        ];

        if (!isset($validTransitions[$orderItem->status]) || $validTransitions[$orderItem->status] !== $request->status) {
            return back()->with('error', 'Transisi status tidak valid.');
        }

        $orderItem->status = $request->status;

        // Simpan waktu pengiriman jika status menjadi dikirim
        if ($request->status === 'shipped_by_customer') {
            $orderItem->shipped_at = now();
        }

        $orderItem->save();

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }
    public function approveRefundBySeller($id)
{
    $item = OrderItem::where('id', $id)
        ->where('seller_id', Auth::id())
        ->firstOrFail();

    if ($item->status !== 'return_requested') {
        return back()->with('error', 'Item ini tidak dalam permintaan refund.');
    }

    $item->status = 'return_approved';
    $item->save();

    return back()->with('success', 'Refund disetujui.');
}

}
?>
