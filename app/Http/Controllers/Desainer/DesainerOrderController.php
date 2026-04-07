<?php

namespace App\Http\Controllers\Desainer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\desain;
use App\Models\order;

class DesainerOrderController extends Controller
{
    // Designer: order detail page (MODE 1 or MODE 2)
    public function show($id)
    {
        $order = order::with('desains')->findOrFail($id);

        if ($order->id_desainer !== auth()->id()) {
            abort(403, 'Akses ditolak. Anda bukan PIC desainer untuk pesanan ini.');
        }

        return view('desainer.orders.show', compact('order'));
    }

    // Designer: view a single draft (read-only)
    public function showDraft($orderId, $desainId)
    {
        $order  = order::findOrFail($orderId);

        if ($order->id_desainer !== auth()->id()) {
            abort(403, 'Akses ditolak.');
        }

        $desain = desain::where('id_pemesanan', $orderId)
            ->where('id_desain', $desainId)
            ->firstOrFail();

        return view('desainer.desain.show', compact('order', 'desain'));
    }

    // Designer: upload file_desain into the latest draft (never creates a new record)
    public function upload(Request $request, $id)
    {
        $request->validate([
            'file_desain' => 'required|image|max:5120',
        ]);

        $order = order::findOrFail($id);
        if ($order->id_desainer !== auth()->id()) {
            abort(403, 'Anda bukan PIC desainer untuk pesanan ini.');
        }

        $latest = desain::where('id_pemesanan', $id)
            ->orderBy('draft_ke', 'desc')
            ->first();

        // No draft created by admin yet
        if (!$latest) {
            return back()->with('error', 'Draft belum dibuat oleh admin.');
        }
 
        if ($latest->status_desain === 'waiting_review') {
            return back()->with('error', 'Desain sedang menunggu review, tidak bisa upload.');
        }
 
        // Already approved — cannot upload
        if ($latest->status_desain === 'setuju') {
            return back()->with('error', 'Desain sudah disetujui, tidak bisa upload.');
        }

        // Always update latest draft — never create new record
        $filePath = $request->file('file_desain')->store('desain', 'public');

        $updateData = [
            'file_desain' => $filePath,
            'status_desain' => 'waiting_review', // Set status to waiting_review after upload
        ];  

        $latest->update($updateData);

        return back()->with('success', 'File desain berhasil diupload.');
    }
}
