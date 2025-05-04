<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserApprovalController extends Controller
{
    public function index()
    {
        $users = \App\Models\User::where('is_approved', false)->paginate(20);
        return view('admin.users.index', compact('users'));
    }



    public function approve(User $user)
    {
        $user->is_approved = true;
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil disetujui.');
    }
}
