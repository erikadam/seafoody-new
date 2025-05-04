<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
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

}
