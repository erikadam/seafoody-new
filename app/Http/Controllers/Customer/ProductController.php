<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Intervention\Image\Facades\Image;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;



class ProductController
{
    public function show($id)
{
    $product = Product::findOrFail($id);
    return view('customer.products.show', compact('product'));
}
    public function create()
    {

        if (Auth::user()->role !== 'customer') {
        abort(403);
    }

        return view('customer.products.create');
    }

public function myProduct()
{
    $products = Product::where('user_id', auth()->id())->latest()->get();
    return view('customer.products.my-product', compact('products'));
}
public function destroy($id)
{
    $product = Product::where('user_id', auth()->id())->findOrFail($id);

    // Hapus gambar jika ada
    if ($product->image && file_exists(public_path('uploads/' . $product->image))) {
        unlink(public_path('uploads/' . $product->image));
    }

    $product->delete();

    return redirect()->back()->with('success', 'Produk berhasil dihapus.');
}


    // ✅ Proses upload produk (user login)
    public function store(Request $request)
{
    Log::info('STORE START', $request->all());
    // Validasi input lengkap
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric',
        'category' => 'required|string|max:100',
        'stock' => 'required|integer|min:0',
        'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $product = new Product();
    $product->user_id = Auth::id();
    $product->name = $validated['name'];
    $product->description = $validated['description'] ?? null;
    $product->price = $validated['price'];
    $product->category = $validated['category'];
    $product->stock = $validated['stock'];
    $product->status = 'pending';


    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $filename = time() . '.' . $image->getClientOriginalExtension();

        $manager = new \Intervention\Image\ImageManager(new \Intervention\Image\Drivers\Gd\Driver());
        $resizedImage = $manager->read($image)->resize(600, 400);

        $uploadPath = public_path('uploads/product');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        $resizedImage->save($uploadPath . '/' . $filename);
        $product->image = $filename;
    }

    $product->save();
    Log::info('STORE END', ['product_id' => $product->id]); // akhir
    return redirect()->back()->with('success', 'Produk berhasil dikirim dan menunggu persetujuan.');
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
    public function toggleStatus($id)
{
    $product = Product::findOrFail($id);

    // Cek apakah stok kosong
    if ($product->stock == 0 && $product->status !== 'nonaktif') {
        return redirect()->back()->with('error', 'Stok habis. Tidak bisa diaktifkan.');
    }

    // Toggle status
    if ($product->status === 'nonaktif') {
        $product->status = 'approved';
    } else {
        $product->status = 'nonaktif';
    }

    $product->save();

    return redirect()->back()->with('success', 'Status produk berhasil diperbarui.');
}


public function edit($id)
{
    $product = Product::findOrFail($id);
    return view('customer.products.edit', compact('product'));
}

public function update(Request $request, $id)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric',
        'category' => 'required|string|max:100',
        'stock' => 'required|integer|min:0',
        'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $product = Product::findOrFail($id);
    $product->name = $validated['name'];
    $product->description = $validated['description'];
    $product->price = $validated['price'];
    $product->category = $validated['category'];
    $product->stock = $validated['stock'];

    // Auto set availability
    if ($product->stock == 0) {
        $product->availability = 'habis';
    } else {
        $product->availability = 'ready';
    }

    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $filename = time() . '.' . $image->getClientOriginalExtension();

        $manager = new \Intervention\Image\ImageManager(new \Intervention\Image\Drivers\Gd\Driver());
        $resizedImage = $manager->read($image)->resize(600, 400);

        $uploadPath = public_path('uploads/product');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        $resizedImage->save($uploadPath . '/' . $filename);
        $product->image = $filename;
    }

    $product->save();

    return redirect()->route('customer.products.index')->with('success', 'Produk berhasil diperbarui.');
}




}
