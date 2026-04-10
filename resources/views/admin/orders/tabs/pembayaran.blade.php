<!-- Bagian: Pembayaran & Keuangan -->
@if($order->status_pemesanan === 'dibatalkan')
    <div style="background: rgba(239, 68, 68, 0.1); border: 1px solid var(--danger); color: var(--danger); padding: 16px; border-radius: 8px; margin-bottom: 24px; display: flex; align-items: center; gap: 12px;">
        <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="12" y1="8" x2="12" y2="12"></line>
            <line x1="12" y1="16" x2="12.01" y2="16"></line>
        </svg>
        <div style="font-weight: 600;">⚠️ Pesanan ini telah dibatalkan. Seluruh aksi perubahan telah dinonaktifkan.</div>
    </div>
@endif
<div style="margin-bottom: 32px;">
    <h3 style="margin-bottom: 16px; font-size: 18px;">Kesepakatan Nominal Project</h3>
    @if($order->total_harga)
        <div class="card" style="display:flex; justify-content:space-between; align-items:center;">
            <div>
                <p style="font-size: 13px; color: var(--muted); margin-bottom: 8px;">Total Nilai Invoice yang Disepakati bersama Pelanggan:</p>
                <h2 style="font-size: 36px; color: var(--accent); margin: 0; font-weight:800;">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</h2>
            </div>
            
            @if($order->bukti_kesepakatan)
                <div style="text-align:right;">
                    <p style="font-size: 12px; color: var(--muted); margin-bottom: 6px;">SS/Dokumen Bukti Deal Harga:</p>
                    <a href="{{ asset('uploads/pembayaran/' . $order->bukti_kesepakatan) }}" target="_blank">
                        <!-- Tidak menggunakan border radius yg aneh, tetap bersih -->
                        <img src="{{ asset('uploads/pembayaran/' . $order->bukti_kesepakatan) }}" alt="Bukti Kesepakatan" style="max-height:80px; border: 1px solid var(--border);">
                    </a>
                </div>
            @endif
        </div>
    @else
        <div class="card" style="background: rgba(245, 158, 11, 0.05); border-color: var(--warning);">
            <p style="color:var(--warning); margin-bottom: 16px; font-weight:600; font-size: 15px;">⚠️ Admin Belum Mengunci Harga Final Pekerjaan Ini!</p>
            @if($order->status_pemesanan !== 'dibatalkan')
                <form action="{{ route('admin.orders.storeKesepakatan', $order->id_pemesanan) }}" method="POST" enctype="multipart/form-data" style="display:flex; gap:16px; align-items:flex-end;">
                    @csrf
                    <div class="form-group" style="flex:1; margin-bottom: 0;">
                        <label class="form-label">Masukkan Total Harga Tepat (Rp):</label>
                        <input type="number" name="total_harga" required class="form-control">
                    </div>
                    <div class="form-group" style="flex:1; margin-bottom: 0;">
                        <label class="form-label">Upload SS Bukti Chat (Screenshot Deal):</label>
                        <input type="file" name="bukti_kesepakatan" required accept="image/*" class="form-control">
                    </div>
                    <button type="submit" class="btn-primary" style="height: 42px;">Simpan Bukti Final</button>
                </form>
            @else
                <p style="color: var(--muted); font-size: 13px;">(Penyuntingan Harga dikunci karena Pesanan Batal)</p>
            @endif
        </div>
    @endif
</div>

<div>
    @php
        $totalDibayar = $order->pembayarans->where('status_verifikasi', '!=', 'ditolak')->sum('nominal');
    @endphp
    
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 16px;">
        <h3 style="font-size: 18px; margin: 0;">Histori Penagihan / Riwayat Transaksi</h3>
        @if($order->status_pemesanan !== 'dibatalkan')
            @if($order->total_harga && $totalDibayar < $order->total_harga)
                <a href="{{ route('admin.pembayaran.create', $order->id_pemesanan) }}" class="btn-primary">+ Buat Record Pembayaran Masuk</a>
            @elseif($order->total_harga && $totalDibayar >= $order->total_harga)
                <span class="alert-success" style="padding: 8px 16px; margin: 0;">✔ PEMBAYARAN LUNAS</span>
            @endif
        @else
            <span style="color: var(--danger); font-size: 13px; font-weight: 600;">AKSES PEMBAYARAN DITUTUP (BATAL)</span>
        @endif
    </div>

    <div class="card" style="padding: 0; overflow: hidden;">
        @if($order->pembayarans->isEmpty())
            <div style="text-align:center; padding: 40px; color: var(--muted);">Belum ada termin cicilan / transaksi uang yang dilaporkan ke sistem.</div>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Tgl Transaksi Bayar</th>
                        <th>Jenis Setoran</th>
                        <th>Lewat Saluran</th>
                        <th>Penerimaan Nominal</th>
                        <th>Keputusan (Finance)</th>
                        <th>Bukti Lampiran</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->pembayarans->sortByDesc('tanggal_bayar') as $bayar)
                    <tr>
                        <td>{{ date('d M Y (H:i)', strtotime($bayar->tanggal_bayar)) }}</td>
                        <td>
                            <span style="background:var(--mid); padding:4px 8px; border-radius:4px; font-size:11px; font-weight:bold;">
                                {{ strtoupper($bayar->jenis_pembayaran) }}
                            </span>
                        </td>
                        <td>{{ $bayar->metode_pembayaran ?? 'Penerimaan Kasir Manual' }}</td>
                        <td style="font-weight:700; color:var(--light);">Rp {{ number_format($bayar->nominal, 0, ',', '.') }}</td>
                        <td>
                            @if($bayar->status_verifikasi === 'disetujui')
                                <span style="color:var(--success); font-weight:600;">✓ Diverifikasi Akuntan</span>
                            @elseif($bayar->status_verifikasi === 'ditolak')
                                <span style="color:var(--danger); font-weight:600;">✗ Tertolak Kas ({{ $bayar->alasan_penolakan ?? 'Tidak Layak' }})</span>
                            @else
                                <span style="color:var(--warning); font-weight:600;">⌛ Pengecekan Rekening</span>
                            @endif
                        </td>
                        <td>
                            @if($bayar->bukti_pembayaran)
                                <a href="{{ asset('uploads/pembayaran/' . $bayar->bukti_pembayaran) }}" target="_blank" style="color:var(--accent); text-decoration:none; font-weight:600;">Buka Gambar Struk ↗</a>
                            @else
                                <span style="color:var(--muted);">- Kosong -</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
