<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\pembayaran;
use App\Models\order;
class PaymentManagementController extends Controller
{
    public function storeKesepakatan(Request $request, $id)
    {
        $request->validate([
            'total_harga' => 'required|numeric|min:0',
            'bukti_kesepakatan' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $order = order::findOrFail($id);

        if ($request->hasFile('bukti_kesepakatan')) {
            $file = $request->file('bukti_kesepakatan');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/pembayaran'), $filename);

            $order->total_harga = $request->total_harga;
            $order->bukti_kesepakatan = $filename;
            $order->save();
        }

        return redirect()->route('admin.orders.show', [$order->id_pemesanan, 'tab' => 'pembayaran'])->with('success', 'Kesepakatan harga berhasil disimpan.');
    }

    public function create($id)
    {
        $order = order::findOrFail($id);

        $hasdp = $order->pembayarans
            ->where('jenis_pembayaran', 'dp')
            ->where('status_verifikasi', 'disetujui')
            ->count() > 0;

        // Cek total bayar yg sudah masuk
        $totalDibayar = $order->pembayarans()->where('status_verifikasi', '!=', 'ditolak')->sum('nominal');

        if ($order->total_harga && $totalDibayar >= $order->total_harga) {
            return redirect()->route('admin.orders.show', [$order->id_pemesanan, 'tab' => 'pembayaran'])->with('success', 'Pembayaran sudah lunas / mencapai harga sepakat.');
        }

        return view('admin.pembayaran.create', compact('order', 'hasdp'));
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'jenis_pembayaran' => 'required|in:dp,pelunasan,cicil,lunas',
            'metode_pembayaran' => 'required|string|max:255',
            'nominal' => 'required|numeric|min:1',
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $order = order::findOrFail($id);

        $totalDibayar = $order->pembayarans()->where('status_verifikasi', '!=', 'ditolak')->sum('nominal');
        $sisaTagihan = $order->total_harga - $totalDibayar;

        if ($request->nominal > $sisaTagihan) {
            return back()->with('error', 'Nominal melebihi sisa tagihan! Sisa tagihan: Rp ' . number_format($sisaTagihan, 0, ',', '.'));
        }

        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            $filename = time() . '_bayar_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/pembayaran'), $filename);

            pembayaran::create([
                'id_pemesanan' => $order->id_pemesanan,
                'tanggal_bayar' => now(),
                'jenis_pembayaran' => $request->jenis_pembayaran,
                'metode_pembayaran' => $request->metode_pembayaran,
                'nominal' => $request->nominal,
                'bukti_pembayaran' => $filename,
                'status_verifikasi' => 'pending', // Menunggu validasi akuntan
            ]);
        }

        return redirect()->route('admin.orders.show', [$order->id_pemesanan, 'tab' => 'pembayaran'])->with('success', 'Pembayaran berhasil ditambahkan. Menunggu validasi Akuntan.');
    }
}
