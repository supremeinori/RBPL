@extends('layouts.app')
@section('title', 'Validasi Pembayaran')
@section('subtitle', 'Daftar transaksi tertunda menunggu persetujuan')

@section('content')
<div class="section-card">
    <div class="section-header">
        <h2 class="section-title">Menunggu Validasi Akuntan</h2>
    </div>

    @if(session('success'))
        <div style="padding: 16px 24px; background: rgba(16, 185, 129, 0.1); color: var(--success); border-bottom: 1px solid var(--border);">
            <strong>{{ session('success') }}</strong>
        </div>
    @endif
    @if(session('error'))
        <div style="padding: 16px 24px; background: rgba(239, 68, 68, 0.1); color: var(--danger); border-bottom: 1px solid var(--border);">
            <strong>{{ session('error') }}</strong>
        </div>
    @endif

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Pesanan</th>
                    <th>Tgl Bayar</th>
                    <th>Nama Nasabah</th>
                    <th>Jenis</th>
                    <th>Nominal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendingPayments as $bayar)
                    <tr>
                        <td><strong>#{{ $bayar->id_pemesanan }}</strong></td>
                        <td>{{ date('d M Y', strtotime($bayar->tanggal_bayar)) }}</td>
                        <td>{{ optional(optional($bayar->order)->customer)->nama_pelanggan ?? 'Tanpa Pelanggan' }}</td>
                        <td><span style="background:var(--mid); padding:4px 8px; border-radius:6px; font-size:12px; border:1px solid var(--border);">{{ strtoupper($bayar->jenis_pembayaran) }}</span></td>
                        <td style="font-weight:600;">Rp {{ number_format($bayar->nominal, 0, ',', '.') }}</td>
                        <td style="color:var(--warning); font-weight:600;">{{ strtoupper($bayar->status_verifikasi) }}</td>
                        <td>
                            <a href="{{ route('akuntan.pembayaran.show', $bayar->id_pembayaran) }}" class="btn-primary" style="padding: 6px 12px; font-size:12px;">Validasi</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center; padding: 40px; color:var(--muted);">Tidak ada daftar tunggu pembayaran.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection