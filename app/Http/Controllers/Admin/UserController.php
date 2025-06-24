<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function management()
    {
        return view('admin.users.management', [
            'users' => User::where('role', 'user')->where('requested_seller', 0)->get(),
            'requested' => User::where('role', 'user')->where('requested_seller', 1)->get(),
            'customers' => User::with('products')->where('role', 'customer')->get(),
        ]);
    }

    public function suspend(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'suspend_reason' => 'required|string',
        ]);

        $user = User::findOrFail($request->user_id);

        if ($user->role === 'customer') {
            $user->role = 'user';
        }

        $user->is_suspended = true;
        $user->suspend_reason = $request->suspend_reason;
        $user->save();

        return redirect()->back()->with('success', 'Akun berhasil disuspend.');
    }




    public function delete(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'deleted_reason' => 'required|string',
        ]);

        $user = User::findOrFail($request->user_id);
        $user->deleted_reason = $request->deleted_reason;
        $user->save();
        $user->delete();

        return redirect()->back()->with('success', 'Akun berhasil dihapus.');
    }


    public function unsuspend(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $user->is_suspended = false;
        $user->status = 'active';


        if ($user->role === 'user' && $user->is_approved) {
            $user->role = 'customer';
        }

        $user->save();

        return redirect()->back()->with('success', 'Akun berhasil diaktifkan kembali.');
    }

}
