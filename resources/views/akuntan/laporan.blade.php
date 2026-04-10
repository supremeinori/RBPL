@extends('layouts.app')
@section('title', 'Laporan Keuangan')
@section('subtitle', 'Generate & Export Laporan Keuangan Perusahaan')

@section('content')

@if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
@endif

<div style="display: grid; grid-template-columns: 360px 1fr; gap: 28px; align-items: start;">

    {{-- PANEL FILTER KIRI --}}
    <div class="card" style="position: sticky; top: 90px;">
        <h3 style="font-size: 15px; font-weight: 700; color: var(--white); margin-bottom: 20px; display: flex; align-items: center; gap: 8px;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px;">
                <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/>
            </svg>
            Filter Laporan
        </h3>

        <form method="GET" action="{{ route('akuntan.laporan') }}" id="form-filter">

            {{-- Periode --}}
            <div style="margin-bottom: 20px;">
                <p style="font-size: 11px; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: .08em; margin-bottom: 12px;">Periode Laporan</p>
                <div class="form-group">
                    <label class="form-label">Dari Tanggal</label>
                    <input type="date" name="dari_tanggal" class="form-control" value="{{ $filters['dari_tanggal'] ?? date('Y-m-01') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Sampai Tanggal</label>
                    <input type="date" name="sampai_tanggal" class="form-control" value="{{ $filters['sampai_tanggal'] ?? date('Y-m-t') }}" required>
                </div>
            </div>

            {{-- Jenis Laporan --}}
            <div style="margin-bottom: 20px; padding-top: 16px; border-top: 1px solid var(--border);">
                <p style="font-size: 11px; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: .08em; margin-bottom: 12px;">Jenis Laporan</p>
                @foreach(['ringkasan' => 'Ringkasan Pemasukan', 'detail' => 'Detail Pembayaran Pesanan', 'rekap_pesanan' => 'Rekap Per Pesanan', 'rekap_pelanggan' => 'Rekap Per Pelanggan'] as $val => $label)
                <label style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px; cursor: pointer; font-size: 14px; color: var(--light);">
                    <input type="radio" name="jenis_laporan" value="{{ $val }}" 
                        {{ ($filters['jenis_laporan'] ?? 'ringkasan') === $val ? 'checked' : '' }}
                        style="accent-color: var(--accent); width: 15px; height: 15px;">
                    {{ $label }}
                </label>
                @endforeach
            </div>

            {{-- Filter Tambahan --}}
            <div style="margin-bottom: 20px; padding-top: 16px; border-top: 1px solid var(--border);">
                <p style="font-size: 11px; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: .08em; margin-bottom: 12px;">Filter Tambahan (Opsional)</p>

                <div class="form-group">
                    <label class="form-label">Status Pembayaran</label>
                    <select name="status_pembayaran" class="form-control">
                        <option value="semua">Semua</option>
                        <option value="disetujui" {{ ($filters['status_pembayaran'] ?? '') === 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                        <option value="menunggu" {{ ($filters['status_pembayaran'] ?? '') === 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="ditolak" {{ ($filters['status_pembayaran'] ?? '') === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Jenis Pembayaran</label>
                    <select name="jenis_pembayaran" class="form-control">
                        <option value="semua">Semua (DP & Pelunasan)</option>
                        <option value="dp" {{ ($filters['jenis_pembayaran'] ?? '') === 'dp' ? 'selected' : '' }}>DP</option>
                        <option value="pelunasan" {{ ($filters['jenis_pembayaran'] ?? '') === 'pelunasan' ? 'selected' : '' }}>Pelunasan</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Pelanggan</label>
                    <select name="id_pelanggan" class="form-control">
                        <option value="semua">Semua Pelanggan</option>
                        @foreach($customers as $c)
                            <option value="{{ $c->id_pelanggan }}" {{ ($filters['id_pelanggan'] ?? '') == $c->id_pelanggan ? 'selected' : '' }}>{{ $c->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <button type="submit" class="btn-primary" style="width: 100%; justify-content: center; padding: 12px;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:15px;height:15px;">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                Generate Laporan
            </button>
        </form>
    </div>

    {{-- PANEL HASIL KANAN --}}
    <div>
        @if($data)
        {{-- Header Hasil --}}
        <div class="card" style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%); border-color: rgba(59,130,246,0.3);">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px;">
                <div>
                    <h2 style="font-size: 18px; font-weight: 800; color: var(--white); margin-bottom: 6px;">Hasil Laporan Keuangan</h2>
                    <p style="font-size: 13px; color: var(--subtle);">
                        Periode <strong style="color:var(--accent);">{{ date('d/m/Y', strtotime($filters['dari_tanggal'])) }}</strong> 
                        s/d <strong style="color:var(--accent);">{{ date('d/m/Y', strtotime($filters['sampai_tanggal'])) }}</strong>
                        &nbsp;·&nbsp; Jenis: <strong style="color:var(--light);">{{ ['ringkasan'=>'Ringkasan Pemasukan','detail'=>'Detail Pembayaran','rekap_pesanan'=>'Rekap per Pesanan','rekap_pelanggan'=>'Rekap per Pelanggan'][$filters['jenis_laporan'] ?? 'ringkasan'] }}</strong>
                    </p>
                </div>
                <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                    {{-- Download PDF --}}
                    <form method="GET" action="{{ route('akuntan.laporan.pdf') }}" style="margin:0;">
                        @foreach($filters as $k => $v)
                            <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                        @endforeach
                        <button type="submit" class="btn-secondary" style="font-size: 12px; gap: 5px;">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:13px;height:13px;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                            PDF
                        </button>
                    </form>
                    {{-- Download CSV/Excel --}}
                    <form method="GET" action="{{ route('akuntan.laporan.csv') }}" style="margin:0;">
                        @foreach($filters as $k => $v)
                            <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                        @endforeach
                        <button type="submit" class="btn-secondary" style="font-size: 12px; gap: 5px; color: var(--success); border-color: rgba(16,185,129,0.25);">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:13px;height:13px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                            Excel (CSV)
                        </button>
                    </form>
                    {{-- Print --}}
                    <button onclick="window.print()" class="btn-secondary" style="font-size: 12px; gap: 5px;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:13px;height:13px;"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                        Print
                    </button>
                </div>
            </div>
        </div>

        {{-- Ringkasan Cards --}}
        @if(in_array($filters['jenis_laporan'] ?? 'ringkasan', ['ringkasan', 'detail']))
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px;">
            @php
                $summaryCards = [
                    ['label'=>'Total Transaksi','value'=> $data['ringkasan']['total_transaksi'], 'prefix'=>'', 'suffix'=>' Transaksi', 'color'=>'var(--accent)'],
                    ['label'=>'Total Masuk','value'=> 'Rp ' . number_format($data['ringkasan']['total_masuk'],0,',','.'), 'prefix'=>'', 'suffix'=>'', 'color'=>'var(--success)'],
                    ['label'=>'Total DP','value'=> 'Rp ' . number_format($data['ringkasan']['total_dp'],0,',','.'), 'prefix'=>'', 'suffix'=>'', 'color'=>'var(--warning)'],
                    ['label'=>'Total Pelunasan','value'=> 'Rp ' . number_format($data['ringkasan']['total_pelunasan'],0,',','.'), 'prefix'=>'', 'suffix'=>'', 'color'=>'var(--success)'],
                ];
            @endphp
            @foreach($summaryCards as $sc)
            <div class="card" style="margin-bottom: 0; padding: 16px 20px; border-color: rgba(255,255,255,0.05);">
                <p style="font-size: 11px; color: var(--muted); text-transform: uppercase; letter-spacing: .06em; margin-bottom: 8px;">{{ $sc['label'] }}</p>
                <p style="font-size: 20px; font-weight: 800; color: {{ $sc['color'] }};">{{ $sc['value'] }}{{ $sc['suffix'] }}</p>
            </div>
            @endforeach
        </div>
        @endif

        {{-- Tabel Detail Transaksi --}}
        <div class="card" style="padding: 0; overflow: hidden;">
            <div style="padding: 20px 24px 16px; border-bottom: 1px solid var(--border);">
                <h4 style="font-size: 14px; font-weight: 700; color: var(--white); margin: 0;">Detail Transaksi</h4>
            </div>

            @if($data['transaksi']->isEmpty())
                <div style="text-align: center; padding: 60px; color: var(--muted);">
                    Tidak ada transaksi yang cocok dengan filter yang dipilih.
                </div>
            @else
                <div style="overflow-x: auto;">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tanggal Bayar</th>
                                <th>Pesanan</th>
                                <th>Pelanggan</th>
                                <th>Jenis</th>
                                <th>Metode</th>
                                <th>Status</th>
                                <th style="text-align: right;">Nominal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['transaksi'] as $i => $bayar)
                            <tr>
                                <td style="color: var(--muted); font-size: 12px;">{{ $i + 1 }}</td>
                                <td>{{ date('d M Y', strtotime($bayar->tanggal_bayar)) }}</td>
                                <td style="font-weight: 600; color: var(--white);">{{ $bayar->order->nama_pesanan ?? '-' }}</td>
                                <td>{{ $bayar->order->customer->nama ?? '-' }}</td>
                                <td>
                                    <span style="background: {{ $bayar->jenis_pembayaran === 'dp' ? 'rgba(245,158,11,0.15)' : 'rgba(16,185,129,0.15)' }}; color: {{ $bayar->jenis_pembayaran === 'dp' ? 'var(--warning)' : 'var(--success)' }}; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 700;">
                                        {{ strtoupper($bayar->jenis_pembayaran) }}
                                    </span>
                                </td>
                                <td style="color: var(--subtle); font-size: 13px;">{{ $bayar->metode_pembayaran ?? '-' }}</td>
                                <td>
                                    @if($bayar->status_verifikasi === 'disetujui')
                                        <span style="color: var(--success); font-weight: 600; font-size: 12px;">✓ Disetujui</span>
                                    @elseif($bayar->status_verifikasi === 'ditolak')
                                        <span style="color: var(--danger); font-weight: 600; font-size: 12px;">✗ Ditolak</span>
                                    @else
                                        <span style="color: var(--warning); font-weight: 600; font-size: 12px;">⌛ Menunggu</span>
                                    @endif
                                </td>
                                <td style="text-align: right; font-weight: 700; color: var(--white);">
                                    Rp {{ number_format($bayar->nominal, 0, ',', '.') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr style="background: rgba(255,255,255,0.02);">
                                <td colspan="7" style="font-weight: 700; color: var(--subtle); padding: 14px 16px;">Total Keseluruhan</td>
                                <td style="text-align: right; font-weight: 800; font-size: 16px; color: var(--success); padding: 14px 16px;">
                                    Rp {{ number_format($data['transaksi']->sum('nominal'), 0, ',', '.') }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @endif
        </div>

        @else
        {{-- Empty State --}}
        <div class="card" style="text-align: center; padding: 80px 40px;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="width:56px;height:56px;color:var(--border);margin:0 auto 20px;">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/>
            </svg>
            <h3 style="color: var(--white); font-size: 18px; margin-bottom: 8px;">Siap Generate Laporan</h3>
            <p style="color: var(--muted); font-size: 14px;">Atur filter di sebelah kiri dan klik <strong style="color:var(--light);">Generate Laporan</strong> untuk melihat hasilnya.</p>
        </div>
        @endif
    </div>
</div>

@endsection
