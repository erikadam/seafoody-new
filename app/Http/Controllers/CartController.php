<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);


        $cartItems = collect($cart)->map(function ($item, $productId) {
            $product = Product::with('seller')->find($productId);

            return (object) [
                'product' => $product,
                'quantity' => $item['quantity'],
            ];
        });


        $groupedCart = $cartItems->groupBy(function ($item) {
            return $item->product->seller->name ?? 'Toko Tidak Dikenal';
        });

        return view('guest.cart', compact('cartItems', 'groupedCart'));
    }

    public function add(Request $request)
{
    $productId = $request->product_id;
    $quantity = $request->quantity;

    $product = \App\Models\Product::find($productId);

    if (!$product) {
        return back()->with('error', 'Produk tidak ditemukan.');
    }

    // Cek apakah user mencoba menambahkan produk miliknya sendiri
    if (auth()->check() && $product->user_id === auth()->id()) {
        return back()->with('Anda tidak dapat menambahkan produk milik sendiri ke keranjang.');
    }

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
