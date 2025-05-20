<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class GuestOrderController extends Controller
{
    public function showCheckoutForm()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect('/')->with('error', 'Keranjang Anda kosong.');
        }

        $cartItems = [];
        foreach ($cart as $productId => $entry) {
            $product = Product::with('seller')->find($productId);
            if ($product) {
                $cartItems[] = (object)[
                    'product' => $product,
                    'quantity' => $entry['quantity'],
                ];
            }
        }

        $groupedCart = collect($cartItems)->groupBy(function ($item) {
            return $item->product->seller->name ?? 'Toko Tidak Dikenal';
        });

        return view('guest.checkout', compact('groupedCart'));
    }

    public function submitOrder(Request $request)
    {
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

            $token = Str::random(40);
            $order = Order::create([
                'buyer_name' => $request->buyer_name,
                'buyer_phone' => $request->buyer_phone,
                'buyer_address' => $request->buyer_address,
                'payment_method' => $request->payment_method,
                'transfer_proof' => $proofPath,
                'token' => $token,
            ]);

            foreach ($cart as $productId => $item) {
                $quantity = $item['quantity'];
                $product = Product::findOrFail($productId);

                if ($product->stock < $quantity) {
                    DB::rollBack();
                    return redirect()->back()->with('error', "Stok produk {$product->name} tidak mencukupi.");
                }

                $product->decrement('stock', $quantity);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'seller_id' => $product->user_id,
                    'quantity' => $quantity,
                    'price' => $product->price,
                    'status' => $request->payment_method === 'transfer'
                        ? 'waiting_admin_confirmation'
                        : 'in_process_by_customer',
                ]);
            }

            DB::commit();
            session()->forget('cart');

            $order->load('orderItems');
            session()->put('order', $order);

            return redirect()->route('guest.track.order');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }
}
