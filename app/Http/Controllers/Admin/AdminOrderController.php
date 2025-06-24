<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('items.product', 'user')->latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with('items.product', 'user')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    // ✅ Tambahan baru: Admin mulai antar ke pembeli
    // Mulai antar ke pembeli (ubah status menjadi delivering)
public function startDelivery($id)
{
    $item = OrderItem::findOrFail($id);

    if ($item->status !== 'shipped_by_admin') {
        return back()->with('error', 'Barang belum diserahkan penjual ke admin.');
    }

    $item->status = 'delivering';
    $item->save();

    return back()->with('status', 'Status diubah menjadi delivering. Silakan upload bukti penyerahan jika sudah sampai ke pembeli.');
}

// Selesaikan pengantaran (upload bukti, status jadi received_by_buyer)
public function completeDelivery(Request $request, $id)
{
    $item = \App\Models\OrderItem::findOrFail($id);

    $request->validate([
        'admin_delivery_proof' => 'required|image|max:2048',
    ]);

    // Hapus file lama jika ada
    if ($item->admin_delivery_proof) {
        Storage::disk('public')->delete($item->admin_delivery_proof);
    }

    // Upload file
    $path = $request->file('admin_delivery_proof')->store('admin_delivery_proofs', 'public');

    $item->admin_delivery_proof = $path;
    $item->status = 'received_by_buyer'; // atau status sesuai flow Anda
    $item->save();

    return back()->with('status', 'Bukti serah terima berhasil diunggah!');
}

}
