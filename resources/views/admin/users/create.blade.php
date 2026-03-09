<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah User — MR BONGKENG Manage System</title>
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
            display: flex;
            justify-content: center;
        }

        .form-card {
            background: var(--dark);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 600px;
            overflow: hidden;
            align-self: flex-start;
        }

        .form-header {
            padding: 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .form-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--white);
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: var(--subtle);
            text-decoration: none;
            transition: color var(--transition);
        }

        .btn-back:hover {
            color: var(--white);
        }

        .btn-back svg {
            width: 14px;
            height: 14px;
        }

        .form-body {
            padding: 24px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 11.5px;
            font-weight: 600;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.07em;
            margin-bottom: 8px;
        }

        .form-control {
            width: 100%;
            background: var(--mid);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 12px 16px;
            color: var(--white);
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            transition: border-color var(--transition), box-shadow var(--transition);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--subtle);
            box-shadow: 0 0 0 2px rgba(255,255,255,0.05);
        }

        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23888888'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 16px center;
            background-size: 16px;
        }

        .btn-submit {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 12px;
            background: var(--white);
            color: var(--black);
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: background var(--transition), transform var(--transition);
            margin-top: 12px;
        }

        .btn-submit:hover {
            background: #e8e8e8;
            transform: translateY(-1px);
        }

        .alert-error {
            background: rgba(239,68,68,0.1);
            border: 1px solid rgba(239,68,68,0.2);
            color: #fca5a5;
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 13px;
        }

        .alert-error ul {
            list-style: none;
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

            <a href="/admin/users" class="nav-item active">
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

    <div class="main">
        <div class="topbar">
            <div>
                <div class="topbar-title">Tambah User</div>
                <div class="topbar-sub">Create a new system user with specific role.</div>
            </div>
            <span class="topbar-badge">Admin</span>
        </div>

        <div class="content">
            <div class="form-card">
                <div class="form-header">
                    <span class="form-title">Informasi Pengguna Baru</span>
                    <a href="{{ route('admin.users.index') }}" class="btn-back">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
                        </svg>
                        Kembali
                    </a>
                </div>

                <div class="form-body">
                    @if ($errors->any())
                        <div class="alert-error">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>• {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.users.store') }}">
                        @csrf

                        <div class="form-group">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" placeholder="Masukkan nama..." required autofocus>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Alamat Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Masukkan email..." required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Role Akses</label>
                            <select name="role" class="form-control">
                                <option value="admin">Admin</option>
                                <option value="desainer">Desainer</option>
                                <option value="akuntan">Akuntan</option>
                            </select>
                        </div>

                        <button type="submit" class="btn-submit">
                            Simpan User
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

</body>
</html>