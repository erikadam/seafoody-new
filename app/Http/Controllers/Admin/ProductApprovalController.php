<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductApprovalController extends Controller
{
    // Menampilkan produk dengan status 'pending'
    public function pending()
    {
        $products = Product::where('status', 'pending')->latest()->get();
        return view('admin.products.pending', compact('products'));
    }

    // Menyetujui produk
    public function approve(Product $product)
    {
        $product->update(['status' => 'approved']);
        return redirect()->back()->with('success', 'Produk disetujui.');
    }

    // Menolak produk
    public function reject(Product $product)
    {
        $product->update(['status' => 'rejected']);
        return redirect()->back()->with('success', 'Produk ditolak.');
    }
}
?>