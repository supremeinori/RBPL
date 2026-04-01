@extends('layouts.app')
@section('title', 'Detail Pekerjaan Desain')
@section('subtitle', 'Pemeriksaan karya grafis untuk Pesanan #' . $desain->id_pemesanan)

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
    <a href="{{ route('admin.orders.show', [$desain->id_pemesanan, 'tab' => 'desain']) }}" class="btn-primary" style="background:var(--mid); color:var(--light); box-shadow:none;">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right:4px;"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        Kembali ke Detail Pesanan
    </a>
    <div style="background:var(--white); padding: 8px 16px; border-radius: 8px; border: 1px solid var(--border); font-weight: 600; font-size:14px; color:var(--muted);">
        Draft Ke: <span style="color:var(--accent);">{{ $desain->draft_ke }}</span>
    </div>
</div>

@if(session('success'))
    <div style="padding: 16px 24px; background: rgba(16, 185, 129, 0.1); color: var(--success); border-bottom: 1px solid var(--border); margin-bottom: 24px; border-radius: 8px;">
        <strong>{{ session('success') }}</strong>
    </div>
@endif

<div class="stats-grid" style="display:grid; grid-template-columns: 1fr 1fr; gap:24px;">
    
    <!-- Bagian Kiri: Instruksi Admin -->
    <div class="section-card">
        <div class="section-header">
            <h2 class="section-title">Instruksi Awal / Referensi dari Admin</h2>
        </div>
        <div style="padding: 24px;">
            <p style="font-size:13px; font-weight:600; color:var(--muted); margin-bottom:8px;">Teks Catatan Admin:</p>
            <div style="background:var(--dark); padding:16px; border-radius:8px; border:1px solid var(--border); margin-bottom: 24px; font-size:14px; min-height:80px;">
                {{ $desain->catatan_admin ?? 'Tidak ada catatan tertulis.' }}
            </div>

            <p style="font-size:13px; font-weight:600; color:var(--muted); margin-bottom:8px;">File Referensi Gambar:</p>
            <div class="image-preview-box">
                @if($desain->file_referensi)
                    <img src="{{ asset('storage/' . $desain->file_referensi) }}" alt="Referensi">
                    <br>
                    <a href="{{ asset('storage/' . $desain->file_referensi) }}" download class="btn-primary" style="padding:6px 16px; font-size:12px; background:var(--mid); color:var(--light); box-shadow:none;">↓ Unduh File Referensi</a>
                @else
                    <p style="color:var(--muted); padding:30px 0;">Admin tidak melampirkan gambar referensi apapun.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Bagian Kanan: Hasil Karya Desainer -->
    <div class="section-card">
        <div class="section-header" style="display:flex; justify-content:space-between;">
            <h2 class="section-title">Hasil Render Desainer</h2>
            <div>
                @if($desain->status_desain === 'pending')
                    <span style="background: rgba(245, 158, 11, 0.1); color: var(--warning); padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 600;">Sedang Dikerjakan</span>
                @elseif($desain->status_desain === 'revisi')
                    <span style="background: rgba(239, 68, 68, 0.1); color: var(--danger); padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 600;">Menunggu Revisi Ulang</span>
                @elseif($desain->status_desain === 'setuju')
                    <span style="background: rgba(16, 185, 129, 0.1); color: var(--success); padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 600;">✓ Disetujui (Final)</span>
                @else
                    <span style="background:var(--accent); color:var(--white); padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 600;">Menunggu Preview Admin</span>
                @endif
            </div>
        </div>

        <div style="padding: 24px;">
            <div class="image-preview-box" style="min-height: 300px;">
                @if($desain->file_desain)
                    <img src="{{ asset('storage/' . $desain->file_desain) }}" alt="Hasil Karya">
                    <br>
                    <a href="{{ asset('storage/' . $desain->file_desain) }}" download class="btn-primary" style="padding:6px 16px; font-size:12px;">↓ Download Resolusi Tinggi</a>
                @else
                    <p style="color:var(--muted); padding:80px 0;">Desainer belum mengunggah karya hasil revisi iterasi ini.</p>
                @endif
            </div>

            <!-- Panel Keputusan Admin -->
            @if($desain->status_desain !== 'setuju')
                <div style="border-top: 1px solid var(--border); padding-top:24px;">
                    <h3 style="font-size:15px; font-weight:600; margin-bottom:16px;">Konfirmasi & Keputusan</h3>
                    
                    <div style="display:flex; gap:12px; flex-wrap:wrap;">
                        @if($desain->file_desain)
                            <form action="{{ route('admin.desain.approve', $desain->id_desain) }}" method="POST" style="margin:0;">
                                @csrf
                                <button type="submit" class="btn-primary" style="background:#10b981; border-color:#10b981;" onclick="return confirm('Apakah Anda yakin desain ini sudah fix/final dan siap untuk dicetak/dikirim?')">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right:6px;"><path d="M20 6L9 17l-5-5"/></svg>
                                    Setujui Karya (Final)
                                </button>
                            </form>
                        @endif

                        <a href="{{ route('admin.desain.create', $desain->id_pemesanan) }}" class="btn-primary" style="background:rgba(239, 68, 68, 0.1); color:var(--danger); box-shadow:none;">
                            Tolak & Ajukan Revisi Ulang
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection