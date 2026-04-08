<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $orders = Order::with('customer')
                       ->latest() // ->where('status_pemesanan', 'pending') // contoh filter untuk pesanan yang belum selesai
                       ->take(10) // ambil 10 data terbaru
                       ->get(); // ini untuk bikin filter soft delete

        return view('admin.dashboard.admin', compact('orders'));
    }
}
