@extends('layouts.app')
@section('title', 'Dashboard Manajer Desain')
@section('subtitle', 'Daftar antrean pekerjaan karya grafis & monitoring progres')

@section('styles')
<style>
    .status-pill {
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.02em;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .table-wrap {
        overflow-x: auto;
    }
</style>
@endsection

@section('content')
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg>
        </div>
        <div class="stat-details">
            <span class="stat-label">Total Antrean</span>
            <span class="stat-value">{{ $orders->count() }}</span>
        </div>
    </div>
    
    <div class="stat-card success">
        <div class="stat-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
        </div>
        <div class="stat-details">
            <span class="stat-label">Selesai (ACC Final)</span>
            <span class="stat-value">
                {{ $orders->filter(function($o){ return $o->desains->sortByDesc('draft_ke')->first() && $o->desains->sortByDesc('draft_ke')->first()->status_desain === 'setuju'; })->count() }}
            </span>
        </div>
    </div>

    <div class="stat-card danger">
        <div class="stat-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
        </div>
        <div class="stat-details">
            <span class="stat-label">Butuh Revisi</span>
            <span class="stat-value">
                {{ $orders->filter(function($o){ return $o->desains->sortByDesc('draft_ke')->first() && $o->desains->sortByDesc('draft_ke')->first()->status_desain === 'revisi'; })->count() }}
            </span>
        </div>
    </div>
</div>

<div class="section-card">
    <div class="section-header">
        <h2 class="section-title">Papan Tugas / Jobsheet Reklame</h2>
    </div>
    <div class="table-wrap">
        <table class="table">
            <thead>
                <tr>
                    <th>ID Invoice</th>
                    <th>Nama Objek Desain</th>
                    <th>Deadline Target</th>
                    <th>Fase Iterasi</th>
                    <th>Status Review</th>
                    <th style="text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    @php
                        $latest = $order->desains->sortByDesc('draft_ke')->first();
                    @endphp
                    <tr>
                        <td><strong style="color: var(--white);">#{{ $order->id_pemesanan }}</strong></td>
                        <td style="font-weight:600; color: var(--light);">{{ $order->nama_pesanan }}</td>
                        <td>
                            <span style="background:var(--mid); padding:6px 12px; border-radius:6px; font-size:12px; font-weight:600; color: var(--light); border: 1px solid var(--border);">
                                {{ $order->deadline ? date('d M Y', strtotime($order->deadline)) : '-' }}
                            </span>
                        </td>
                        <td>
                            <div style="font-size: 13px; font-weight: 500;">Draft Ke-{{ $latest ? $latest->draft_ke : '0' }}</div>
                        </td>
                        <td>
                            @if(!$latest)
                                <span class="status-pill" style="background:rgba(245,158,11,0.08); color:var(--warning); border: 1px solid rgba(245,158,11,0.15);">
                                    ⏳ Tunggu Brief
                                </span>
                            @else
                                @if($latest->status_desain === 'pending')
                                    <span class="status-pill" style="background:rgba(37,99,235,0.08); color:var(--accent); border: 1px solid rgba(37,99,235,0.15);">
                                        🚀 Segera Upload
                                    </span>
                                @elseif($latest->status_desain === 'revisi')
                                    <span class="status-pill" style="background:rgba(239,68,68,0.08); color:var(--danger); border: 1px solid rgba(239,68,68,0.15);">
                                        ⚠ Butuh Revisi
                                    </span>
                                @elseif($latest->status_desain === 'setuju')
                                    <span class="status-pill" style="background:rgba(16,185,129,0.08); color:var(--success); border: 1px solid rgba(16,185,129,0.15);">
                                        ✓ ACC Final
                                    </span>
                                @else
                                    <span class="status-pill" style="background:var(--mid); color:var(--muted); border: 1px solid var(--border);">
                                        ⌛ Reviewing
                                    </span>
                                @endif
                            @endif
                        </td>
                        <td style="text-align: right;">
                            @if($latest && $latest->status_desain !== 'setuju')
                                <a href="{{ route('desainer.orders.show', $order->id_pemesanan) }}" class="btn-primary" 
                                   style="padding: 8px 16px; font-size:12px; background:var(--white); color:var(--dark);">Mulai Kerja ↗</a>
                            @elseif($latest && $latest->status_desain === 'setuju')
                                <a href="{{ route('desainer.orders.show', $order->id_pemesanan) }}" class="btn-primary" 
                                   style="padding: 8px 16px; font-size:12px; background:var(--mid); color:var(--light); box-shadow: none;">Lihat Hasil</a>
                            @else
                                <span style="color:var(--muted); font-size:12px; font-style:italic;">Menunggu Instruksi</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center; padding: 60px 20px;">
                            <div style="color:var(--muted); font-size:14px;">Tidak ada tiket pekerjaan grafis di antrean saat ini.</div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection