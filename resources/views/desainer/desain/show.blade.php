@extends('layouts.app')
@section('title', 'Tinjauan Karya Iterasi')
@section('subtitle', 'Pesanan: ' . $order->nama_pesanan . ' — Pengamatan Draft Ke-' . $desain->draft_ke)

@section('styles')
<style>
    .image-preview-box {
        background: var(--dark);
        border: 1px dashed var(--border);
        border-radius: 8px;
        padding: 24px;
        text-align: center;
        margin-bottom: 24px;
    }
    .image-preview-box img {
        max-width: 100%;
        max-height: 400px;
        border-radius: 6px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        margin-bottom: 16px;
    }
</style>
@endsection

@section('content')

<div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px;">
    <a href="{{ route('desainer.orders.show', $order->id_pemesanan) }}" class="btn-primary" style="background:var(--mid); color:var(--light); box-shadow:none;">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right:4px;"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        Kembali ke Meja Kerja Pesanan
    </a>
    
    <div style="display:flex; align-items:center; gap:12px;">
        <div style="background:var(--white); padding: 8px 16px; border-radius: 8px; border: 1px solid var(--border); font-weight: 600; font-size:14px; color:var(--muted);">
            Tinjauan Iterasi Ke: <span style="color:var(--accent);">{{ $desain->draft_ke }}</span>
        </div>
        <div style="background:var(--white); padding: 8px 16px; border-radius: 8px; border: 1px solid var(--border); font-weight: 600; font-size:14px; color:var(--muted);">
            Status Verifikasi: 
            @if($desain->status_desain === 'pending')
                <span style="color:var(--accent);">Belum Mengumpulkan Karya</span>
            @elseif($desain->status_desain === 'revisi')
                <span style="color:var(--danger);">Ditolak / Minta Perubahan</span>
            @elseif($desain->status_desain === 'setuju')
                <span style="color:var(--success);">Telah Disetujui (ACC)</span>
            @else
                <span style="color:var(--warning);">Review Ditahan Otoritas (Admin)</span>
            @endif
        </div>
    </div>
</div>


<div class="stats-grid" style="display:grid; grid-template-columns: 1fr 1fr; gap:24px;">
    
    <!-- Kolom Kiri: Briefing -->
    <div class="section-card">
        <div class="section-header">
            <h2 class="section-title">Rekaman Brief Dari Admin</h2>
        </div>
        <div style="padding: 24px;">
            <p style="font-size:13px; font-weight:600; color:var(--muted); margin-bottom:8px;">Tulisan Catatan Instruksi:</p>
            <div style="background:var(--dark); padding:16px; border-radius:8px; border:1px solid var(--border); margin-bottom: 24px; font-size:14px; min-height:80px;">
                {{ $desain->catatan_admin ?? 'Tidak ada catatan tertulis pada iterasi ini.' }}
            </div>

            <p style="font-size:13px; font-weight:600; color:var(--muted); margin-bottom:8px;">Arsip File Referensi/Aset Visual:</p>
            <div class="image-preview-box">
                @if($desain->file_referensi)
                    <img src="{{ asset('storage/' . $desain->file_referensi) }}" alt="Referensi Admin">
                    <br>
                    <a href="{{ asset('storage/' . $desain->file_referensi) }}" download class="btn-primary" style="padding:6px 16px; font-size:12px; background:var(--mid); color:var(--light); box-shadow:none;">↓ Unduh Modul Aset Ini</a>
                @else
                    <p style="color:var(--muted); padding:30px 0;">Tidak ada dokumen rujukan yang dibagikan admin.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Kolom Kanan: Hasil Karya Tertinggal -->
    <div class="section-card">
        <div class="section-header">
            <h2 class="section-title">Dokumentasi Karya yang Diserahkan</h2>
        </div>
        <div style="padding: 24px;">
            <div class="image-preview-box" style="min-height: 380px;">
                @if($desain->file_desain)
                    <img src="{{ asset('storage/' . $desain->file_desain) }}" alt="Preview Karya Final Anda">
                    <br>
                    <a href="{{ asset('storage/' . $desain->file_desain) }}" download class="btn-primary" style="padding:6px 16px; font-size:12px;">↓ Simpan Kembali File Resolusi Tinggi</a>
                @else
                    <div style="padding: 100px 0;">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--border)" stroke-width="2" style="margin-bottom:16px;"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                        <p style="color:var(--muted); font-size:14px; margin:0;">Belum ada manifestasi karya seni digital yang Anda upload<br> pada sistem untuk rekaman sesi tahap ini.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection