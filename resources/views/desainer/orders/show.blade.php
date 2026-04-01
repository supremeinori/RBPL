@extends('layouts.app')
@section('title', 'Meja Kerja Desainer')
@section('subtitle', 'Pesanan: ' . $order->nama_pesanan)

@section('styles')
<style>
    .split-layout { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }
    .preview-box { background: var(--black); border: 1px dashed var(--border); border-radius: 8px; padding: 24px; text-align: center; }
    .preview-box img { max-width: 100%; max-height: 250px; border-radius: 6px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); margin-bottom: 12px; }
</style>
@endsection

@section('content')

<div style="margin-bottom: 24px;">
    <a href="{{ route('desainer.dashboard') }}" class="btn-primary" style="background:var(--mid); color:var(--light); box-shadow:none;">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right:4px;"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        Kembali ke Papan Tugas
    </a>
</div>

@if(session('success'))
    <div style="padding: 16px 24px; background: rgba(16, 185, 129, 0.1); color: var(--success); border-bottom: 1px solid var(--border); margin-bottom: 24px; border-radius: 8px;">
        <strong>{{ session('success') }}</strong>
    </div>
@endif

@php
    $latest = $order->desains->sortByDesc('draft_ke')->first();
@endphp

<div class="split-layout">
    <!-- Panel Kiri: Briefing Admin -->
    <div class="section-card">
        <div class="section-header">
            <h2 class="section-title">Brief & Instruksi dari Admin</h2>
            <span style="background:var(--mid); padding:4px 10px; border-radius:6px; font-size:12px; font-weight:600; color:var(--danger);">Target: {{ $order->deadline ? date('d M Y', strtotime($order->deadline)) : 'Tidak ditentukan' }}</span>
        </div>
        <div style="padding: 24px;">
            @if(!$latest)
                <div style="text-align:center; padding: 40px; border: 1px dashed var(--border); border-radius:8px;">
                    <p style="color:var(--muted); font-size:15px; font-weight:500;">Admin belum mengirimkan tiket instruksi (*Draft*) untuk pesanan ini.<br>Harap tunggu instruksi masuk terlebih dahulu.</p>
                </div>
            @else
                <div style="margin-bottom: 24px;">
                    <h4 style="font-size:13px; font-weight:700; color:var(--muted); text-transform:uppercase; margin-bottom:10px;">Catatan Admin (Draft Ke-{{ $latest->draft_ke }})</h4>
                    <div style="background:var(--mid); padding:16px; border-radius:8px; font-size:14px; color:var(--light); border: 1px solid var(--border); min-height:80px;">
                        {{ $latest->catatan_admin ?? 'Tidak ada catatan tertulis. Lanjutkan saja seperti biasa.' }}
                    </div>
                </div>

                <div>
                    <h4 style="font-size:13px; font-weight:700; color:var(--muted); text-transform:uppercase; margin-bottom:10px;">File Referensi Acuan</h4>
                    <div class="preview-box">
                        @if($latest->file_referensi)
                            <img src="{{ asset('storage/' . $latest->file_referensi) }}" alt="Referensi">
                            <br>
                            <a href="{{ asset('storage/' . $latest->file_referensi) }}" download class="btn-primary" style="font-size:12px;">↓ Unduh Resolusi Asli</a>
                        @else
                            <p style="color:var(--muted); padding:30px 0; margin:0;">Admin tidak melampirkan gambar sketsa atau referensi visual.</p>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Panel Kanan: Ruang Umpan Balik Desainer -->
    <div class="section-card">
        <div class="section-header">
            <h2 class="section-title">Fase Pengumpulan File Tender</h2>
            @if($latest && $latest->status_desain === 'revisi')
                <span style="background:rgba(239,68,68,0.1); color:var(--danger); padding:4px 10px; border-radius:6px; font-size:11px; font-weight:bold;">TUNTUTAN REVISI</span>
            @endif
        </div>

        <div style="padding: 24px;">
            @if(!$latest)
                <!-- Jika belum ada brief, blok kolom upload -->
                <div style="text-align:center; padding: 40px;">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--border)" stroke-width="2" style="margin-bottom:16px;"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                    <p style="color:var(--muted); font-size:14px;">Ruang upload akan terbuka setelah Admin membukakan sesi draft pertama.</p>
                </div>
            @else
                
                @if($latest->status_desain === 'setuju')
                    <!-- Sudah Disetujui -->
                    <div style="text-align:center; padding: 40px; border: 1px solid var(--success); background: rgba(16, 185, 129, 0.05); border-radius: 8px;">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--success)" stroke-width="2" style="margin-bottom:16px;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                        <h3 style="color:var(--success); font-weight:700; margin-bottom:8px;">Tahap Finalisasi Sukses</h3>
                        <p style="color:var(--light); font-size:14px; margin:0;">Desain pada iterasi terkini <strong>(Draft {{ $latest->draft_ke }})</strong> telah disetujui (ACC) oleh klien & admin. Pekerjaan untuk pesanan ini telah ditutup dengan tuntas.</p>
                    </div>
                @else
                    <!-- Sesi Upload / Replace Aktif -->
                    <div style="background:var(--black); border:1px solid var(--border); border-radius:8px; padding:24px; margin-bottom:24px;">
                        @if(!$latest->file_desain)
                            <h3 style="font-size:16px; font-weight:600; margin-bottom:16px; color:var(--white);">Serahkan Hasil Awal</h3>
                        @else
                            <h3 style="font-size:16px; font-weight:600; margin-bottom:16px; color:var(--white);">Upload Revisi / Timpa File Lama</h3>
                        @endif

                        <form action="{{ route('desainer.orders.upload', $order->id_pemesanan) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div style="margin-bottom: 20px;">
                                <label style="display:block; margin-bottom:8px; font-size:13px; font-weight:500;">Pilih File Format (*.jpg, *.png, *.pdf)</label>
                                <input type="file" name="file_desain" accept="image/*,application/pdf" required style="width:100%; padding:10px; border:1px dashed var(--muted); border-radius:6px; background:var(--dark);">
                            </div>
                            <button type="submit" class="btn-primary" style="width: 100%; justify-content:center; padding: 12px; font-size: 14px;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right:4px;"><polyline points="16 16 12 12 8 16"></polyline><line x1="12" y1="12" x2="12" y2="21"></line><path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"></path><polyline points="16 16 12 12 8 16"></polyline></svg>
                                {{ !$latest->file_desain ? 'Upload Render Bukti Pertama' : 'Kirim File Revisi Baru' }}
                            </button>
                        </form>
                    </div>
                @endif
                
                <!-- Histori Riwayat -->
                <h4 style="font-size:13px; font-weight:700; color:var(--muted); text-transform:uppercase; margin-bottom:12px;">Histori Penyerahan Karya</h4>
                <div class="table-wrap">
                    <table style="font-size:13px;">
                        <thead>
                            <tr>
                                <th style="padding:10px;">Iterasi</th>
                                <th style="padding:10px;">Status Feedback</th>
                                <th style="padding:10px;">Lihat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->desains->sortByDesc('draft_ke') as $d_histori)
                            <tr>
                                <td style="padding:10px;">
                                    <strong>Ke-{{ $d_histori->draft_ke }}</strong>
                                    {!! $d_histori->id_desain === $latest->id_desain ? '<span style="color:var(--accent);font-size:11px;margin-left:4px;">(Kini)</span>' : '' !!}
                                </td>
                                <td style="padding:10px;">
                                    @if($d_histori->status_desain === 'revisi')
                                        <span style="color:var(--danger); font-weight:bold;">Revisi</span>
                                    @elseif($d_histori->status_desain === 'setuju')
                                        <span style="color:var(--success); font-weight:bold;">Final ACC</span>
                                    @elseif($d_histori->status_desain === 'pending')
                                        <span style="color:var(--warning); font-weight:bold;">Minta Render</span>
                                    @else
                                        <span style="color:var(--muted); font-weight:bold;">Nunggu Review</span>
                                    @endif
                                </td>
                                <td style="padding:10px;">
                                    <a href="{{ route('desainer.desain.show', [$order->id_pemesanan, $d_histori->id_desain]) }}" style="color:var(--accent); text-decoration:none; font-weight:600;">Lihat Karya</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            @endif
        </div>
    </div>
</div>

@endsection