<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
use FontLib\Table\Type\name;

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


public function filtered(Request $request)
{
    $query = Product::where('status', 'approved');

    if (in_array($request->category, ['makanan', 'bahan'])) {
        $query->where('category', $request->category);
    }

    $products = $query->latest()->paginate(12);

    return view('guest.products', [
        'products' => $products,
        'activeCategory' => $request->category
    ]);
}
}
