@extends('layouts.app')
@section('title', 'Detail Validasi')
@section('subtitle', 'Pemeriksaan pembayaran #' . $pembayaran->id_pemesanan)

@section('styles')
<style>
    .detail-grid {
        display: grid;
        grid-template-columns: 200px 1fr;
        gap: 12px;
        margin-bottom: 24px;
        font-size: 14px;
    }
    .detail-label { color: var(--muted); font-weight: 500; }
    .detail-value { color: var(--white); font-weight: 600; }
    
    .proof-img {
        max-width: 100%;
        max-height: 400px;
        border-radius: 8px;
        border: 1px solid var(--border);
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }

    .modal-backdrop {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(4px);
        z-index: 100;
        align-items: center;
        justify-content: center;
    }

    .modal-box {
        background: var(--dark);
        width: 100%;
        max-width: 450px;
        border-radius: var(--radius);
        padding: 24px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.2);
    }
    
    .modal-box h3 { margin-bottom: 16px; font-size: 16px; color: var(--white); }
    
    .radio-label {
        display: block;
        margin-bottom: 12px;
        font-size: 14px;
        cursor: pointer;
    }
    
    .custom-input {
        width: 100%;
        padding: 10px;
        border: 1px solid var(--border);
        border-radius: 6px;
        background: var(--black);
        color: var(--light);
        margin-top: 8px;
        font-family: inherit;
    }

    .action-group {
        display: flex;
        gap: 12px;
        margin-top: 32px;
        padding-top: 24px;
        border-top: 1px solid var(--border);
    }
    
    .btn-success { background: var(--success); color: white; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px;}
    .btn-danger { background: var(--danger); color: white; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px;}
    .btn-cancel { background: var(--mid); color: var(--light); border: none; padding: 10px 20px; border-radius: 8px; font-weight: 600; cursor: pointer; }
</style>
@endsection

@section('content')
<div class="section-card">
    <div class="section-header">
        <h2 class="section-title">Dokumen Transaksi</h2>
        <a href="{{ route('akuntan.dashboard') }}" class="btn-cancel" style="padding: 6px 12px; font-size: 12px; text-decoration: none;">Ke Dashboard</a>
    </div>

    <div style="padding: 32px;">
        <div class="detail-grid">
            <div class="detail-label">ID Pesanan</div>
            <div class="detail-value">#{{ $pembayaran->id_pemesanan }}</div>
            
            <div class="detail-label">Nama Pelanggan</div>
            <div class="detail-value">{{ optional(optional($pembayaran->order)->customer)->nama_pelanggan }}</div>
            
            <div class="detail-label">Metode Pembayaran</div>
            <div class="detail-value">{{ $pembayaran->metode_pembayaran ?? '-' }}</div>
            
            <div class="detail-label">Sifat Pembayaran</div>
            <div class="detail-value" style="color: var(--accent);">{{ strtoupper($pembayaran->jenis_pembayaran) }}</div>
            
            <div class="detail-label">Total Kesepakatan</div>
            <div class="detail-value">Rp {{ number_format(optional($pembayaran->order)->total_harga ?? 0, 0, ',', '.') }}</div>
            
            <div class="detail-label" style="font-size:16px;">Nominal Dibayar</div>
            <div class="detail-value" style="font-size:16px; color: var(--success);">Rp {{ number_format($pembayaran->nominal, 0, ',', '.') }}</div>
        </div>

        <h3 style="font-size: 14px; color: var(--muted); margin-bottom: 12px; margin-top: 24px;">BuktI Pembayaran:</h3>
        @if($pembayaran->bukti_pembayaran)
            <img src="{{ asset('uploads/pembayaran/' . $pembayaran->bukti_pembayaran) }}" alt="Bukti Pembayaran" class="proof-img">
        @else
            <div style="padding: 24px; background: rgba(0,0,0,0.03); border-radius: 8px; border: 1px dashed var(--border); color: var(--muted); text-align: center;">
                Tidak ada file gambar referensi dilampirkan.
            </div>
        @endif

        @if($pembayaran->status_verifikasi === 'pending')
            <div class="action-group">
                <form action="{{ route('akuntan.pembayaran.approve', $pembayaran->id_pembayaran) }}" method="POST" id="formValid">
                    @csrf
                    <button type="button" onclick="confirmValid()" class="btn-success">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                        Nyatakan Valid
                    </button>
                </form>

                <button type="button" onclick="showRejectModal()" class="btn-danger">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                    Tolak Pembayaran
                </button>
            </div>
        @else
            <div style="margin-top: 32px; padding-top: 24px; border-top: 1px solid var(--border); display: flex; align-items: center; gap: 12px;">
                <div style="padding: 12px 20px; border-radius: 8px; background: rgba(255,255,255,0.03); border: 1px solid var(--border); color: var(--muted); font-size: 14px; display: flex; align-items: center; gap: 10px;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                    @if($pembayaran->status_verifikasi === 'valid')
                        Pembayaran ini sudah <span style="color: var(--success); font-weight: 700;">VALID</span> oleh {{ $pembayaran->validator->name ?? 'Sistem' }} pada {{ date('d/m/Y H:i', strtotime($pembayaran->tanggal_validasi)) }}
                    @else
                        Pembayaran ini sudah <span style="color: var(--danger); font-weight: 700;">TIDAK VALID</span> dengan alasan: <span style="color: var(--light);">{{ $pembayaran->alasan_penolakan }}</span>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Modal Penolakan -->
<div class="modal-backdrop" id="rejectModal">
    <div class="modal-box">
        <h3>Alasan Penolakan</h3>
        <form action="{{ route('akuntan.pembayaran.reject', $pembayaran->id_pembayaran) }}" method="POST">
            @csrf
            
            <label class="radio-label"><input type="radio" name="alasan" value="Transaksi tidak ditemukan" required onclick="toggleCustom(false)"> M1 - Mutasi/Transaksi tidak ditemukan di Rekening</label>
            <label class="radio-label"><input type="radio" name="alasan" value="Nominal tidak sesuai" onclick="toggleCustom(false)"> M2 - Nominal transfer berbeda dari nominal input</label>
            <label class="radio-label"><input type="radio" name="alasan" value="Bukti pembayaran tidak jelas" onclick="toggleCustom(false)"> M3 - Bukti layar gambar tidak jelas/blur</label>
            <label class="radio-label"><input type="radio" name="alasan" id="radioLainnya" value="Lainnya" onclick="toggleCustom(true)"> Lainnya</label>
            
            <input type="text" id="customAlasan" name="alasan_custom" class="custom-input" placeholder="Ketik alasan spesifik..." style="display:none;">
            
            <div style="display: flex; gap: 8px; margin-top: 24px;">
                <button type="submit" class="btn-danger">Simpan Penolakan</button>
                <button type="button" onclick="closeRejectModal()" class="btn-cancel">Batal</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Info Valid -->
<div class="modal-backdrop" id="validModal">
    <div class="modal-box" style="border-top: 4px solid var(--success);">
        <h3 style="color: var(--success); margin-bottom: 8px;">Pemberitahuan Sistem</h3>
        <p style="font-size: 14px; margin-bottom: 16px; color: var(--muted);">
            Pembayaran <strong>{{ strtoupper($pembayaran->jenis_pembayaran) }}</strong> ini akan divalidasi. Aksi ini akan otomatis tercatat atas nama Anda.
        </p>
        <div style="background: rgba(16,185,129,0.05); padding: 12px; border-radius: 8px; font-size: 13px; font-family: monospace; color: var(--success); margin-bottom: 24px;">
            Validator: {{ Auth::user()->name }}<br>
            Waktu: {{ now()->format('Y-m-d H:i') }}
        </div>
        <div style="display: flex; gap: 8px;">
            <button type="button" onclick="submitValidForm()" class="btn-success">Konfirmasi Valid</button>
            <button type="button" onclick="document.getElementById('validModal').style.display = 'none';" class="btn-cancel">Kembali</button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function confirmValid() {
        document.getElementById('validModal').style.display = 'flex';
    }

    function submitValidForm() {
        document.getElementById('formValid').submit();
    }

    function showRejectModal() {
        document.getElementById('rejectModal').style.display = 'flex';
    }

    function closeRejectModal() {
        document.getElementById('rejectModal').style.display = 'none';
    }

    function toggleCustom(show) {
        const customInput = document.getElementById('customAlasan');
        if(show) {
            customInput.style.display = 'block';
            customInput.name = 'alasan';
            document.getElementById('radioLainnya').name = 'ignore_alasan';
        } else {
            customInput.style.display = 'none';
            customInput.name = 'alasan_custom';
            document.getElementById('radioLainnya').name = 'alasan';
        }
    }
</script>
@endsection
