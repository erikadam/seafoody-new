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
        $items = OrderItem::with(['product', 'order'])
            ->where('status', 'waiting_admin_confirmation')
            ->get();

        return view('admin.transfers.index', compact('items'));
    }

    public function approve(Request $request, OrderItem $item)
    {
        $request->validate([
            'admin_transfer_proof' => 'required|image|max:2048',
        ]);

        // Hapus bukti lama jika ada
        if ($item->admin_transfer_proof) {
            Storage::disk('public')->delete($item->admin_transfer_proof);
        }

        // Simpan bukti baru
        $path = $request->file('admin_transfer_proof')->store('transfer_proofs', 'public');

        // Update item
        $item->update([
            'admin_transfer_proof' => $path,
            'admin_transfer_approved_at' => now(),
            'status' => 'accepted_by_admin',
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
}
