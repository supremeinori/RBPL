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
        'file_desain' => 'required|image',
        'deskripsi_desain' => 'nullable'
    ]);

    $order = order::findOrFail($id);

    // 🔥 ambil draft terakhir
    $lastDraft = desain::where('id_pemesanan', $id)
        ->orderBy('id_desain', 'desc')
        ->first();

    $draftKe = $lastDraft ? $lastDraft->draft_ke + 1 : 1;

    // upload file
    $filePath = $request->file('file_desain')->store('desain', 'public');

    desain::create([
        'id_pemesanan' => $id,
        'draft_ke' => $draftKe,
        'file_desain' => $filePath,
        'deskripsi_desain' => $request->deskripsi_desain,
    ]);

    return redirect()->route('admin.orders.show', $id)
        ->with('success', 'Draft berhasil ditambahkan');
}
}
