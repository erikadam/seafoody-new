<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        // Ubah isi session cart menjadi koleksi berisi objek produk dan quantity
        $cartItems = collect($cart)->map(function ($item, $productId) {
            $product = Product::with('seller')->find($productId);

            return (object) [
                'product' => $product,
                'quantity' => $item['quantity'],
            ];
        });

        // Group berdasarkan nama toko (seller)
        $groupedCart = $cartItems->groupBy(function ($item) {
            return $item->product->seller->name ?? 'Toko Tidak Dikenal';
        });

        return view('guest.cart', compact('cartItems', 'groupedCart'));
    }

    public function add(Request $request)
    {
        $productId = $request->product_id;
        $quantity = $request->quantity;

        $cart = session()->get('cart', []);
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'quantity' => $quantity
            ];
        }

        session()->put('cart', $cart);
        return back()->with('success', 'Produk ditambahkan ke keranjang');
    }

    public function update(Request $request)
    {
        $productId = $request->product_id;
        $quantity = $request->quantity;

        $cart = session()->get('cart', []);
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $quantity;
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Jumlah produk diperbarui');
    }

    public function remove(Request $request)
    {
        $productId = $request->product_id;

        $cart = session()->get('cart', []);
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Produk dihapus dari keranjang');
    }
}
