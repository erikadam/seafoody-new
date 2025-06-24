<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Models\OrderLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Traits\LogsOrderStatus;

class RefundController extends Controller
{   use LogsOrderStatus;



    public function requestRefund(Request $request, $id)
{
    $item = OrderItem::with('order')->findOrFail($id);

    if ($item->status !== 'received_by_buyer') {
        return back()->with('error', 'Refund hanya bisa diajukan setelah barang diterima.');
    }

    $request->validate([
        'refund_reason' => 'required|string|max:255',
        'refund_proof' => 'nullable|image|max:2048',
        'refund_bank_name' => 'nullable|string|max:255',
        'refund_account_number' => 'nullable|string|max:50',
    ]);

    if ($request->hasFile('refund_proof')) {
        $proofPath = $request->file('refund_proof')->store('refund_proofs', 'public');
        $item->refund_proof = $proofPath;
    }

    $item->refund_reason = $request->refund_reason;

    // Hanya simpan info rekening jika transfer
    if ($item->order->payment_method === 'transfer') {
        $item->refund_bank_name = $request->refund_bank_name;
        $item->refund_account_number = $request->refund_account_number;
    }

    $item->status = 'return_requested';
    $item->refund_requested = true;
    $item->refund_requested_at = now();
    $item->save();

    return redirect()->route('guest.track.order')->with('success', 'Permintaan refund berhasil dikirim.');
}

    public function approveRefundBySeller($id)
    {
        $item = OrderItem::findOrFail($id);

        if ($item->status !== 'return_requested') {
            return back()->with('error', 'Status refund tidak valid.');
        }

        $item->update([
            'status' => 'return_approved',
        ]);

        $this->log($item, 'return_approved', 'Refund disetujui oleh penjual');
        return back()->with('success', 'Refund disetujui. Menunggu proses admin.');
    }


    public function processRefundByAdmin(Request $request, $id)
    {
        $request->validate([
            'admin_transfer_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $item = OrderItem::findOrFail($id);
        $proofPath = $request->file('admin_transfer_proof')->store('public/refund_proofs');
$item->status = 'return_requested'; // tetap

        $item->update([
            'status' => 'refunded',
            'refunded_at' => now(),
            'admin_transfer_proof' => $proofPath,
        ]);

        $this->log($item, 'refunded', 'Refund ditransfer oleh admin');
        return back()->with('success', 'Refund telah diproses dan bukti berhasil diunggah.');
    }
public function uploadProof(Request $request, $id)
{
    $item = OrderItem::with('order')->findOrFail($id);

    $request->validate([
        'admin_transfer_proof' => 'required|image|max:2048',
    ]);

    $path = $request->file('admin_transfer_proof')->store('admin_refund_proofs', 'public');

    $item->admin_transfer_proof = $path;
    $item->save();

    return back()->with('success', 'Bukti transfer telah diunggah dan dikirim ke pembeli.');
}

    protected function log(OrderItem $item, $action, $note = null)
    {
        OrderLog::create([
            'order_item_id' => $item->id,
            'action' => $action,
            'note' => $note,
            'performed_by' => Auth::id(),
        ]);
    }

    public function showRefundForm($id)
    {
        $item = OrderItem::with('product')->findOrFail($id);

        if ($item->status !== 'received_by_buyer') {
            return back()->with('error', 'Refund hanya bisa diajukan saat barang sedang dikirim.');
        }

        return view('guest.refund-form', compact('item'));
    }
    public function listRefunds()
{
    $refunds = OrderItem::with(['product.user', 'order.user'])
        ->where('status', 'return_requested')
        ->get();

    return view('admin.refunds.index', compact('refunds'));
}
public function showUploadProofForm($id)
{
    $item = OrderItem::with(['order', 'product', 'order.user'])->findOrFail($id);

    if ($item->status !== 'return_approved') {
        return back()->with('error', 'Item belum disetujui refundnya.');
    }

    return view('admin.refunds.upload-proof', compact('item'));
}

 public function refundForm($id)
    {
        $item = OrderItem::with('product')->findOrFail($id);

        if ($item->status !== 'received_by_buyer') {
            return back()->with('error', 'Refund hanya bisa diajukan setelah barang diterima.');
        }

        return view('guest.refund-form', compact('item'));
    }

}




