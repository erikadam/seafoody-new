<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
/**
 * @property-read \App\Models\User $user
 */
class CustomerController extends Controller
{
    //
    public function dashboard()
    {
    $user = auth()->user();
    $products = Product::where('user_id', $user->id)->latest()->get();

    return view('customer.dashboard', compact('products'));
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
