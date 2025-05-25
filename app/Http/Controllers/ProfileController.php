<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('user.profile');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->name = $request->input('name');
        $user->save();

        return back()->with('status', 'Profil berhasil diperbarui.');
    }

    // [GPT] Menangani pengajuan menjadi penjual dengan validasi lengkap
    public function requestSeller(Request $request)
    {
        $request->validate([
            'store_name' => 'required|string|max:255',
            'store_description' => 'required|string',
            'store_address' => 'required|string',
        ]);

        $user = Auth::user();

        if ($user->requested_seller) {
            return back()->with('status', 'Anda sudah mengajukan permintaan. Mohon tunggu persetujuan admin.');
        }

        $user->store_name = $request->store_name;
        $user->store_description = $request->store_description;
        $user->store_address = $request->store_address;
        $user->requested_seller = true;
        $user->save();

        return back()->with('status', 'Permintaan upgrade berhasil dikirim.');
    }


    // [GPT] Tambahan fitur kirim ulang verifikasi email
    public function sendVerification(Request $request)
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return back()->with('status', 'Email sudah diverifikasi.');
        }

        $user->sendEmailVerificationNotification();

        return back()->with('status', 'Link verifikasi telah dikirim ke email Anda.');
    }

    // [GPT] Ubah password dari halaman profil
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'confirmed', 'min:6'],
        ]);

        $user = Auth::user();
        $user->password = bcrypt($request->password);
        $user->save();

        return back()->with('status', 'Password berhasil diperbarui.');
    }
}
