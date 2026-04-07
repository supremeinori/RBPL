<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\customer;

class CustomerManagementController extends Controller
{   
    
    public function index(Request $request)
    {
        $query = customer::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nama', 'like', "%{$search}%");
        }

        $sort = $request->get('sort', 'nama');
        $direction = $request->get('direction', 'asc');

        $sortField = match($sort) {
            'nama' => 'nama',
            'created' => 'created_at',
            default => 'nama'
        };

        $customers = $query->orderBy($sortField, $direction)->paginate(10)->withQueryString();
        
        return view('admin.customers.index', compact('customers'));
    }

    public function create()
    {
        return view('admin.customers.create');
    }
   

   public function store(Request $request)
{
    $request->validate([
        'nama' => 'required',
        'alamat' => 'required',
        'no_telp' => 'required',
    ]);

    Customer::create([
        'nama' => $request->nama,
        'alamat' => $request->alamat,
        'no_telp' => $request->no_telp
    ]);

    return redirect()
        ->route('admin.customers.index')
        ->with('success', 'Customer berhasil ditambahkan.');
}

 public function edit(customer $customer)
    {
        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, customer $customer)
    {
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required',
        ]);

        $customer->update([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp
        ]);

        return redirect()
            ->route('admin.customers.index')
            ->with('success', 'Customer berhasil diperbarui.');
    }

    public function searchApi(Request $request)
    {
        $search = $request->get('q');
        $customers = Customer::where('nama', 'like', "%{$search}%")
            ->limit(10)
            ->get(['id_pelanggan', 'nama']);

        return response()->json($customers);
    }

    public function storeApi(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required',
        ]);

        $customer = Customer::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp
        ]);

        return response()->json([
            'success' => true,
            'customer' => [
                'id_pelanggan' => $customer->id_pelanggan,
                'nama' => $customer->nama
            ]
        ]);
    }
}
