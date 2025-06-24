<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserApprovalController extends Controller
{

    public function index()
    {
        $users = User::where('requested_seller', true)->get();
        return view('admin.users.index', compact('users'));
    }

    public function approve($id)
    {
        $user = User::findOrFail($id);

        if (!$user->store_name) {
            return back()->with('error', 'User belum mengisi nama toko. Tidak bisa disetujui.');
        }

        $user->role = 'customer';
        $user->is_approved = true;
        $user->requested_seller = false;
        $user->save();

        return back()->with('status', 'User berhasil disetujui sebagai penjual.');
    }
}
