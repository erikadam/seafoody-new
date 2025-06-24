<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
use FontLib\Table\Type\name;

class GuestProductController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $products = Product::where('status', 'approved')
            ->when($userId, function ($query) use ($userId) {
                return $query->where('user_id', '!=', $userId);
            })
            ->latest()
            ->get();

        return view('guest.products.index', compact('products'));
    }

    public function product()
    {
        $userId = auth()->id();

        $products = Product::where('status', 'approved')
            ->when($userId, function ($query) use ($userId) {
                return $query->where('user_id', '!=', $userId);
            })
            ->latest()
            ->get();

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
