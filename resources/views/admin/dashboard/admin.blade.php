@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('subtitle', "Welcome back! Here's what's happening today.")

@section('styles')
<style>
    /* ── Stats Cards ── */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 16px;
        margin-bottom: 32px;
    }

    .stat-card {
        background: var(--dark);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 16px 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.3);
        animation: fadeUp 0.5s cubic-bezier(0.22,1,0.36,1) both;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .stat-card:nth-child(2) { animation-delay: 0.05s; }
    .stat-card:nth-child(3) { animation-delay: 0.10s; }
    .stat-card:nth-child(4) { animation-delay: 0.15s; }

    .stat-label {
        font-size: 11px;
        font-weight: 600;
        color: var(--muted);
        text-transform: uppercase;
        letter-spacing: 0.07em;
    }

    .stat-value {
        font-size: 20px;
        font-weight: 700;
        color: var(--white);
        letter-spacing: -0.5px;
        line-height: 1;
    }

    /* Status badge */
    .badge {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 600;
        letter-spacing: 0.03em;
    }

    .badge-pending {
        background: rgba(255,255,255,0.07);
        border: 1px solid var(--border);
        color: var(--subtle);
    }

    .badge-done {
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.2);
        color: var(--white);
    }

    .badge-cancel {
        background: rgba(239,68,68,0.08);
        border: 1px solid rgba(239,68,68,0.2);
        color: #fca5a5;
    }

    .td-id { color: var(--muted); font-variant-numeric: tabular-nums; font-size: 12.5px; }
    .td-name { font-weight: 500; color: var(--white); }

    /* Empty state */
    .empty-state { padding: 48px 24px; text-align: center; }
    .empty-state p { color: var(--muted); font-size: 14px; margin-bottom: 16px; }
</style>
@endsection

@section('content')
    {{-- Stats --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">Total Pesanan</div>
            <div class="stat-value">{{ $orders->count() }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Pending</div>
            <div class="stat-value">{{ $orders->where('status_pemesanan','pending')->count() }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Selesai</div>
            <div class="stat-value">{{ $orders->where('status_pemesanan','selesai')->count() }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Dibatalkan</div>
            <div class="stat-value">{{ $orders->where('status_pemesanan','dibatalkan')->count() }}</div>
        </div>
    </div>

    {{-- Orders Table --}}
    <div class="section-card">
        <div class="section-header">
            <span class="section-title">Tabel Pemesanan</span>
            <a href="{{ route('admin.orders.create') }}" class="btn-primary">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width:14px;height:14px;">
                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Tambah Pesanan
            </a>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Pesanan</th>
                        <th>Pelanggan</th>
                        <th>Tanggal Pesanan</th>
                        <th>Deadline</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td class="td-id">#{{ $order->id }}</td>
                        <td class="td-name">{{ $order->nama_pesanan }}</td>
                        <td>{{ $order->customer->nama }}</td>
                        <td>{{ $order->tanggal_pemesanan }}</td>
                        <td>{{ $order->deadline }}</td>
                        <td>
                            @php
                                $badgeClass = match(strtolower($order->status_pemesanan)) {
                                    'selesai'    => 'badge-done',
                                    'dibatalkan' => 'badge-cancel',
                                    default      => 'badge-pending',
                                };
                            @endphp
                            <span class="badge {{ $badgeClass }}">{{ $order->status_pemesanan }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <p>Data pemesanan masih kosong.</p>
                                <a href="{{ route('admin.orders.create') }}" class="btn-primary">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width:14px;height:14px;">
                                        <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                                    </svg>
                                    Tambah Pesanan Pertama
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection