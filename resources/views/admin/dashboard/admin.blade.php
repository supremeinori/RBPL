@extends('layouts.app')
@section('title', 'Dashboard Admin')
@section('subtitle', "Welcome back! Here's what's happening today.")

@section('styles')
<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 32px;
    }
    .stat-card {
        background: var(--dark);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 24px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
    }
    .stat-title {
        font-size: 13px;
        color: var(--muted);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-weight: 600;
        margin-bottom: 8px;
    }
    .stat-value {
        font-size: 28px;
        font-weight: 700;
        color: var(--white);
    }
    .stat-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 11.5px;
        font-weight: 600;
        background: var(--mid);
    }
    .badge-primary { background: rgba(37, 99, 235, 0.1); color: var(--accent); }
    .badge-warning { background: rgba(245, 158, 11, 0.1); color: var(--warning); }
    .badge-success { background: rgba(16, 185, 129, 0.1); color: var(--success); }
    .badge-danger { background: rgba(239, 68, 68, 0.1); color: var(--danger); }
</style>
@endsection

@section('content')
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-title">Total Pesanan</div>
        <div class="stat-value">{{ $orders->count() }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-title">Pending</div>
        <div class="stat-value" style="color: var(--warning);">{{ $orders->where('status_pemesanan','pending')->count() }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-title">Selesai</div>
        <div class="stat-value" style="color: var(--success);">{{ $orders->where('status_pemesanan','selesai')->count() }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-title">Dibatalkan</div>
        <div class="stat-value" style="color: var(--danger);">{{ $orders->where('status_pemesanan','dibatalkan')->count() }}</div>
    </div>
</div>

<div class="section-card">
    <div class="section-header">
        <h2 class="section-title">Tabel Pemesanan Terbaru</h2>
        <a href="{{ route('admin.orders.create') }}" class="btn-primary">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            Tambah Pesanan Baru
        </a>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Projek</th>
                    <th>Pelanggan</th>
                    <th>Tgl Pesan</th>
                    <th>Tgl Deadline</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td><strong>#{{$order->id_pemesanan }}</strong></td>
                    <td>{{ $order->nama_pesanan }}</td>
                    <td>{{ $order->customer->nama ?? '-' }}</td>
                    <td>{{ date('d M Y', strtotime($order->tanggal_pemesanan)) }}</td>
                    <td><span class="stat-badge" style="background:var(--mid);">{{ date('d M Y', strtotime($order->deadline)) }}</span></td>
                    <td>
                        @if($order->status_pemesanan === 'pending')
                            <span class="stat-badge badge-warning">Pending</span>
                        @elseif($order->status_pemesanan === 'diproses')
                            <span class="stat-badge badge-primary">Diproses</span>
                        @elseif($order->status_pemesanan === 'selesai')
                            <span class="stat-badge badge-success">Selesai</span>
                        @else
                            <span class="stat-badge badge-danger">{{ ucfirst($order->status_pemesanan) }}</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order) }}" class="btn-primary" style="padding: 4px 10px; font-size:12px; background:var(--mid); color:var(--light); box-shadow:none;">Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center; padding: 40px; color:var(--muted);">Tidak ada data pemesanan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($orders->count() > 0 && method_exists($orders, 'links'))
    <div style="padding: 16px 24px; border-top: 1px solid var(--border);">
        {{ $orders->links() }}
    </div>
    @endif
</div>
@endsection