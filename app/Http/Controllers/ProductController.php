<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\RedirectResponse;


class ProductController extends Controller
{
    // ✅ Hanya produk disetujui (approved) akan ditampilkan ke semua pengunjung
    public function index()
    {
        $products = Product::where('status', 'approved')->latest()->paginate(12);
        return view('products.index', compact('products'));
    }

    // ✅ Form hanya untuk user login
    public function create()
    {

        if (Auth::user()->role !== 'customer') {
        abort(403);
    }

        return view('customer.products.create');
    }

    public function myProduct()
{
    if (Auth::user()->role !== 'customer') {
        abort(403);
    }

    $products = Product::where('user_id', Auth::id())->latest()->get();

    return view('customer.products.my-product', compact('products'));
}




    // ✅ Proses upload produk (user login)
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $data['user_id'] = Auth::id(); // ✅ Lebih eksplisit, aman dari warning
        $data['status'] = 'pending';

        Product::create($data);

        return redirect()->route('products.create')->with('success', 'Produk berhasil diupload dan menunggu persetujuan admin.');
    }


    // ✅ Admin lihat semua produk pending
    public function pending()
    {
        $products = Product::where('status', 'pending')->get();
        return view('admin.products.pending', compact('products'));
    }

    // ✅ Admin setujui produk
    public function approve(Product $product)
    {
        $product->update(['status' => 'approved']);
        return back()->with('success', 'Produk berhasil disetujui.');
    }

    // ✅ Admin tolak produk
    public function reject(Product $product)
    {
        $product->update(['status' => 'rejected']);
        return back()->with('success', 'Produk berhasil ditolak.');
    }

}
