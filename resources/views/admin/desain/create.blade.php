@extends('layouts.app')
@section('title', 'Tambah Draft Desain')
@section('subtitle', 'Pesanan #' . $order->id_pemesanan)

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
<div class="section-card">
    <div class="section-header">
        <h2 class="section-title">Formulir Pengajuan Draft Desain Baru</h2>
    </div>

    @if(session('success'))
        <div style="padding: 16px 24px; background: rgba(16, 185, 129, 0.1); color: var(--success); border-bottom: 1px solid var(--border);">
            <strong>{{ session('success') }}</strong>
        </div>
    @endif

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
        <form action="{{ route('admin.desain.store', $order->id_pemesanan) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label class="form-label">Upload Referensi Gambar/Desain Mentah (Opsional)</label>
                <input type="file" name="file_referensi" accept="image/*" class="form-input" style="padding:8px;">
            </div>

            <div class="form-group">
                <label class="form-label">Instruksi / Catatan untuk Desainer</label>
                <textarea name="catatan_admin" rows="5" class="form-input" placeholder="Tuliskan revisi, koreksi, atau ide desain yang Anda inginkan..." required></textarea>
            </div>

            <div class="form-action">
                <button type="submit" class="btn-primary">Ajukan Draft / Instruksi</button>
                <a href="{{ route('admin.orders.show', [$order->id_pemesanan, 'tab' => 'desain']) }}" class="btn-primary" style="background:var(--mid); color:var(--light); box-shadow:none;">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection