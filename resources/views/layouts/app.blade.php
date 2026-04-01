<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — MR BONGKENG</title>
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
            --black:       #f8f9fc; /* Main background */
            --dark:        #ffffff; /* Cards / Sidebar */
            --mid:         #f1f5f9; /* Hover / Table headers */
            --border:      #e2e8f0;
            --muted:       #64748b;
            --subtle:      #475569;
            --light:       #334155; /* Normal text */
            --white:       #0f172a; /* Headlines */
            --accent:      #2563eb; /* Blue accent */
            --radius:      12px;
            --transition:  0.25s ease;
            --sidebar-w:   250px;
            
            --success:     #10b981;
            --danger:      #ef4444;
            --warning:     #f59e0b;
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
                linear-gradient(rgba(0,0,0,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0,0,0,0.03) 1px, transparent 1px);
            background-size: 32px 32px;
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
            box-shadow: 0 4px 12px rgba(0,0,0,0.08); /* Light box shadow */
        }
        .sidebar-brand-icon svg { color: var(--dark); } /* Because white is dark blue now, and dark is white */

        .section-card {
            background: var(--dark);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
            overflow: hidden;
            margin-bottom: 24px;
            animation: fadeUp 0.5s cubic-bezier(0.22,1,0.36,1) both;
        }
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 24px;
            border-bottom: 1px solid var(--border);
        }
        .section-title {
            font-size: 16px;
            font-weight: 600;
            color: var(--white);
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            background: var(--white); /* White is primary text color, so button is dark */
            color: var(--dark); /* Text inside button is white */
            border: none;
            border-radius: 8px;
            font-size: 13.5px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            text-decoration: none;
            box-shadow: 0 4px 10px rgba(15,23,42,0.1);
            transition: background var(--transition), transform var(--transition), box-shadow var(--transition);
        }
        .btn-primary:hover { 
            background: var(--light); 
            transform: translateY(-1px); 
            box-shadow: 0 6px 15px rgba(15,23,42,0.15);
        }

        /* ── Sidebar Nav ── */
        .sidebar-nav { flex: 1; overflow-y: auto; padding-top: 8px; }
        .sidebar-footer { padding: 12px 0; border-top: 1px solid var(--border); }
        .nav-label { padding: 0 20px; color: var(--muted); font-size: 11px; text-transform: uppercase; letter-spacing: 0.1em; font-weight: 700; margin-bottom: 8px; margin-top: 24px; display: block; }
        .nav-item { display: flex; align-items: center; gap: 12px; padding: 12px 20px; color: var(--subtle); text-decoration: none; font-size: 14px; font-weight: 500; font-family: 'Inter', sans-serif; transition: var(--transition); border-left: 3px solid transparent; }
        .nav-item:hover { color: var(--accent); background: rgba(37,99,235,0.05); }
        .nav-item.active { color: var(--accent); background: rgba(37,99,235,0.05); border-left-color: var(--accent); font-weight: 600; }
        .nav-item svg { width: 18px; height: 18px; stroke-width: 2; opacity: 0.8; }
        .nav-item.active svg { opacity: 1; }

        .btn-logout { background: none; border: none; font-family: inherit; font-size: 14px; font-weight: 600; color: var(--danger); cursor: pointer; display: flex; align-items: center; gap: 10px; padding: 12px 20px; width: 100%; transition: var(--transition); text-align: left; }
        .btn-logout:hover { background: rgba(239, 68, 68, 0.05); }
        .btn-logout svg { width: 18px; height: 18px; }

        /* ── Main Layout Elements ── */
        .main { flex: 1; margin-left: var(--sidebar-w); display: flex; flex-direction: column; }
        .content { padding: 32px 40px; flex: 1; max-width: 1200px; width: 100%; margin: 0 auto; }

        /* ── Topbar ── */
        .topbar { padding: 24px 40px; border-bottom: 1px solid var(--border); background: var(--dark); display: flex; justify-content: space-between; align-items: flex-end; position: sticky; top: 0; z-index: 5; }
        .topbar-title { font-size: 22px; font-weight: 700; color: var(--white); margin-bottom: 4px; }
        .topbar-sub { font-size: 13.5px; color: var(--muted); }
        .topbar-badge { background: var(--mid); padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 600; color: var(--light); border: 1px solid var(--border); box-shadow: 0 2px 5px rgba(0,0,0,0.02); }

        table { width: 100%; border-collapse: collapse; }
        thead th {
            padding: 14px 18px;
            text-align: left;
            font-size: 11.5px;
            font-weight: 600;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 1px solid var(--border);
            background: var(--mid);
        }
        tbody td { padding: 16px 18px; border-bottom: 1px solid var(--border); font-size: 14px; }
        tbody tr:last-child td { border-bottom: none; }
        tbody tr:hover { background: rgba(0,0,0,0.02); }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @yield('styles')
    </style>
</head>
<body>

<div class="layout">
    <aside class="sidebar">
        <div class="sidebar-brand">
            <div class="sidebar-brand-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            </div>
            <div class="sidebar-brand-text">
                <h2>MR BONGKENG</h2>
                <span>Manage System</span>
            </div>
        </div>

        <nav class="sidebar-nav">
            @php $routeName = Request::route() ? Request::route()->getName() : ''; @endphp
            
            <span class="nav-label">Main Menu</span>
            <a href="/admin/dashboard" class="nav-item {{ Request::is('admin/dashboard') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                Dashboard
            </a>

            @if(Auth::user()->role === 'admin')
                <a href="/admin/users" class="nav-item {{ Request::is('admin/users*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    Kelola User
                </a>
                <a href="/admin/customers" class="nav-item {{ Request::is('admin/customers*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    Kelola Customer
                </a>
                <span class="nav-label">Logistics</span>
                <a href="{{ route('admin.orders.create') }}" class="nav-item {{ Request::is('admin/orders/create') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Tambah Pesanan
                </a>
            @endif

            @if(Auth::user()->role === 'akuntan')
                <span class="nav-label">Finance</span>
                <a href="{{ route('akuntan.dashboard') }}" class="nav-item {{ Request::is('akuntan/dashboard*') || Request::is('akuntan/pembayaran*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                    Validasi Pembayaran
                </a>
            @endif
        </nav>

        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <div class="main">
        <header class="topbar">
            <div class="topbar-title-group">
                <h1 class="topbar-title">@yield('title')</h1>
                <p class="topbar-sub">@yield('subtitle', 'Manage System')</p>
            </div>
            <div class="topbar-badge">{{ ucfirst(Auth::user()->role) }}</div>
        </header>

        <main class="content">
            @yield('content')
        </main>
    </div>
</div>

@yield('scripts')

</body>
</html>
