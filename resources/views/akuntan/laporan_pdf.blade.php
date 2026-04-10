<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; color: #1a1a1a; background: white; }
        .header { background: #1e1e2e; color: white; padding: 20px 28px; margin-bottom: 20px; }
        .header h1 { font-size: 20px; font-weight: 700; margin-bottom: 4px; }
        .header p { font-size: 12px; color: #9ca3af; }
        .meta-box { padding: 0 28px; margin-bottom: 20px; display: flex; gap: 40px; }
        .meta-item label { font-size: 10px; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: .05em; display: block; margin-bottom: 3px; }
        .meta-item span { font-size: 13px; font-weight: 600; color: #111827; }
        .summary-row { display: flex; gap: 16px; padding: 0 28px; margin-bottom: 24px; }
        .summary-card { flex: 1; background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; padding: 14px 16px; }
        .summary-card .label { font-size: 10px; color: #6b7280; text-transform: uppercase; letter-spacing: .05em; margin-bottom: 6px; }
        .summary-card .value { font-size: 15px; font-weight: 800; color: #111827; }
        .summary-card.green .value { color: #059669; }
        .summary-card.blue .value { color: #2563eb; }
        .summary-card.orange .value { color: #d97706; }
        .section-title { padding: 0 28px; margin-bottom: 12px; font-size: 13px; font-weight: 700; color: #374151; border-left: 3px solid #2563eb; padding-left: 12px; }
        table { width: 100%; border-collapse: collapse; }
        .table-wrap { padding: 0 28px; }
        thead tr { background: #f3f4f6; }
        thead th { padding: 10px 12px; font-size: 10px; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: .05em; text-align: left; border-bottom: 2px solid #e5e7eb; }
        tbody td { padding: 9px 12px; font-size: 11px; color: #374151; border-bottom: 1px solid #f3f4f6; }
        tbody tr:nth-child(even) { background: #f9fafb; }
        tfoot td { padding: 10px 12px; font-weight: 800; font-size: 12px; background: #f3f4f6; border-top: 2px solid #e5e7eb; }
        .badge-dp { background: #fef3c7; color: #92400e; padding: 2px 8px; border-radius: 10px; font-size: 10px; font-weight: 700; }
        .badge-lunas { background: #d1fae5; color: #065f46; padding: 2px 8px; border-radius: 10px; font-size: 10px; font-weight: 700; }
        .badge-ok { color: #059669; font-weight: 700; }
        .badge-no { color: #dc2626; font-weight: 700; }
        .badge-wait { color: #d97706; font-weight: 700; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .footer { margin-top: 30px; padding: 16px 28px; border-top: 1px solid #e5e7eb; color: #9ca3af; font-size: 10px; display: flex; justify-content: space-between; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Keuangan — MR BONGKENG</h1>
        <p>Digenerate pada: {{ now()->format('d F Y, H:i') }} WIB</p>
    </div>

    <div class="meta-box">
        <div class="meta-item">
            <label>Periode</label>
            <span>{{ date('d/m/Y', strtotime($filters['dari_tanggal'])) }} s/d {{ date('d/m/Y', strtotime($filters['sampai_tanggal'])) }}</span>
        </div>
        <div class="meta-item">
            <label>Jenis Laporan</label>
            <span>{{ ['ringkasan'=>'Ringkasan Pemasukan','detail'=>'Detail Pembayaran','rekap_pesanan'=>'Rekap per Pesanan','rekap_pelanggan'=>'Rekap per Pelanggan'][$filters['jenis_laporan'] ?? 'ringkasan'] }}</span>
        </div>
        <div class="meta-item">
            <label>Status Filter</label>
            <span>{{ ucfirst($filters['status_pembayaran'] ?? 'Semua') }}</span>
        </div>
        <div class="meta-item">
            <label>Jenis Bayar</label>
            <span>{{ ucfirst($filters['jenis_pembayaran'] ?? 'Semua') }}</span>
        </div>
    </div>

    <div class="summary-row">
        <div class="summary-card blue">
            <div class="label">Total Transaksi</div>
            <div class="value">{{ $data['ringkasan']['total_transaksi'] }} Transaksi</div>
        </div>
        <div class="summary-card green">
            <div class="label">Total Masuk</div>
            <div class="value">Rp {{ number_format($data['ringkasan']['total_masuk'], 0, ',', '.') }}</div>
        </div>
        <div class="summary-card orange">
            <div class="label">Total DP</div>
            <div class="value">Rp {{ number_format($data['ringkasan']['total_dp'], 0, ',', '.') }}</div>
        </div>
        <div class="summary-card green">
            <div class="label">Total Pelunasan</div>
            <div class="value">Rp {{ number_format($data['ringkasan']['total_pelunasan'], 0, ',', '.') }}</div>
        </div>
    </div>

    <p class="section-title">Detail Transaksi</p>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tanggal Bayar</th>
                    <th>Pesanan</th>
                    <th>Pelanggan</th>
                    <th>Jenis</th>
                    <th>Metode</th>
                    <th>Status</th>
                    <th class="text-right">Nominal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data['transaksi'] as $i => $bayar)
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td>{{ date('d/m/Y', strtotime($bayar->tanggal_bayar)) }}</td>
                    <td><strong>{{ $bayar->order->nama_pesanan ?? '-' }}</strong></td>
                    <td>{{ $bayar->order->customer->nama ?? '-' }}</td>
                    <td>
                        @if($bayar->jenis_pembayaran === 'dp')
                            <span class="badge-dp">DP</span>
                        @else
                            <span class="badge-lunas">PELUNASAN</span>
                        @endif
                    </td>
                    <td>{{ $bayar->metode_pembayaran ?? '-' }}</td>
                    <td>
                        @if($bayar->status_verifikasi === 'disetujui')
                            <span class="badge-ok">✓ Disetujui</span>
                        @elseif($bayar->status_verifikasi === 'ditolak')
                            <span class="badge-no">✗ Ditolak</span>
                        @else
                            <span class="badge-wait">⌛ Menunggu</span>
                        @endif
                    </td>
                    <td class="text-right"><strong>Rp {{ number_format($bayar->nominal, 0, ',', '.') }}</strong></td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center" style="padding: 30px; color: #9ca3af;">Tidak ada data transaksi.</td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="7">Grand Total Seluruh Transaksi</td>
                    <td class="text-right" style="color:#059669;">Rp {{ number_format($data['transaksi']->sum('nominal'), 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="footer">
        <span>© MR BONGKENG Manage System — Laporan ini digenerate secara otomatis oleh sistem.</span>
        <span>Halaman 1</span>
    </div>
</body>
</html>
