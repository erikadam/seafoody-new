<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CustomerProfileController
{
    public function edit()
    {
        $user = Auth::user();
        return view('customer.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'store_name' => 'required|string|max:255',
            'store_address' => 'nullable|string|max:255',
            'store_description' => 'nullable|string|max:500',
            'store_logo' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        if ($request->hasFile('store_logo')) {
            if ($user->store_logo) {
                Storage::delete('public/' . $user->store_logo);
            }
            $validated['store_logo'] = $request->file('store_logo')->store('store_logo', 'public');
        }

        $user->store_name = $request->store_name;
        $user->store_address = $validated['store_address'] ?? null;
        $user->store_description = $validated['store_description'] ?? null;
        if (isset($validated['store_logo'])) {
            $user->store_logo = $validated['store_logo'];
        }

        $user->save();

        return redirect()->route('customer.profile.edit')->with('success', 'Profil toko berhasil diperbarui.');
    }
}
