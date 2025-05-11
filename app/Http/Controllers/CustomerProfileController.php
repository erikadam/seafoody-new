<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CustomerProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('customers.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'store_address' => 'nullable|string|max:255',
            'store_description' => 'nullable|string|max:500',
            'logo' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            if ($user->logo) {
                Storage::delete('public/' . $user->logo);
            }
            $validated['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $user->update($validated);

        return redirect()->route('customer.dashboard')->with('success', 'Profil toko berhasil diperbarui.');
    }
}
