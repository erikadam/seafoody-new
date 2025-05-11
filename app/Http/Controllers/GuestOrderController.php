<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class GuestOrderController extends Controller
{
    public function showForm()
    {
        $products = Product::where('status', 'approved')->where('stock', '>', 0)->get();
        return view('guest.checkout', compact('products'));
    }

    public function submitOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string',
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            foreach ($request->products as $item) {
                $product = Product::findOrFail($item['id']);

                if ($product->stock < $item['quantity']) {
                    return redirect()->back()->with('error', "Stok produk {$product->name} tidak mencukupi.");
                }

                Order::create([
                    'product_id' => $product->id,
                    'customer_name' => $request->customer_name,
                    'customer_phone' => $request->customer_phone,
                    'customer_address' => $request->customer_address,
                    'quantity' => $item['quantity'],
                    'total_price' => $item['quantity'] * $product->price,
                    'status' => 'pending',
                ]);

                $product->stock -= $item['quantity'];
                $product->save();
            }

            DB::commit();
            return redirect()->route('guest.checkout')->with('success', 'Pesanan berhasil dikirim.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses pesanan.');
        }
    }
}
