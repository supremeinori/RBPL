@extends('layouts.app')
@section('title', 'Tambah Pesanan')
@section('subtitle', 'Daftarkan projek / pesanan pelanggan baru')

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

@section('content')
<div class="section-card" style="max-width: 600px;">
    <div class="section-header">
        <h2 class="section-title">Formulir Pesanan Baru</h2>
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
        <form action="{{ route('admin.orders.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label class="form-label">Pelanggan Pengorder</label>
                <select name="id_pelanggan" required class="form-input">
                    <option value="" disabled selected>-- Pilih Data Pelanggan --</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id_pelanggan }}" {{ old('id_pelanggan') == $customer->id_pelanggan ? 'selected' : '' }}>
                            {{ $customer->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Nama Pesanan / Layanan</label>
                <input type="text" name="nama_pesanan" value="{{ old('nama_pesanan') }}" required class="form-input" placeholder="Contoh: Pembuatan Baliho Festival">
            </div>

            <div style="display:grid; grid-template-columns: 1fr; gap: 16px;">
                <div class="form-group">
                    <label class="form-label">Tanggal Pemesanan</label>
                    <input type="date" name="tanggal_pemesanan" value="{{ old('tanggal_pemesanan', date('Y-m-d')) }}" required class="form-input">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Status Awalan Pesanan</label>
                <select name="status_pemesanan" required class="form-input">
                    <option value="pending" {{ old('status_pemesanan') == 'pending' ? 'selected' : '' }}>Pending</option>
                </select>
                <p style="font-size:12px; color:var(--muted); margin-top:6px;">Order baru akan berada di status pending hingga DP dibayar.</p>
            </div>

            <div class="form-group">
                <label class="form-label">Deskripsi / Detail Pesanan</label>
                <textarea name="deskripsi_pemesanan" rows="5" class="form-input" placeholder="Tuliskan catatan teknis secara lengkap disini...">{{ old('deskripsi_pemesanan') }}</textarea>
            </div>

            <div class="form-action">
                <button type="submit" class="btn-primary">Publikasi Order</button>
                <a href="/admin/dashboard" class="btn-primary" style="background:var(--mid); color:var(--light); box-shadow:none;">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection