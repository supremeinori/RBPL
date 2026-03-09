<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pelanggan — MR BONGKENG Manage System</title>
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

        .layout {
            display: flex;
            min-height: 100vh;
            position: relative;
            z-index: 1;
        }

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

        .main {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
        }

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

        .content {
            padding: 32px;
            flex: 1;
        }

        .section-card {
            background: var(--dark);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
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

        .btn-action {
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .btn-edit {
            background: rgba(255,255,255,0.05);
            color: var(--light);
            border: 1px solid var(--border);
        }

        .btn-edit:hover {
            background: var(--mid);
            color: var(--white);
        }

        .empty-state {
            padding: 48px 24px;
            text-align: center;
        }

        .empty-state p {
            color: var(--muted);
            font-size: 14px;
            margin-bottom: 16px;
        }
    </style>
</head>
<body>

<div class="layout">

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

            <a href="/admin/dashboard" class="nav-item">
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

            <a href="/admin/customers" class="nav-item active">
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

    <div class="main">
        <div class="topbar">
            <div>
                <div class="topbar-title">Kelola Pelanggan</div>
                <div class="topbar-sub">Manage customer database and contact information.</div>
            </div>
            <span class="topbar-badge">Admin</span>
        </div>

        <div class="content">
            <div class="section-card">
                <div class="section-header">
                    <span class="section-title">Daftar Pelanggan</span>
                    <a href="{{ route('admin.customers.create') }}" class="btn-add">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                        </svg>
                        Tambah Pelanggan
                    </a>
                </div>

                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>No Telp</th>
                                <th style="text-align: right;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($customers as $customer)
                            <tr>
                                <td class="td-id">#{{ $customer->id_pelanggan }}</td>
                                <td class="td-name">{{ $customer->nama }}</td>
                                <td>{{ $customer->alamat }}</td>
                                <td>{{ $customer->no_telp }}</td>
                                <td style="text-align: right;">
                                    <a href="{{ route('admin.customers.edit', $customer->id_pelanggan) }}" class="btn-action btn-edit">
                                        Edit
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5">
                                    <div class="empty-state">
                                        <p>Data pelanggan masih kosong.</p>
                                        <a href="{{ route('admin.customers.create') }}" class="btn-add">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                                            </svg>
                                            Tambah Pelanggan Pertama
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

</body>
</html>