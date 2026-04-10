@extends('layouts.app')
@section('title', 'Edit Pesanan')
@section('subtitle', 'Pembaruan data pesanan #' . ($order->id ?? $order->id_pemesanan ?? ''))

@section('styles')
<style>
    .form-group { margin-bottom: 20px; }
    .form-label { display: block; margin-bottom: 8px; font-weight: 500; font-size: 13.5px; }
    .form-input { 
        width: 100%; 
        padding: 10px 14px; 
        border: 1px solid var(--border); 
        border-radius: 8px; 
        background: var(--black); 
        color: var(--light); 
        font-family: inherit;
    }
    .form-input:focus { outline: none; border-color: var(--accent); }
    .form-action { display: flex; gap: 12px; margin-top: 32px; }
</style>
@endsection

@php
    // Determine the actual order ID regardless of object variation
    $orderId = $order->id ?? $order->id_pemesanan ?? 0;
@endphp

@section('content')
<div class="section-card">
    <div class="section-header">
        <h2 class="section-title">Formulir Update Pesanan</h2>
    </div>

    @if ($errors->any())
        <div style="background: rgba(239, 68, 68, 0.1); color: var(--danger); padding: 12px 24px; border-bottom: 1px solid var(--border);">
            <ul style="margin-left: 16px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div style="padding: 24px;">
        <form action="{{ route('admin.orders.update', $orderId) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label class="form-label">Pelanggan Pengorder</label>
                <select name="id_pelanggan" required class="form-input">
                    <option value="" disabled>-- Pilih Data Pelanggan --</option>
                    @if(isset($customers))
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id_pelanggan }}" {{ (old('id_pelanggan', $order->id_pelanggan ?? '') == $customer->id_pelanggan) ? 'selected' : '' }}>
                                {{ $customer->nama }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Nama Pesanan / Layanan</label>
                <input type="text" name="nama_pesanan" value="{{ old('nama_pesanan', $order->nama_pesanan ?? '') }}" required class="form-input">
            </div>

            <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label class="form-label">Tanggal Pemesanan</label>
                    <input type="date" name="tanggal_pemesanan" value="{{ old('tanggal_pemesanan', $order->tanggal_pemesanan ?? '') }}" required class="form-input">
                </div>

                <div class="form-group">
                    <label class="form-label">Deadline / Target Selesai</label>
                    <input type="date" name="deadline" value="{{ old('deadline', $order->deadline ?? '') }}" required class="form-input">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Status Awalan Pesanan</label>
                <select name="status_pemesanan" required class="form-input">
                    <option value="pending" {{ old('status_pemesanan', strtolower($order->status_pemesanan ?? '')) == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="diproses" {{ old('status_pemesanan', strtolower($order->status_pemesanan ?? '')) == 'diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="selesai" {{ old('status_pemesanan', strtolower($order->status_pemesanan ?? '')) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="dibatalkan" {{ old('status_pemesanan', strtolower($order->status_pemesanan ?? '')) == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Deskripsi / Detail Pesanan</label>
                <textarea name="deskripsi_pemesanan" rows="5" class="form-input">{{ old('deskripsi_pemesanan', $order->deskripsi_pemesanan ?? '') }}</textarea>
            </div>

            <div class="form-action">
                <button type="submit" class="btn-primary">Update Order</button>
                <a href="/admin/dashboard" class="btn-primary" style="background:var(--mid); color:var(--light); box-shadow:none;">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection