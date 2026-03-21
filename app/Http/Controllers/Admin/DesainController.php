<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use App\Models\desain;
use App\Models\order;
use Illuminate\Http\Request;

class DesainController extends Controller
{
   public function create($id)
{
    $order = order::findOrFail($id);

    return view('admin.desain.create', compact('order'));
}
public function store(Request $request, $id)
{
    $request->validate([
        'file_referensi' => 'nullable|image', // bisa null, tapi kalau ada harus berupa file gambar
        'catatan_admin' => 'nullable|string',
    ]);

    $order = order::findOrFail($id);

    // ambil draft terakhir
    $lastDraft = desain::where('id_pemesanan', $id)
        ->orderBy('id_desain', 'desc')
        ->first();

    $draftKe = $lastDraft ? $lastDraft->draft_ke + 1 : 1;

    // upload file
    $file_desain = null;
if ($request->hasFile('file_referensi')) {
    $path = $request->file('file_referensi')->store('referensi', 'public');

    order::where('id_pemesanan', $id)
        ->update(['file_referensi' => $path]);
}

    desain::create([
    'id_pemesanan' => $id,
    'draft_ke' => $draftKe,
    'file_desain' => $file_desain , // bisa null
    'catatan_admin' => $request->catatan_admin,
    'status_desain' => 'baru'
]);

    return redirect()->route('admin.orders.show', $id)
        ->with('success', 'Draft berhasil ditambahkan');
}
}
