@extends('layouts.app')
@section('title', 'Meja Kerja Desainer')
@section('subtitle', 'Pesanan: ' . $order->nama_pesanan . ' — Pelanggan: ' . ($order->customer->nama ?? 'N/A'))

@section('styles')
<style>
    .split-layout { 
        display: grid; 
        grid-template-columns: 1.1fr 0.9fr; 
        gap: 32px; 
    }
    
    .preview-box { 
        background: var(--black); 
        border: 2px dashed var(--border); 
        border-radius: 12px; 
        padding: 32px; 
        text-align: center;
        transition: var(--transition);
    }
    
    .preview-box:hover {
        border-color: var(--accent);
    }

    .preview-box img { 
        max-width: 100%; 
        max-height: 320px; 
        border-radius: 8px; 
        box-shadow: 0 8px 24px rgba(0,0,0,0.08); 
        margin-bottom: 20px; 
    }

    .status-banner {
        padding: 24px;
        border-radius: 12px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .instruction-note {
        background: var(--mid); 
        padding: 20px; 
        border-radius: 10px; 
        font-size: 14.5px; 
        color: var(--light); 
        border-left: 4px solid var(--accent);
        line-height: 1.6;
    }

    .upload-zone {
        background: var(--dark);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 24px;
    }

    @media (max-width: 992px) {
        .split-layout { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')

<div style="margin-bottom: 32px; display: flex; justify-content: space-between; align-items: center;">
    <a href="{{ route('desainer.dashboard') }}" class="btn-primary" style="background:var(--mid); color:var(--light); box-shadow:none;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right:8px;"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        Kembali ke Dashboard
    </a>
    
    <div style="font-size: 13px; color: var(--muted); font-weight: 500;">
        ID Pesanan: <span style="color: var(--white);">#{{ $order->id_pemesanan }}</span>
    </div>
</div>

@if(session('success'))
    <div style="padding: 16px 24px; background: rgba(16, 185, 129, 0.1); color: var(--success); border: 1px solid rgba(16, 185, 129, 0.2); margin-bottom: 24px; border-radius: 12px; font-weight: 500; display: flex; align-items: center; gap: 10px;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
        {{ session('success') }}
    </div>
@endif

@php
    $latest = $order->desains->sortByDesc('draft_ke')->first();
@endphp

<div class="split-layout">
    <!-- Panel Kiri: Briefing Admin -->
    <div class="section-card">
        <div class="section-header">
            <h2 class="section-title">Brief & Instruksi Produksi</h2>
            <span style="background: rgba(239, 68, 68, 0.08); color: var(--danger); padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 700; border: 1px solid rgba(239, 68, 68, 0.15);">
                Deadline: {{ $order->deadline ? date('d M Y', strtotime($order->deadline)) : 'Menunggu DP' }}
            </span>
        </div>
        <div style="padding: 24px;">
            @if(!$latest)
                <div style="text-align:center; padding: 60px 20px; border: 2px dashed var(--border); border-radius:12px; background: var(--black);">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--muted)" stroke-width="1.5" style="margin-bottom: 16px; opacity: 0.5;"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg>
                    <p style="color:var(--muted); font-size:15px; font-weight:500; line-height: 1.5;">Admin belum merilis tiket instruksi untuk pesanan ini.<br><small style="font-weight: 400; opacity: 0.8;">Harap tunggu hingga sesi draft pertama dibuka.</small></p>
                </div>
            @else
                <div style="margin-bottom: 32px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                        <h4 style="font-size:12px; font-weight:700; color:var(--muted); text-transform:uppercase; letter-spacing: 0.05em;">Catatan Admin (Iterasi {{ $latest->draft_ke }})</h4>
                    </div>
                    <div class="instruction-note">
                        {{ $latest->catatan_admin ?? 'Tidak ada instruksi khusus tertulis. Silakan kerjakan sesuai dengan pesanan standar/brief awal.' }}
                    </div>
                </div>

                <div>
                    <h4 style="font-size:12px; font-weight:700; color:var(--muted); text-transform:uppercase; letter-spacing: 0.05em; margin-bottom:12px;">File Acuan / Referensi Visual</h4>
                    <div class="preview-box">
                        @if($latest->file_referensi)
                            <img src="{{ asset('storage/' . $latest->file_referensi) }}" alt="Referensi Pelanggan">
                            <div style="display: flex; gap: 12px; justify-content: center;">
                                <a href="{{ asset('storage/' . $latest->file_referensi) }}" target="_blank" class="btn-primary" style="background:var(--mid); color:var(--light); box-shadow:none; font-size: 12px;">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right:4px;"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                    Pratinjau
                                </a>
                                <a href="{{ asset('storage/' . $latest->file_referensi) }}" download class="btn-primary" style="font-size:12px;">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right:4px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                                    Unduh Asli
                                </a>
                            </div>
                        @else
                            <div style="padding: 40px 0;">
                                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--border)" stroke-width="1.5" style="margin-bottom:12px;"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                                <p style="color:var(--muted); margin:0; font-size: 14px;">Tidak ada lampiran referensi visual.</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Panel Kanan: Workspace Upload -->
    <div class="section-card">
        <div class="section-header">
            <h2 class="section-title">Penyelesaian Karya</h2>
            @if($latest && $latest->status_desain === 'revisi')
                <span style="background: rgba(239, 68, 68, 0.1); color: var(--danger); padding: 4px 12px; border-radius: 6px; font-size: 11px; font-weight: 800; border: 1px solid var(--danger);">REVISI DIMINTA</span>
            @endif
        </div>

        <div style="padding: 24px;">
            @if(!$latest)
                <div style="text-align:center; padding: 60px 0;">
                    <div style="width: 64px; height: 64px; background: var(--mid); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--muted)" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" /></svg>
                    </div>
                    <p style="color:var(--muted); font-size:14px; max-width: 250px; margin: 0 auto;">Workspace akan terbuka otomatis saat brief dari Admin telah siap.</p>
                </div>
            @else
                
                @if($latest->status_desain === 'setuju')
                    <div class="status-banner" style="background: rgba(16, 185, 129, 0.08); border: 1px solid rgba(16, 185, 129, 0.2); flex-direction: column; text-align: center;">
                        <div style="width: 56px; height: 56px; background: var(--success); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 16px; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        </div>
                        <h3 style="color:var(--white); font-weight:700; margin-bottom:8px; font-size: 18px;">Desain Final Disetujui</h3>
                        <p style="color:var(--light); font-size:14px; margin:0; line-height: 1.5;">Karya pada iterasi <strong>#{{ $latest->draft_ke }}</strong> telah dikunci (ACC). Kerja keras Anda telah membuahkan hasil!</p>
                    </div>
                @else
                    <div class="upload-zone">
                        @if($latest->status_desain === 'waiting_review') 
                            <div style="text-align: center; padding: 20px 0;">
                                <div style="display: inline-flex; align-items: center; gap: 8px; color: var(--warning); font-weight: 600; font-size: 15px; margin-bottom: 12px;">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                    Menunggu Review Admin
                                </div>
                                <p style="color:var(--muted); font-size:13.5px; margin: 0;">File Anda sedang diperiksa. Anda tidak dapat mengunggah file baru hingga ada feedback atau permintaan revisi.</p>
                            </div>
                        @else
                            <h3 style="font-size:15px; font-weight:700; margin-bottom:20px; color:var(--white); display: flex; align-items: center; gap: 8px;">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                                {{ !$latest->file_desain ? 'Serahkan Hasil Karya' : 'Kirim Revisi Terbaru' }}
                            </h3>

                            <form action="{{ route('desainer.orders.upload', $order->id_pemesanan) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div style="margin-bottom: 24px;">
                                    <label style="display:block; margin-bottom:10px; font-size:13px; font-weight:600; color: var(--muted);">Pilih File (JPG, PNG, atau PDF)</label>
                                    <div style="position: relative;">
                                        <input type="file" name="file_desain" accept="image/*,application/pdf" required 
                                            style="width:100%; padding:12px; border:2px dashed var(--border); border-radius:10px; background:var(--black); font-size: 13px; cursor: pointer;">
                                    </div>
                                    <p style="margin-top: 8px; font-size: 11px; color: var(--muted);">Pastikan resolusi mencukupi untuk proses review.</p>
                                </div>
                                <button type="submit" class="btn-primary" style="width: 100%; justify-content:center; padding: 14px; font-size: 14px; letter-spacing: 0.02em;">
                                    Kirim ke Admin Sekarang
                                </button>
                            </form>
                        @endif
                    </div>
                @endif
                
                <!-- Histori Riwayat -->
                <div style="margin-top: 32px;">
                    <h4 style="font-size:12px; font-weight:700; color:var(--muted); text-transform:uppercase; letter-spacing: 0.05em; margin-bottom:16px;">Log Aktivitas Penyerahan</h4>
                    <div class="table-wrap" style="border: 1px solid var(--border); border-radius: 12px; overflow: hidden;">
                        <table style="font-size:13px;">
                            <thead>
                                <tr>
                                    <th style="background: var(--mid);">Iterasi</th>
                                    <th style="background: var(--mid);">Status Internal</th>
                                    <th style="background: var(--mid); text-align: right;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->desains->sortByDesc('draft_ke') as $d_histori)
                                <tr>
                                    <td>
                                        <div style="font-weight: 700; color: var(--white);">Iterasi #{{ $d_histori->draft_ke }}</div>
                                        {!! $d_histori->id_desain === $latest->id_desain ? '<span style="color:var(--accent); font-size:10px; font-weight: 800; text-transform: uppercase;">Aktif Saat Ini</span>' : '' !!}
                                    </td>
                                    <td>
                                        @if($d_histori->status_desain === 'revisi')
                                            <span style="color:var(--danger); font-weight:700;">⚠ Revisi</span>
                                        @elseif($d_histori->status_desain === 'setuju')
                                            <span style="color:var(--success); font-weight:700;">✓ Final ACC</span>
                                        @elseif($d_histori->status_desain === 'pending')
                                            <span style="color:var(--muted); font-weight:700;">◔ Draft Kosong</span>
                                        @else
                                            <span style="color:var(--warning); font-weight:700;">⌛ Reviewing</span>
                                        @endif
                                    </td>
                                    <td style="text-align: right;">
                                        <a href="{{ route('desainer.desain.show', [$order->id_pemesanan, $d_histori->id_desain]) }}" 
                                           style="color:var(--accent); text-decoration:none; font-weight:700; font-size: 12px; display: inline-flex; align-items: center; gap: 4px;">
                                            Lihat Karya
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            @endif
        </div>
    </div>
</div>

@endsection