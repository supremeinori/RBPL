<?php

namespace App\Http\Controllers\Akuntan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\pembayaran;

class DashboardController extends Controller
{
    public function index()
    {
        $pendingPayments = pembayaran::with('order.customer')
            ->where('status_verifikasi', 'pending')
            ->orderBy('tanggal_bayar', 'asc')
            ->get();

        return view('akuntan.dashboard.akuntan', compact('pendingPayments'));
    }
}
