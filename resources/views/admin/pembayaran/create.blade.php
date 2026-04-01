<!DOCTYPE html>
<html>
<head>
@extends('layouts.app')
@section('title', 'Tambah Riwayat Pembayaran')
@section('subtitle', 'Pesanan #' . $order->id_pemesanan)

@section('content')
@php
    $totalDibayar = $order->pembayarans->where('status_verifikasi', '!=', 'ditolak')->sum('nominal');
    $sisaTagihan = $order->total_harga - $totalDibayar;
@endphp

<div class="section-card" style="max-width: 600px;">
    <div class="section-header">
        <h2 class="section-title">Form Input Pembayaran</h2>
    </div>
    
    <div style="padding: 24px;">
        <p style="margin-bottom: 24px; color: var(--muted);">Sisa tagihan otomatis dikalkulasi sistem. Segala bentuk input akan memerlukan validasi dari divisi Akuntan.</p>

        @if ($errors->any())
            <div style="background: rgba(239, 68, 68, 0.1); color: var(--danger); padding: 12px; border-radius: 8px; margin-bottom: 24px;">
                <ul style="margin-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.pembayaran.store', $order->id_pemesanan) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div style="margin-bottom: 16px;">
                <label style="display:block; margin-bottom:8px; font-weight:600; font-size: 13.5px;">Sifat Pembayaran: <span style="color:red;">*</span></label>
                <div style="display:flex; gap:16px;">
                    <label style="cursor:pointer; display:flex; align-items:center; gap:6px;">
                        <input type="radio" name="jenis_pembayaran" value="dp" required> DP
                    </label>
                    <label style="cursor:pointer; display:flex; align-items:center; gap:6px;">
                        <input type="radio" name="jenis_pembayaran" value="pelunasan"> Pelunasan
                    </label>
                </div>
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display:block; margin-bottom:8px; font-weight:600; font-size: 13.5px;">Nominal (Rp): <span style="color:red;">*</span></label>
                <p style="font-size:12px; color:var(--muted); margin-bottom:6px;">Sisa yang belum dibayar: Rp {{ number_format($sisaTagihan, 0, ',', '.') }}</p>
                <input type="number" name="nominal" min="1" max="{{ $sisaTagihan }}" style="width:100%; padding: 10px; border: 1px solid var(--border); border-radius: 6px; background:var(--black); color:var(--light);" required>
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display:block; margin-bottom:8px; font-weight:600; font-size: 13.5px;">Metode Pembayaran: <span style="color:red;">*</span></label>
                <select name="metode_pembayaran" required style="width:100%; padding: 10px; border: 1px solid var(--border); border-radius: 6px; background:var(--black); color:var(--light);">
                    <option value="" disabled selected>Pilih Salah Satu</option>
                    <option value="Tunai">Tunai / Cash</option>
                    <option value="Transfer Bank Mandiri">Transfer Bank Mandiri</option>
                    <option value="Transfer Bank BCA">Transfer Bank BCA</option>
                    <option value="Transfer Bank BRI">Transfer Bank BRI</option>
                    <option value="E-Wallet">E-Wallet (OVO/Dana/Gopay)</option>
                    <option value="Lainnya">Lainnya...</option>
                </select>
            </div>

            <div style="margin-bottom: 24px;">
                <label style="display:block; margin-bottom:8px; font-weight:600; font-size: 13.5px;">Upload Bukti Pembayaran: <span style="color:red;">*</span></label>
                <input type="file" name="bukti_pembayaran" accept="image/*" style="width:100%; padding: 8px; border: 1px dashed var(--border); border-radius: 6px;" required>
            </div>

            <div style="display:flex; gap: 12px;">
                <button type="submit" class="btn-primary">Simpan Transaksi</button>
                <a href="{{ route('admin.orders.show', $order->id_pemesanan) }}" class="btn-primary" style="background:var(--mid); color:var(--light); box-shadow:none;">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection