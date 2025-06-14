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
    // [GPT] Pembeli mengajukan refund

    public function requestRefund(Request $request, $id)
    {
        $item = OrderItem::with('order')->findOrFail($id);

        if ($item->status !== 'received_by_buyer') {
            return back()->with('error', 'Refund hanya bisa diajukan setelah barang diterima.');
        }

        $request->validate([
            'refund_reason' => 'required|string|max:255',
            'refund_proof' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('refund_proof')) {
            $proofPath = $request->file('refund_proof')->store('refund_proofs', 'public');
            $item->refund_proof = $proofPath;
        }

        $item->refund_reason = $request->refund_reason;
        $item->status = 'return_requested';
        $item->save();

        return redirect()->route('guest.track.order')->with('success', 'Permintaan refund berhasil dikirim.');
    }




    // [GPT] Seller menyetujui refund
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

    // [GPT] Admin memproses refund
    public function processRefundByAdmin(Request $request, $id)
    {
        $request->validate([
            'admin_transfer_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $item = OrderItem::findOrFail($id);
        $proofPath = $request->file('admin_transfer_proof')->store('public/refund_proofs');

        $item->update([
            'status' => 'refunded',
            'refunded_at' => now(),
            'admin_transfer_proof' => $proofPath,
        ]);

        $this->log($item, 'refunded', 'Refund ditransfer oleh admin');
        return back()->with('success', 'Refund telah diproses dan bukti berhasil diunggah.');
    }

    // [GPT] Logging helper
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
    $items = OrderItem::with(['product', 'order.user', 'product.seller'])
                      ->where('status', 'return_requested')
                      ->get();

    return view('admin.refunds.index', compact('items'));
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




