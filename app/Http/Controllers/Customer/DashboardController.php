<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $products = Product::where('user_id', $user->id)->latest()->get();

        return view('customer.dashboard', compact('products'));
    }
}

