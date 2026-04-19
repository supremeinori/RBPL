<?php

namespace App\Http\Controllers\Akuntan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\Auth;

class PaymentValidationController extends Controller
{
    public function show($id)
    {
        $pembayaran = pembayaran::with('order.customer')->findOrFail($id);

        return view('akuntan.pembayaran.show', compact('pembayaran'));
    }

    public function approve($id)
    {
        $pembayaran = pembayaran::with('order')->findOrFail($id);

        $pembayaran->status_verifikasi = 'valid';
        $pembayaran->id_validator = Auth::id();
        $pembayaran->tanggal_validasi = now();
        $pembayaran->save();

        // Logika status pesanan otomatis
        $order = $pembayaran->order;
        if ($pembayaran->jenis_pembayaran === 'dp' && $order->status_pemesanan === 'pending') {
            $order->status_pemesanan = 'diproses';
            $order->save();
        }

        // Pengecekan Pelunasan Keseluruhan
        $totalTerbayar = $order->pembayarans()->where('status_verifikasi', 'valid')->sum('nominal');
        $desainApproved = $order->desains()->where('status_desain', 'setuju')->exists();

        if ($totalTerbayar >= $order->total_harga && $desainApproved) {
            $order->status_pemesanan = 'selesai';
            $order->save();
        }

        return redirect()->route('akuntan.dashboard')->with('success', 'Pembayaran ' . strtoupper($pembayaran->jenis_pembayaran) . ' Berhasil Divalidasi');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'alasan' => 'required|string|max:255',
        ]);

        $pembayaran = pembayaran::findOrFail($id);
        $pembayaran->status_verifikasi = 'tidak_valid';
        $pembayaran->id_validator = Auth::id();
        $pembayaran->tanggal_validasi = now();
        $pembayaran->alasan_penolakan = $request->alasan;
        $pembayaran->save();

        return redirect()->route('akuntan.dashboard')->with('error', 'Pembayaran ditolak!');
    }
}
