<?php

namespace App\Http\Controllers;

use App\Models\Product;

class GuestProductController extends Controller
{
    public function index()
    {
        $products = Product::where('status', 'approved')->latest()->get();
        return view('guest.home', compact('products'));
    }
    public function product()
    {
        $products = Product::where('status', 'approved')->latest()->get();
        return view('guest.products.index', compact('products'));
    }


    public function show($id)
{
    $product = Product::where('status', 'approved')->findOrFail($id);
    return view('guest.products.show', compact('product'));
}


}
