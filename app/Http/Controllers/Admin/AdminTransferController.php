<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Traits\LogsOrderStatus;
class AdminTransferController extends Controller
{   use LogsOrderStatus;
    public function index()
{
    // Contoh: Ambil semua order item yang perlu proses admin
    $order_items = OrderItem::with(['order.user', 'product'])
    ->whereIn('status', [
        'waiting_admin_confirmation', // validasi awal
            'accepted_by_admin',          // sudah divalidasi
            'shipped_by_admin',           // siap diantar admin
            'delivering',                 // sedang diantar,
        // tambah status lain yang menurut workflow admin Anda
    ])
    ->orderByDesc('created_at')
    ->get();
    return view('admin.transfers.index', compact('order_items'));
}

    public function approve(Request $request, OrderItem $item)
{
    // Update status order item sesuai kebutuhan
    $item->update([
        'status' => 'accepted_by_admin',
        'admin_transfer_approved_at' => now(),
    ]);

    return redirect()->route('admin.transfers.index')->with('status', 'Transfer berhasil disetujui.');
}

    public function reject(OrderItem $item)
    {
        if ($item->admin_transfer_proof) {
            Storage::disk('public')->delete($item->admin_transfer_proof);
        }

        $item->update([
            'admin_transfer_proof' => null,
            'status' => 'rejected_by_admin',
        ]);

        return redirect()->route('admin.transfers.index')->with('status', 'Bukti transfer telah ditolak.');

    }
    // Fungsi ini untuk admin menyetujui refund dengan metode transfer dan mengunggah bukti transfer balik
public function uploadProof(Request $request, $id)
{
    $item = OrderItem::with('order')->findOrFail($id);

    if ($item->order->payment_method !== 'transfer') {
        return back()->with('error', 'Refund ini hanya bisa disetujui oleh seller karena menggunakan COD.');
    }

    if ($item->status !== 'return_requested') {
        return back()->with('error', 'Status refund tidak valid untuk disetujui admin.');
    }

    $request->validate([
        'admin_transfer_proof' => 'required|image|max:2048',
    ]);

    $proofPath = $request->file('admin_transfer_proof')->store('admin_refund_proofs', 'public');

    $item->admin_transfer_proof = $proofPath;
    $item->status = 'refunded';
    $item->refunded_at = now();
    $item->save();

    return back()->with('success', 'Refund telah disetujui dan bukti transfer diunggah.');
}

}
