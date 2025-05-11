<?php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;


class GuestOrderController extends Controller
{
    public function completeOrder($token)
    {
        $order = Order::where('token', $token)->firstOrFail();
        if ($order->status === 'received_by_buyer') {
            $order->update(['status' => 'completed']);
        }
        return redirect()->route('guest.order.track', $token)->with('success', 'Pesanan telah selesai.');
    }

    public function cancelOrder($token)
    {
        $order = Order::where('token', $token)->firstOrFail();
        if (in_array($order->status, ['in_process_by_customer', 'waiting_admin_confirmation'])) {
            $order->update(['status' => 'cancelled_by_buyer']);
        }
        return redirect()->route('guest.order.track', $token)->with('success', 'Pesanan telah dibatalkan.');
    }

    public function confirmReceived($token)
    {
        $order = Order::where('token', $token)->firstOrFail();
        if ($order->status === 'shipped_by_customer') {
            $order->update(['status' => 'completed']);
            Log::info("GUEST mengonfirmasi terima order {$order->id}");
        }
        return back();
    }

    public function showForm()
    {
        $cart = session()->get('cart', []);
        $productIds = array_keys($cart);
        $products = Product::whereIn('id', $productIds)->with('user')->get();
        return view('guest.checkout', compact('products'));
    }

    public function trackOrder($token)
    {
        $order = Order::with('user')->where('token', $token)->firstOrFail();
        return view('guest.track-order', compact('order'));
    }

    public function confirmReceipt($token)
    {
        $order = Order::where('token', $token)->firstOrFail();
        if ($order->status === 'shipped_by_customer') {
            $order->update(['status' => 'received_by_buyer']);
        }
        return redirect()->route('guest.order.track', $token)->with('success', 'Pesanan dikonfirmasi diterima.');
    }

    public function downloadFinalPdf($token)
    {
        $order = Order::where('token', $token)->firstOrFail();
        $pdf = Pdf::loadView('guest.pdf_receipt', compact('order'));
        return $pdf->download('nota-diterima-' . $order->id . '.pdf');
    }

    public function downloadPdf($token)
    {
        $order = Order::where('token', $token)->firstOrFail();
        $pdf = Pdf::loadView('guest.pdf_receipt', compact('order'));
        return $pdf->download('nota-pesanan-' . $order->id . '.pdf');
    }

    public function submitOrder(Request $request)
    {
        Log::info('🔥 submitOrder terpanggil');

        $validator = Validator::make($request->all(), [
            'buyer_name' => 'required|string|max:255',
            'buyer_phone' => 'required|string|max:20',
            'buyer_address' => 'required|string',
            'payment_method' => 'required|in:cash,transfer',
            'transfer_proof' => 'nullable|image|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Keranjang belanja kosong.');
        }

        DB::beginTransaction();

        try {
            $proofPath = null;
            if ($request->payment_method === 'transfer' && $request->hasFile('transfer_proof')) {
                $proofPath = $request->file('transfer_proof')->store('transfer_proofs', 'public');
            }

            $groupedCart = [];
            foreach ($cart as $productId => $quantity) {
                $product = Product::find($productId);

                if (!$product) {
                    DB::rollBack();
                    return redirect()->back()->with('error', "Produk ID {$productId} tidak ditemukan.");
                }

                if ($product->stock < $quantity) {
                    DB::rollBack();
                    return redirect()->back()->with('error', "Stok produk {$product->name} tidak mencukupi.");
                }

                $groupedCart[$product->user_id][] = [
                    'product' => $product,
                    'quantity' => $quantity,
                ];
            }

            Log::info('📦 groupedCart', $groupedCart);

            $tokenList = [];

            foreach ($groupedCart as $sellerId => $items) {
                $token = Str::random(32);
                $tokenList[] = $token;
                $status = $request->payment_method === 'transfer'
                    ? 'waiting_admin_confirmation'
                    : 'in_process_by_customer';

                $productNames = [];
                $totalPrice = 0;

                foreach ($items as $entry) {
                    $product = $entry['product'];
                    $quantity = $entry['quantity'];
                    $productNames[] = "{$product->name} (x{$quantity})";
                    $totalPrice += $product->price * $quantity;
                    $product->decrement('stock', $quantity);
                }

                $data = [
                    'buyer_name' => $request->buyer_name,
                    'buyer_phone' => $request->buyer_phone,
                    'buyer_address' => $request->buyer_address,
                    'payment_method' => $request->payment_method,
                    'transfer_proof' => $proofPath,
                    'status' => $status,
                    'token' => $token,
                    'user_id' => $sellerId,
                    'product_list' => implode(', ', $productNames),
                    'total_price' => $totalPrice,
                    'product_id' => $items[0]['product']->id,
                ];

                Log::info('🧾 Order data', $data);
                Order::create($data);
                Log::info('✅ Order berhasil dibuat');
            }

            DB::commit();
            session()->forget('cart');
            Log::info('🎉 Semua transaksi disimpan');

            return redirect()->route('guest.order.track', $tokenList[0])
                ->with('success', 'Pesanan berhasil dilakukan.');

            } catch (\Exception $e) {
                DB::rollBack();
                dd('❌ ERROR:', $e->getMessage(), $e->getTraceAsString());
            }
    }
}
