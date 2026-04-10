<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Customer;
use App\Models\User;

class OrderManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('customer');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_pesanan', 'like', "%{$search}%")
                    ->orWhere('status_pemesanan', 'like', "%{$search}%")
                    ->orWhere('deadline', 'like', "%{$search}%")
                    ->orWhere('tanggal_pemesanan', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($q) use ($search) {
                        $q->where('nama', 'like', "%{$search}%");
                    });
            });
        }

        // Sorting
        // $sort = $request->input('sort', 'created_at');
        // $direction = $request->input('direction', 'desc');

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
        $customers = Customer::latest('created_at')->limit(5)->get();

        return view('admin.orders.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_pelanggan' => 'required',
            'nama_pesanan' => 'required',
            'tanggal_pemesanan' => 'required|date',
            'status_pemesanan' => 'required',
            'deskripsi_pemesanan' => 'nullable'
        ]);

        Order::create([
            'id_pelanggan' => $request->id_pelanggan,
            'nama_pesanan' => $request->nama_pesanan,
            'tanggal_pemesanan' => $request->tanggal_pemesanan,
            'status_pemesanan' => $request->status_pemesanan,
            'deskripsi_pemesanan' => $request->deskripsi_pemesanan
        ]);

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Pesanan berhasil ditambahkan');
    }

    public function show(Request $request, Order $order)
    {
        $order->load('customer', 'desains', 'designer');
        $customers = Customer::all();
        $designers = User::where('role', 'desainer')->get();

        $tab = $request->input('tab', 'informasi');

        return view('admin.orders.show', compact('order', 'tab', 'customers', 'designers'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'deskripsi_pemesanan' => 'nullable|string',
            'deadline' => 'nullable|date'
        ]);

        $order->update([
            'deskripsi_pemesanan' => $request->deskripsi_pemesanan,
            'deadline' => $request->deadline
        ]);

        return back()->with('success', 'Informasi pesanan berhasil diperbarui.');
    }

    // Fungsi khusus untuk mengeset deadline setelah order diproses (DP Lunas)
    public function updateDeadline(Request $request, $id)
    {
        $request->validate([
            'deadline' => 'required|date'
        ]);

        $order = Order::findOrFail($id);
        $order->deadline = $request->deadline;
        $order->save();

        return back()->with('success', 'Deadline produksi berhasil ditetapkan.');
    }

    public function assignDesigner(Request $request, $id)
    {
        $request->validate([
            'id_desainer' => 'required|exists:users,id'
        ]);

        $order = Order::findOrFail($id);
        $order->id_desainer = $request->id_desainer;
        $order->save();

        return redirect()->route('admin.orders.show', [$id, 'tab' => 'desain'])->with('success', 'Desainer Penanggung Jawab berhasil di-assign.');
    }

    public function cancel($id)
    {
        $order = Order::findOrFail($id);
        $order->status_pemesanan = 'dibatalkan';
        $order->save();

        return back()->with('success', 'Pesanan telah berhasil dibatalkan.');
    }

    public function destroy(Order $order)
    {
        // logic delete
    }
}