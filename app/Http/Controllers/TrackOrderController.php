<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;

class TrackOrderController extends Controller
{
    public function showForm()
    {
        return view('guest.track-order');
    }

    public function searchByToken(Request $request)
    {
        $request->validate([
            'token' => 'required|string|size:40',
        ]);

        $order = Order::with(['items.product.seller'])->where('token', $request->token)->first();

        if (!$order) {
            return redirect()->back()->withErrors(['token' => 'Token tidak ditemukan.']);
        }

        return redirect()->route('guest.track.form');

    }

    public function downloadPdf($token)
    {
        $order = Order::with(['items.product.seller'])->where('token', $token)->firstOrFail();

        $pdf = Pdf::loadView('guest.invoice-pdf', compact('order'));
        return $pdf->download('Nota_Pesanan_' . $order->buyer_name . '.pdf');
    }
}
