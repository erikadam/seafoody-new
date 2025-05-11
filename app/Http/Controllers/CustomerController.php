<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
/**
 * @property-read \App\Models\User $user
 */
class CustomerController extends Controller
{
    //
    public function prepareOrder($id)
{
    $order = Order::findOrFail($id);
    if (in_array($order->status, ['in_process_by_customer', 'accepted_by_admin', 'waiting_admin_confirmation'])) {
        $order->update(['status' => 'shipped_by_customer']);
    }

    return redirect()->back()->with('success', 'Pesanan telah dikirim.');
}

public function completeOrder($id)
{
    $order = Order::findOrFail($id);
    if ($order->status === 'received_by_buyer') {
        $order->update(['status' => 'completed']);
    }

    return redirect()->back()->with('success', 'Pesanan ditandai selesai.');
}

public function dashboard()
{
    $user = auth()->user();

    $products = $user->products()->with('orders')->get();

    $orders = \App\Models\Order::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();

    return view('customer.dashboard', compact('products', 'orders'));
}

    public function editProfile()
    {
        $user = Auth::user();
        return view('customer.profile.edit', compact('user'));
    }

    public function updateProfile(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'store_address' => 'required|string|max:255',
        'store_description' => 'nullable|string|max:1000',
        'store_logo' => 'nullable|image|max:2048',
    ]);

    $user = \App\Models\User::findOrFail(Auth::id());

    $user->name = $request->name;
    $user->store_address = $request->store_address;
    $user->store_description = $request->store_description;

    if ($request->hasFile('store_logo')) {
        // Hapus logo lama jika ada
        if ($user->store_logo) {
            Storage::disk('public')->delete($user->store_logo);
        }

        $user->store_logo = $request->file('store_logo')->store('logos', 'public');
    }

    $user->save();

    return redirect()->route('customer.dashboard')->with('success', 'Profil toko berhasil diperbarui.');
}



}
