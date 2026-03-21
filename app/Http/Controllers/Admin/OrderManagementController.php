<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Customer;

class OrderManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('customer');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_pesanan', 'like', "%{$search}%")
                  ->orWhere('status_pemesanan', 'like', "%{$search}%")
                  ->orWhere('deadline', 'like', "%{$search}%")
                  ->orWhere('tanggal_pemesanan', 'like', "%{$search}%")
                  ->orWhereHas('customer', function($q) use ($search) {
                      $q->where('nama', 'like', "%{$search}%");
                  });
            });
        }

        // Sorting
        // $sort = $request->get('sort', 'created_at');
        // $direction = $request->get('direction', 'desc');
        
        // $sortField = match($sort) {
        //     'deadline' => 'deadline',
        //     'date' => 'tanggal_pemesanan',
        //     'status' => 'status_pemesanan',
        //     'name' => 'nama_pesanan',
        //     default => 'created_at'
        // };

        // $orders = $query->orderBy($sortField, $direction)->paginate(10)->withQueryString();

        // return view('admin.dashboard.admin', compact('orders'));
    }

    public function create()
    {
        $customers = Customer::limit(5)->get();

        return view('admin.orders.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_pelanggan' => 'required',
            'nama_pesanan' => 'required',
            'tanggal_pemesanan' => 'required|date',
            'deadline' => 'required|date',
            'status_pemesanan' => 'required',
            'deskripsi_pemesanan' => 'nullable'
        ]);

        Order::create([
            'id_pelanggan' => $request->id_pelanggan,
            'nama_pesanan' => $request->nama_pesanan,
            'tanggal_pemesanan' => $request->tanggal_pemesanan,
            'deadline' => $request->deadline,
            'status_pemesanan' => $request->status_pemesanan,
            'deskripsi_pemesanan' => $request->deskripsi_pemesanan
        ]);

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Pesanan berhasil ditambahkan');
    }

    public function show(Request $request, Order $order)
{
    $order->load('customer', 'desains');

    $tab = $request->get('tab', 'informasi');

    return view('admin.orders.show', compact('order', 'tab'));
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