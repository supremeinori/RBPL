@extends('layouts.app')
@section('title', 'Tinjauan Detail Iterasi')
@section('subtitle', 'Pesanan: ' . $order->nama_pesanan . ' — Arsip Draft Iterasi Ke-' . $desain->draft_ke)

@section('styles')
    <style>
        .split-layout {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 32px;
        }

        .preview-box {
            background: var(--black);
            border: 2px dashed var(--border);
            border-radius: 12px;
            padding: 24px;
            text-align: center;
            transition: var(--transition);
            margin-bottom: 24px;
        }

        .preview-box img {
            max-width: 100%;
            max-height: 450px;
            border-radius: 8px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            margin-bottom: 20px;
            cursor: zoom-in;
        }

        .meta-card {
            background: var(--dark);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .meta-badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            border: 1px solid var(--border);
        }

        @media (max-width: 992px) {
            .split-layout {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection

@section('content')

    <div style="margin-bottom: 32px; display: flex; justify-content: space-between; align-items: center;">
        <a href="{{ route('desainer.orders.show', $order->id_pemesanan) }}" class="btn-primary"
            style="background:var(--mid); color:var(--light); box-shadow:none;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                style="margin-right:8px;">
                <path d="M19 12H5M12 19l-7-7 7-7" />
            </svg>
            Kembali ke Meja Kerja
        </a>

        <div style="display: flex; gap: 12px;">
            <div class="meta-badge" style="background: var(--mid); color: var(--light);">
                Iterasi: <span style="color: var(--accent);">#{{ $desain->draft_ke }}</span>
            </div>
            @if($desain->status_desain === 'setuju')
                <div class="meta-badge"
                    style="background: rgba(16, 185, 129, 0.08); color: var(--success); border-color: rgba(16, 185, 129, 0.2);">
                    ✓ Final ACC
                </div>
            @elseif($desain->status_desain === 'revisi')
                <div class="meta-badge"
                    style="background: rgba(239, 68, 68, 0.08); color: var(--danger); border-color: rgba(239, 68, 68, 0.2);">
                    ⚠ Revisi Aktif
                </div>
            @else
                <div class="meta-badge"
                    style="background: rgba(245, 158, 11, 0.08); color: var(--warning); border-color: rgba(245, 158, 11, 0.2);">
                    ⌛ Reviewing
                </div>
            @endif
        </div>
    </div>

    <div class="split-layout">
        <!-- Panel Kiri: Admin Briefing Archive -->
        <div class="section-card">
            <div class="section-header">
                <h2 class="section-title">Rekaman Instruksi Admin</h2>
            </div>
            <div style="padding: 24px;">
                <div style="margin-bottom: 24px;">
                    <h4
                        style="font-size:11px; font-weight:700; color:var(--muted); text-transform:uppercase; letter-spacing: 0.05em; margin-bottom:12px;">
                        Catatan Tertulis Sesi Ini:</h4>
                    <div
                        style="background:var(--mid); padding:20px; border-radius:10px; font-size:14px; color:var(--light); border-left: 4px solid var(--accent); line-height: 1.6;">
                        {{ $desain->catatan_admin ?? 'Tidak ada pesan instruksi khusus untuk iterasi ini.' }}
                    </div>
                </div>

                <h4
                    style="font-size:11px; font-weight:700; color:var(--muted); text-transform:uppercase; letter-spacing: 0.05em; margin-bottom:12px;">
                    File Referensi Pada Sesi Ini:</h4>
                <div class="preview-box">
                    @if($desain->file_referensi)
                        <img src="{{ asset('storage/' . $desain->file_referensi) }}" alt="Referensi Sesi">
                        <br>
                        <a href="{{ asset('storage/' . $desain->file_referensi) }}" download class="btn-primary"
                            style="background:var(--mid); color:var(--light); box-shadow:none; font-size: 12px;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                style="margin-right:6px;">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="7 10 12 15 17 10"></polyline>
                                <line x1="12" y1="15" x2="12" y2="3"></line>
                            </svg>
                            Unduh Manifest Rujukan
                        </a>
                    @else
                        <div style="padding: 60px 0;">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--border)"
                                stroke-width="1.5" style="margin-bottom:12px;">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                <polyline points="21 15 16 10 5 21"></polyline>
                            </svg>
                            <p style="color:var(--muted); margin:0; font-size: 14px;">Belum ada lampiran aset rujukan.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Panel Kanan: Artist Work Archive -->
        <div class="section-card">
            <div class="section-header">
                <h2 class="section-title">Dokumentasi Karya Diserahkan</h2>
            </div>
            <div style="padding: 24px;">
                <div class="preview-box"
                    style="min-height: 480px; display: flex; flex-direction: column; justify-content: center;">
                    @if($desain->file_desain)
                        <div style="flex: 1; display: flex; align-items: center; justify-content: center;">
                            <img src="{{ asset('storage/' . $desain->file_desain) }}" alt="Karya Anda">
                        </div>
                        <div style="padding-top: 20px;">
                            <a href="{{ asset('storage/' . $desain->file_desain) }}" download class="btn-primary"
                                style="font-size: 12px; padding: 10px 24px;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5" style="margin-right:6px;">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="7 10 12 15 17 10"></polyline>
                                    <line x1="12" y1="15" x2="12" y2="3"></line>
                                </svg>
                                Simpan Hasil Resolusi Tinggi
                            </a>
                        </div>
                    @else
                        <div style="padding: 60px 0;">
                            <div
                                style="width: 64px; height: 64px; background: var(--mid); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--muted)"
                                    stroke-width="1.5">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                    <polyline points="21 15 16 10 5 21"></polyline>
                                </svg>
                            </div>
                            <h4 style="color: var(--white); margin-bottom: 8px;">Karya Belum Diserahkan</h4>
                            <p
                                style="color:var(--muted); font-size:14px; margin:0; max-width: 280px; margin: 0 auto; line-height: 1.5;">
                                Anda belum mengunggah manifestasi seni digital untuk sesi iterasi ini.</p>
                        </div>
                    @endif
                </div>

                @if($desain->status_desain === 'revisi' && $desain->id_desain === $order->desains->sortByDesc('draft_ke')->first()->id_desain)
                    <div
                        style="background: rgba(239, 68, 68, 0.05); border: 1px dashed var(--danger); padding: 20px; border-radius: 12px; margin-top: 24px;">
                        <div style="display: flex; gap: 12px; align-items: flex-start;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--danger)"
                                stroke-width="2.5">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="8" x2="12" y2="12"></line>
                                <line x1="12" y1="16" x2="12.01" y2="16"></line>
                            </svg>
                            <div>
                                <h4 style="font-size: 14px; color: var(--danger); font-weight: 700; margin-bottom: 4px;">
                                    Permintaan Revisi Terdeteksi</h4>
                                <p style="font-size: 13px; color: var(--light); margin: 0;">Silakan perbaiki karya sesuai
                                    catatan di panel kiri dan unggah kembali di Meja Kerja.</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection