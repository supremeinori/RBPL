@extends('layouts.app')
@section('title', 'Dashboard Manajer Desain')
@section('subtitle', 'Daftar antrean pekerjaan karya grafis')

@section('content')
<div class="stats-grid" style="display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap:20px; margin-bottom: 32px;">
    <div class="stat-card" style="background:var(--dark); padding:24px; border-radius:var(--radius); border:1px solid var(--border); box-shadow:0 4px 15px rgba(0,0,0,0.03);">
        <div style="font-size:13px; color:var(--muted); text-transform:uppercase; font-weight:600; margin-bottom:8px;">Total Antrean</div>
        <div style="font-size:28px; font-weight:700; color:var(--white);">{{ $orders->count() }}</div>
    </div>
    <div class="stat-card" style="background:var(--dark); padding:24px; border-radius:var(--radius); border:1px solid var(--border); box-shadow:0 4px 15px rgba(0,0,0,0.03);">
        <div style="font-size:13px; color:var(--muted); text-transform:uppercase; font-weight:600; margin-bottom:8px;">Selesai (Di Acc)</div>
        <div style="font-size:28px; font-weight:700; color:var(--success);">
            {{ $orders->filter(function($o){ return $o->desains->first() && $o->desains->first()->status_desain === 'setuju'; })->count() }}
        </div>
    </div>
</div>

<div class="section-card">
    <div class="section-header">
        <h2 class="section-title">Papan Tugas / Jobsheet Reklame</h2>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>ID Invoice</th>
                    <th>Nama Objek Desain</th>
                    <th>Kebutuhan Deadline</th>
                    <th>Iterasi Terkini</th>
                    <th>Status Review</th>
                    <th>Tindakan Lanjutan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    @php
                        $latest = $order->desains->sortByDesc('draft_ke')->first();
                    @endphp
                    <tr>
                        <td><strong>#{{ $order->id_pemesanan }}</strong></td>
                        <td style="font-weight:600;">{{ $order->nama_pesanan }}</td>
                        <td><span style="background:var(--mid); padding:4px 8px; border-radius:6px; font-size:12px; font-weight:600;">{{ $order->deadline ? date('d M Y', strtotime($order->deadline)) : '-' }}</span></td>
                        <td>Draft Ke-{{ $latest ? $latest->draft_ke : '0' }}</td>
                        <td>
                            @if(!$latest)
                                <span style="background:rgba(245,158,11,0.1); color:var(--warning); padding:4px 8px; border-radius:4px; font-size:11px; font-weight:700;">Menunggu Brief Admin</span>
                            @else
                                @if($latest->status_desain === 'pending')
                                    <span style="background:rgba(59,130,246,0.1); color:var(--accent); padding:4px 8px; border-radius:4px; font-size:11px; font-weight:700;">Segera upload hasil</span>
                                @elseif($latest->status_desain === 'revisi')
                                    <span style="background:rgba(239,68,68,0.1); color:var(--danger); padding:4px 8px; border-radius:4px; font-size:11px; font-weight:700;">Membutuhkan Revisi</span>
                                @elseif($latest->status_desain === 'setuju')
                                    <span style="background:rgba(16,185,129,0.1); color:var(--success); padding:4px 8px; border-radius:4px; font-size:11px; font-weight:700;">ACC / Final</span>
                                @else
                                    <span style="background:var(--mid); padding:4px 8px; border-radius:4px; font-size:11px; font-weight:700;">{{ strtoupper($latest->status_desain) }}</span>
                                @endif
                            @endif
                        </td>
                        <td>
                            @if($latest && $latest->status_desain !== 'setuju')
                                <a href="{{ route('desainer.orders.show', $order->id_pemesanan) }}" class="btn-primary" style="padding: 6px 14px; font-size:12px; background:var(--accent); color:var(--white);">Mulai Bekerja ↗</a>
                            @elseif($latest && $latest->status_desain === 'setuju')
                                <a href="{{ route('desainer.orders.show', $order->id_pemesanan) }}" class="btn-primary" style="padding: 6px 14px; font-size:12px; background:var(--accent); color:var(--white);">Lihat Hasil ↗</a>
                            @else
                                <span style="color:var(--muted); font-size:13px; font-style:italic;">Belum ada brief</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center; padding: 40px; color:var(--muted);">Tidak ada tiket pekerjaan grafis di papan antrean.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection