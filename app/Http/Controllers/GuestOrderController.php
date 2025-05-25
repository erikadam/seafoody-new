<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;

class GuestOrderController extends Controller
{
    public function showCheckoutForm()
    {
        $cartEntries = session()->get('cart', []);

        $cartItems = collect($cartEntries)
            ->map(function ($data, $productId) {
                $product = Product::with('seller')->find($productId);
                if (! $product) {
                    return null;
                }
                return [
                    'product'  => $product,
                    'quantity' => isset($data['quantity']) ? (int) $data['quantity'] : 1,
                ];
            })
            ->filter();

        $groupedCart = $cartItems->groupBy(function ($item) {
            return $item['product']->seller->name;
        });

        return view('guest.checkout', compact('groupedCart'));
    }

    public function submitOrder(Request $request)
    {
        $request->validate([
            'buyer_name'     => 'required|string|max:255',
            'buyer_phone'    => 'required|string',
            'buyer_address'  => 'required|string',
            'payment_method' => 'required|in:cash,transfer',
            'transfer_proof' => 'required_if:payment_method,transfer|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if (! Auth::check()) {
            return redirect()->route('login')
                             ->with('error', 'Silakan login terlebih dahulu untuk checkout.');
        }

        $cartEntries = session()->get('cart', []);
        if (empty($cartEntries)) {
            return back()->with('error', 'Keranjang Anda kosong.');
        }

        $items = collect($cartEntries)->map(function ($data, $productId) {
            $product = Product::findOrFail($productId);
            $qty     = isset($data['quantity']) ? (int) $data['quantity'] : 1;
            return [
                'product'  => $product,
                'quantity' => $qty,
            ];
        });

        $grandTotal = $items->sum(function ($item) {
            return $item['product']->price * $item['quantity'];
        });

        DB::beginTransaction();
        try {
            $proofPath = null;
            if ($request->payment_method === 'transfer' && $request->hasFile('transfer_proof')) {
                $proofPath = $request->file('transfer_proof')->store('transfer-proofs', 'public');
            }

            $firstProduct = $items->first()['product'];
            $productList  = $items->map(function ($item) {
                return [
                    'product_id' => $item['product']->id,
                    'quantity'   => $item['quantity'],
                ];
            })->toJson();

            $order = Order::create([
                'user_id'        => Auth::id(),
                'product_id'     => $firstProduct->id,
                'buyer_name'     => $request->buyer_name,
                'buyer_phone'    => $request->buyer_phone,
                'buyer_address'  => $request->buyer_address,
                'payment_method' => $request->payment_method,
                'transfer_proof' => $proofPath,
                'product_list'   => $productList,
                'total_price'    => $grandTotal,
                'token'          => Str::random(40),
                'status'         => $request->payment_method === 'transfer'
                                    ? 'waiting_admin_confirmation'
                                    : 'in_process_by_customer',
            ]);

            foreach ($items as $item) {
                $prod  = $item['product'];
                $qty   = $item['quantity'];
                $itemStatus = $request->payment_method === 'transfer'
                               ? 'waiting_admin_confirmation'
                               : 'in_process_by_customer';

                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $prod->id,
                    'seller_id'  => $prod->user_id,
                    'quantity'   => $qty,
                    'price'      => $prod->price,
                    'status'     => $itemStatus,
                ]);

                $prod->decrement('stock', $qty);
            }

            DB::commit();
            session()->forget('cart');

            return redirect()
                   ->route('guest.track.order')
                   ->with('success', 'Pesanan berhasil diproses.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses pesanan: ' . $e->getMessage());
        }
    }
}
