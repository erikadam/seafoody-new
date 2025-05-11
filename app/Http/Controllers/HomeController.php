<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $products = Product::where('approved', true)->latest()->take(6)->get();

        return view('guest.home', compact('products'));
    }
    public function home()
{
    $products = Product::where('is_approved', true)->latest()->take(6)->get();
    return view('guest.home', compact('products'));
}

}
