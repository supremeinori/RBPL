<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\order;

class OrderManagementController extends Controller
{
    public function index()
    {
        $orders = Order::with('customer')->latest()->get();

        return view('admin.orders.index', compact('orders'));
    }

    public function create()
    {
        return view('admin.orders.create');
    }

    public function store(Request $request)
    {
        $request->validate([
        'id_pelanggan' => 'required',
        'nama_pesanan' => 'required',
        'tanggal_pemesanan' => 'required|date',
        'deadline' => 'required|date',
        'status_pemesanan' => 'required',
        'deskripsi_pesanan' => 'nullable'
    ]);

    Order::create([
        'id_pelanggan' => $request->id_pelanggan,
        'nama_pesanan' => $request->nama_pesanan,
        'tanggal_pemesanan' => $request->tanggal_pemesanan,
        'deadline' => $request->deadline,
        'status_pemesanan' => $request->status_pemesanan,
        'deskripsi_pesanan' => $request->deskripsi_pesanan
    ]);

    return redirect()
        ->route('admin.orders.index')
        ->with('success', 'Pesanan berhasil ditambahkan');
    }

    public function show(Order $order)
    {
        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        // logic update
    }

    public function destroy(Order $order)
    {
        // logic delete
    }
}


