<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Desain;
use App\Models\Order;
use Illuminate\Http\Request;

class DesainController extends Controller
{
    // Show form to create a new draft for a given order
    public function create($id)
    {
        $order = order::findOrFail($id);

        return view('admin.desain.create', compact('order'));
    }

    // Store new draft (admin only)
    public function store(Request $request, $id)
    {
        $request->validate([
            'file_referensi' => 'nullable|image|max:5120',
            'catatan_admin' => 'nullable|string',
        ]);

        $order = order::findOrFail($id);

        // Determine draft_ke
        $lastDraft = desain::where('id_pemesanan', $id)
            ->orderBy('draft_ke', 'desc')
            ->first();

        $draftKe = $lastDraft ? $lastDraft->draft_ke + 1 : 1;
        $statusDesain = $draftKe === 1 ? 'baru' : 'revisi';

        // Handle optional referensi file
        $fileReferensi = null;
        if ($request->hasFile('file_referensi')) {
            $fileReferensi = $request->file('file_referensi')->store('referensi', 'public');
        }

        desain::create([
            'id_pemesanan' => $id,
            'draft_ke' => $draftKe,
            'file_referensi' => $fileReferensi,
            'catatan_admin' => $request->catatan_admin,
            'file_desain' => null,
            'status_desain' => $statusDesain,
        ]);

        return redirect()->route('admin.orders.show', [$id, 'tab' => 'desain'])
            ->with('success', 'Draft ke-' . $draftKe . ' berhasil ditambahkan.');
    }

    // Admin draft detail page
    public function show($id)
    {
        $desain = desain::with('order')->findOrFail($id);

        return view('admin.desain.show', compact('desain'));
    }

    // Admin approves a draft
    public function approve($id)
    {
        $desain = desain::findOrFail($id);

        $desain->update(['status_desain' => 'setuju']);

        return redirect()->route('admin.desain.show', $id)
            ->with('success', 'Desain telah disetujui.');
    }
}
