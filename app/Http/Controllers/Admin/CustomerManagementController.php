<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\customer;

class CustomerManagementController extends Controller
{   
    
    public function index()
    {
        $customers = customer::latest()->get(); // ini untuk bikin filter soft delete
        
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
}
