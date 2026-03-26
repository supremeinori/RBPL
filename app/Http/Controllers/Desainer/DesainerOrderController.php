<?php

namespace App\Http\Controllers\Desainer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\desain;
use App\Models\order;

class DesainerOrderController extends Controller
{
     public function show($id)
    {
        $order = Order::with('desains')->findOrFail($id);

        return view('desainer.orders.show', compact('order'));
    }

     public function upload(Request $request, $id)
{
    $request->validate([
        'file_desain' => 'required|image',
    ]);

    // ambil draft terakhir
    $latest = desain::where('id_pemesanan', $id)
        ->orderBy('draft_ke', 'desc')
        ->first();

    // ❌ SAFETY: kalau belum ada draft (harusnya gak kejadian)
    if (!$latest) {
        return back()->with('error', 'Draft belum dibuat oleh admin');
    }

    // ❌ BLOCK kalau sudah setuju
    if ($latest->status_desain === 'setuju') {
        return back()->with('error', 'Desain sudah disetujui');
    }

    $filePath = $request->file('file_desain')->store('desain', 'public');

    // =========================
    // CASE 1: draft belum ada file (draft awal admin)
    // =========================
    if (!$latest->file_desain) {

        $latest->update([
            'file_desain' => $filePath
        ]);

        return back()->with('success', 'Draft pertama berhasil diisi');
    }

    // =========================
    // CASE 2: revisi → buat draft baru
    // =========================
    if ($latest->status_desain === 'revisi') {

        desain::create([
            'id_pemesanan' => $id,
            'draft_ke' => $latest->draft_ke + 1,
            'file_desain' => $filePath,
            'status_desain' => 'baru'
        ]);

        return back()->with('success', 'Draft revisi berhasil dibuat');
    }

    // =========================
    // DEFAULT (fallback aman)
    // =========================
    return back()->with('error', 'Tidak bisa upload pada kondisi ini');
}

}
