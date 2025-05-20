<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\OrderItem;

class AdminController extends Controller
{
    public function dashboard()
    {
        $pendingSellers = User::where('requested_seller', true)->count();
        $pendingProducts = Product::where('status', 'pending')->count();
        $pendingTransfers = OrderItem::where('status', 'waiting_admin_confirmation')->count();

        $weekly = [
            'transfer' => OrderItem::whereHas('order', function ($q) {
                $q->where('payment_method', 'transfer');
            })->where('created_at', '>=', now()->subWeek())->count(),
            'cod' => OrderItem::whereHas('order', function ($q) {
                $q->where('payment_method', 'cod');
            })->where('created_at', '>=', now()->subWeek())->count(),
        ];

        $monthly = [
            'transfer' => OrderItem::whereHas('order', function ($q) {
                $q->where('payment_method', 'transfer');
            })->where('created_at', '>=', now()->subMonth())->count(),
            'cod' => OrderItem::whereHas('order', function ($q) {
                $q->where('payment_method', 'cod');
            })->where('created_at', '>=', now()->subMonth())->count(),
        ];

        $yearly = [
            'transfer' => OrderItem::whereHas('order', function ($q) {
                $q->where('payment_method', 'transfer');
            })->where('created_at', '>=', now()->subYear())->count(),
            'cod' => OrderItem::whereHas('order', function ($q) {
                $q->where('payment_method', 'cod');
            })->where('created_at', '>=', now()->subYear())->count(),
        ];

        return view('admin.dashboard', compact(
            'pendingSellers',
            'pendingProducts',
            'pendingTransfers',
            'weekly',
            'monthly',
            'yearly'
        ));
    }
}
