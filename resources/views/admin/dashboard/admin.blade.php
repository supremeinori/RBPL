<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin — MR BONGKENG Manage System</title>
    <meta name="description" content="Admin Dashboard - MR BONGKENG Manage System">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --black:       #0a0a0a;
            --dark:        #111111;
            --mid:         #1c1c1c;
            --border:      #2a2a2a;
            --muted:       #555555;
            --subtle:      #888888;
            --light:       #d4d4d4;
            --white:       #ffffff;
            --accent:      #ffffff;
            --radius:      14px;
            --transition:  0.25s ease;
            --sidebar-w:   240px;
        }

        html, body {
            height: 100%;
            font-family: 'Inter', sans-serif;
            background-color: var(--black);
            color: var(--light);
        }

        /* ── Decorative background grid ── */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 48px 48px;
            pointer-events: none;
            z-index: 0;
        }

        /* ── Layout ── */
        .layout {
            display: flex;
            min-height: 100vh;
            position: relative;
            z-index: 1;
        }

        /* ── Sidebar ── */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--dark);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 10;
        }

        .sidebar-brand {
            padding: 28px 20px 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-brand-icon {
            width: 38px;
            height: 38px;
            background: var(--white);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(255,255,255,0.12);
        }

        .sidebar-brand-icon svg {
            width: 18px;
            height: 18px;
            color: var(--black);
        }

        .sidebar-brand-text h2 {
            font-size: 13.5px;
            font-weight: 700;
            color: var(--white);
            letter-spacing: -0.2px;
            line-height: 1.2;
        }

        .sidebar-brand-text span {
            font-size: 11px;
            color: var(--muted);
            font-weight: 400;
        }

        .sidebar-nav {
            flex: 1;
            padding: 16px 12px;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .nav-label {
            font-size: 10.5px;
            font-weight: 600;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            padding: 8px 8px 4px;
            margin-top: 8px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 10px;
            border-radius: 10px;
            text-decoration: none;
            color: var(--subtle);
            font-size: 13.5px;
            font-weight: 500;
            transition: background var(--transition), color var(--transition);
        }

        .nav-item svg {
            width: 16px;
            height: 16px;
            flex-shrink: 0;
        }

        .nav-item:hover {
            background: var(--mid);
            color: var(--light);
        }

        .nav-item.active {
            background: var(--mid);
            color: var(--white);
            border: 1px solid var(--border);
        }

        .sidebar-footer {
            padding: 16px 12px;
            border-top: 1px solid var(--border);
        }

        /* Logout button inside sidebar */
        .btn-logout {
            width: 100%;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 10px;
            border-radius: 10px;
            background: transparent;
            border: 1px solid var(--border);
            color: var(--subtle);
            font-size: 13.5px;
            font-weight: 500;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: background var(--transition), color var(--transition), border-color var(--transition);
        }

        .btn-logout svg {
            width: 16px;
            height: 16px;
        }

        .btn-logout:hover {
            background: rgba(239,68,68,0.08);
            border-color: rgba(239,68,68,0.25);
            color: #fca5a5;
        }

        /* ── Main ── */
        .main {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        /* ── Topbar ── */
        .topbar {
            background: var(--dark);
            border-bottom: 1px solid var(--border);
            padding: 16px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 5;
        }

        .topbar-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--white);
            letter-spacing: -0.2px;
        }

        .topbar-sub {
            font-size: 12.5px;
            color: var(--muted);
            margin-top: 2px;
        }

        .topbar-badge {
            font-size: 12px;
            color: var(--subtle);
            background: var(--mid);
            border: 1px solid var(--border);
            padding: 5px 12px;
            border-radius: 20px;
            font-weight: 500;
        }

        /* ── Page Content ── */
        .content {
            padding: 32px;
            flex: 1;
        }

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
            padding: 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
            animation: fadeUp 0.5s cubic-bezier(0.22,1,0.36,1) both;
        }

        .stat-card:nth-child(2) { animation-delay: 0.05s; }
        .stat-card:nth-child(3) { animation-delay: 0.10s; }
        .stat-card:nth-child(4) { animation-delay: 0.15s; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0);    }
        }

        .stat-label {
            font-size: 11.5px;
            font-weight: 600;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.07em;
            margin-bottom: 8px;
        }

        .stat-value {
            font-size: 26px;
            font-weight: 700;
            color: var(--white);
            letter-spacing: -0.5px;
            line-height: 1;
        }

        /* ── Section Card ── */
        .section-card {
            background: var(--dark);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
            animation: fadeUp 0.5s 0.1s cubic-bezier(0.22,1,0.36,1) both;
            overflow: hidden;
        }

        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 24px;
            border-bottom: 1px solid var(--border);
        }

        .section-title {
            font-size: 14.5px;
            font-weight: 700;
            color: var(--white);
        }

        .btn-add {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            background: var(--white);
            color: var(--black);
            border: none;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            text-decoration: none;
            transition: background var(--transition), transform var(--transition), box-shadow var(--transition);
            box-shadow: 0 2px 10px rgba(255,255,255,0.12);
        }

        .btn-add svg {
            width: 14px;
            height: 14px;
        }

        .btn-add:hover {
            background: #e8e8e8;
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(255,255,255,0.18);
        }

        /* ── Table ── */
        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead th {
            padding: 12px 16px;
            text-align: left;
            font-size: 11.5px;
            font-weight: 600;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.07em;
            border-bottom: 1px solid var(--border);
            background: var(--mid);
        }

        tbody tr {
            border-bottom: 1px solid var(--border);
            transition: background var(--transition);
        }

        tbody tr:last-child {
            border-bottom: none;
        }

        tbody tr:hover {
            background: rgba(255,255,255,0.03);
        }

        tbody td {
            padding: 14px 16px;
            font-size: 13.5px;
            color: var(--light);
            vertical-align: middle;
        }

        .td-id {
            color: var(--muted);
            font-variant-numeric: tabular-nums;
            font-size: 12.5px;
        }

        .td-name {
            font-weight: 500;
            color: var(--white);
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

        /* Empty state */
        .empty-state {
            padding: 48px 24px;
            text-align: center;
        }

        .search-form {
            display: flex;
            align-items: center;
            background: var(--mid);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 4px 12px;
            transition: border-color var(--transition);
        }

        .search-form:focus-within {
            border-color: var(--subtle);
        }

        .search-form input {
            background: transparent;
            border: none;
            color: var(--white);
            font-size: 13px;
            padding: 6px 0;
            width: 180px;
            font-family: 'Inter', sans-serif;
        }

        .search-form input:focus {
            outline: none;
        }

        .search-form svg {
            width: 14px;
            height: 14px;
            color: var(--muted);
            margin-right: 8px;
        }

        .sort-link {
            text-decoration: none;
            color: inherit;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .sort-link:hover {
            color: var(--white);
        }

        .pagination-wrap {
            padding: 16px 24px;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: center;
        }

        /* Essential Pagination Styles */
        nav[role="navigation"] {
            display: flex;
            justify-content: center;
            width: 100%;
        }

        nav[role="navigation"] .flex.justify-between {
            display: none; /* Hide small screens pagination for now or style it */
        }

        nav[role="navigation"] .hidden.sm\:flex-1 {
            display: flex !important;
            align-items: center;
            justify-content: space-between;
            width: 100%;
        }

        .pagination-info {
            font-size: 13px;
            color: var(--muted);
        }

        .pagination-links {
            display: flex;
            gap: 6px;
        }

        .pagination-links a, .pagination-links span {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 34px;
            height: 34px;
            padding: 0 8px;
            background: var(--mid);
            border: 1px solid var(--border);
            border-radius: 8px;
            color: var(--subtle);
            text-decoration: none;
            font-size: 13px;
            transition: all var(--transition);
        }

        .pagination-links span[aria-current="page"] {
            background: var(--white);
            color: var(--black);
            border-color: var(--white);
            font-weight: 600;
        }

        .pagination-links a:hover {
            border-color: var(--subtle);
            color: var(--white);
        }
    </style>
</head>
<body>

<div class="layout">

    {{-- ── Sidebar ── --}}
    <aside class="sidebar">
        <div class="sidebar-brand">
            <div class="sidebar-brand-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
            </div>
            <div class="sidebar-brand-text">
                <h2>MR BONGKENG</h2>
                <span>Manage System</span>
            </div>
        </div>

        <nav class="sidebar-nav">
            <span class="nav-label">Menu</span>

            <a href="#" class="nav-item active">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
                    <rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
                </svg>
                Dashboard
            </a>

            <a href="/admin/users" class="nav-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
                Kelola User
            </a>

            <a href="/admin/customers" class="nav-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                    <circle cx="12" cy="7" r="4"/>
                </svg>
                Kelola Customer
            </a>

            <span class="nav-label">Pesanan</span>

            <a href="{{ route('admin.orders.create') }}" class="nav-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Tambah Pesanan
            </a>
        </nav>

        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                        <polyline points="16 17 21 12 16 7"/>
                        <line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- ── Main ── --}}
    <div class="main">

        {{-- Topbar --}}
        <div class="topbar">
            <div>
                <div class="topbar-title">Dashboard Admin</div>
                <div class="topbar-sub">Welcome back! Here's what's happening today.</div>
            </div>
            <span class="topbar-badge">Admin</span>
        </div>

        {{-- Content --}}
        <div class="content">

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
                    <div style="display: flex; gap: 12px; align-items: center;">
                        <form action="{{ url()->current() }}" method="GET" class="search-form">
                            <input type="hidden" name="sort" value="{{ request('sort') }}">
                            <input type="hidden" name="direction" value="{{ request('direction') }}">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                            </svg>
                            <input type="text" name="search" placeholder="Cari pesanan..." value="{{ request('search') }}">
                        </form>
                        <a href="{{ route('admin.orders.create') }}" class="btn-add">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                            </svg>
                            Tambah Pesanan
                        </a>
                    </div>
                </div>

                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'id', 'direction' => request('sort') == 'id' && request('direction') == 'asc' ? 'desc' : 'asc']) }}" class="sort-link">
                                        ID {!! request('sort') == 'id' ? (request('direction') == 'asc' ? '↑' : '↓') : '' !!}
                                    </a>
                                </th>
                                <th>
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'name', 'direction' => request('sort') == 'name' && request('direction') == 'asc' ? 'desc' : 'asc']) }}" class="sort-link">
                                        Nama Pesanan {!! request('sort') == 'name' ? (request('direction') == 'asc' ? '↑' : '↓') : '' !!}
                                    </a>
                                </th>
                                <th>Pelanggan</th>
                                <th>
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'date', 'direction' => request('sort') == 'date' && request('direction') == 'asc' ? 'desc' : 'asc']) }}" class="sort-link">
                                        Tanggal Pesanan {!! request('sort') == 'date' ? (request('direction') == 'asc' ? '↑' : '↓') : '' !!}
                                    </a>
                                </th>
                                <th>
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'deadline', 'direction' => request('sort') == 'deadline' && request('direction') == 'asc' ? 'desc' : 'asc']) }}" class="sort-link">
                                        Deadline {!! request('sort') == 'deadline' ? (request('direction') == 'asc' ? '↑' : '↓') : '' !!}
                                    </a>
                                </th>
                                <th>
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'status', 'direction' => request('sort') == 'status' && request('direction') == 'asc' ? 'desc' : 'asc']) }}" class="sort-link">
                                        Status {!! request('sort') == 'status' ? (request('direction') == 'asc' ? '↑' : '↓') : '' !!}
                                    </a>
                                </th>
                                <th>Aksi</th>
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
                                <td>aksi</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7">
                                    <div class="empty-state">
                                        <p>Data pemesanan masih kosong.</p>
                                        <a href="{{ route('admin.orders.create') }}" class="btn-add">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
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

                @if($orders->count() > 0 && method_exists($orders, 'links'))
                <div class="pagination-wrap">
                    {{ $orders->links() }}
                </div>
                @endif
            </div>

        </div>{{-- /content --}}
    </div>{{-- /main --}}

</div>{{-- /layout --}}

</body>
</html>