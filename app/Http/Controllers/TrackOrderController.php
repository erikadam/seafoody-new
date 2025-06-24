<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Barryvdh\DomPDF\Facade\Pdf;

class TrackOrderController extends Controller
{
    public function printReceipt($id)
    {
        $item = OrderItem::with(['order', 'product', 'product.seller'])->findOrFail($id);
        $status = $item->status;

        $view = match ($status) {
            'received_by_buyer'     => 'guest.pdf_receipt',
            'cancelled_by_buyer'    => 'guest.pdf_cancellation',
            'refunded'              => 'guest.pdf_refund',
            default                 => null,
        };

        if (!$view) {
            return back()->with('error', 'Pesanan belum selesai atau tidak dapat dicetak.');
        }

        $pdf = Pdf::loadView("{$view}", [
            'orderItem' => $item,
            'sellerName' => $item->product->seller->name ?? '-',
        ]);

        return $pdf->download("nota_{$status}_item_{$item->id}.pdf");
    }

    public function index()
    {

        $orders = Order::with(['orderItems.logs', 'orderItems.product.seller'])
                       ->where('user_id', auth()->id())
                       ->latest()
                       ->get();

        return view('guest.track-order', compact('orders'));
    }

    public function showForm()
    {
        return view('guest.track-order');
    }

    public function showOrder($token)
    {
        $order = Order::with(['orderItems.product'])->where('token', $token)->firstOrFail();
        return view('guest.track-order', compact('order'));
    }

    public function searchByToken(Request $request)
    {
        $request->validate([
            'token' => 'required|string|size:40',
        ]);

        $order = Order::with(['orderItems.product.seller'])->where('token', $request->token)->first();

        if (!$order) {
            return redirect()->back()->withErrors(['token' => 'Token tidak ditemukan.']);
        }

        return redirect()->route('guest.track.form');
    }

    public function downloadPdf($token)
    {
        $order = Order::with(['orderItems.product.seller'])->where('token', $token)->firstOrFail();

        $pdf = Pdf::loadView('guest.invoice-pdf', compact('order'));
        return $pdf->download('Nota_Pesanan_' . $order->buyer_name . '.pdf');
    }

    public function receiveOrderItem($id)
    {
        $item = OrderItem::findOrFail($id);

        if ($item->status !== 'shipped_by_customer') {
            return back()->with('error', 'Pesanan belum dalam status dikirim.');
        }

        $item->status = 'received_by_buyer';
        $item->save();

        return back()->with('success', 'Pesanan telah dikonfirmasi diterima.');
    }
}
