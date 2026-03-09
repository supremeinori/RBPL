<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pesanan — MR BONGKENG Manage System</title>
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

        .form-card {
            background: var(--dark);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 1000px;
            margin: 0 auto;
            overflow: hidden;
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

        .form-body {
            padding: 32px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 32px;
        }

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            font-size: 11.5px;
            font-weight: 600;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.07em;
            margin-bottom: 10px;
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

        .input-group {
            display: flex;
            gap: 10px;
        }

        .btn-inline {
            white-space: nowrap;
            padding: 0 16px;
            background: var(--mid);
            color: var(--light);
            border: 1px solid var(--border);
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all var(--transition);
        }

        .btn-inline:hover {
            background: var(--border);
            color: var(--white);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 120px;
        }

        .form-footer {
            margin-top: 16px;
            padding-top: 24px;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: flex-end;
        }

        .btn-submit {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-width: 160px;
            padding: 14px 24px;
            background: var(--white);
            color: var(--black);
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: background var(--transition), transform var(--transition);
        }

        .btn-submit:hover {
            background: #e8e8e8;
            transform: translateY(-1px);
        }

        /* MODAL STYLES */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.8);
            backdrop-filter: blur(4px);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 100;
            padding: 20px;
        }

        .modal-card {
            background: var(--dark);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            width: 100%;
            max-width: 480px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.5);
            overflow: hidden;
            animation: modalFadeIn 0.3s ease;
        }

        @keyframes modalFadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .modal-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--white);
        }

        .modal-body {
            padding: 24px;
        }

        .modal-footer {
            padding: 16px 24px;
            background: var(--mid);
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: flex-end;
            gap: 12px;
        }

        .btn-modal-cancel {
            background: transparent;
            color: var(--subtle);
            border: none;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-modal-save {
            background: var(--white);
            color: var(--black);
            border: none;
            padding: 8px 20px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
        }

        /* ── Searchable Select ── */
        .custom-select-container {
            position: relative;
            width: 100%;
        }

        .select-search-wrap {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: var(--dark);
            border: 1px solid var(--border);
            border-radius: 12px;
            margin-top: 6px;
            z-index: 50;
            box-shadow: 0 10px 40px rgba(0,0,0,0.6);
            display: none;
            overflow: hidden;
            animation: dropdownFade 0.2s ease;
        }

        @keyframes dropdownFade {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .select-search-input-wrap {
            padding: 12px;
            border-bottom: 1px solid var(--border);
            background: var(--mid);
        }

        .select-search-input {
            width: 100%;
            background: var(--dark);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 8px 12px;
            color: var(--white);
            font-size: 13px;
            font-family: 'Inter', sans-serif;
        }

        .select-search-input:focus {
            outline: none;
            border-color: var(--subtle);
        }

        .select-options-list {
            max-height: 220px;
            overflow-y: auto;
        }

        /* Custom scrollbar */
        .select-options-list::-webkit-scrollbar {
            width: 6px;
        }
        .select-options-list::-webkit-scrollbar-track {
            background: transparent;
        }
        .select-options-list::-webkit-scrollbar-thumb {
            background: var(--border);
            border-radius: 10px;
        }

        .select-option {
            padding: 10px 16px;
            font-size: 13.5px;
            color: var(--light);
            cursor: pointer;
            transition: background var(--transition);
        }

        .select-option:hover {
            background: rgba(255,255,255,0.05);
            color: var(--white);
        }

        .select-option.selected {
            background: var(--mid);
            color: var(--white);
            font-weight: 600;
        }

        .select-loading {
            padding: 14px;
            text-align: center;
            font-size: 12px;
            color: var(--muted);
            display: none;
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

            <a href="/admin/customers" class="nav-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                    <circle cx="12" cy="7" r="4"/>
                </svg>
                Kelola Customer
            </a>

            <span class="nav-label">Pesanan</span>

            <a href="{{ route('admin.orders.create') }}" class="nav-item active">
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
                <div class="topbar-title">Tambah Pesanan</div>
                <div class="topbar-sub">Create a new service order for a customer.</div>
            </div>
            <span class="topbar-badge">Admin</span>
        </div>

        <div class="content">
            <div class="form-card">
                <div class="form-header">
                    <span class="form-title">Informasi Pesanan</span>
                </div>

                <div class="form-body">
                    <form action="{{ route('admin.orders.store') }}" method="POST">
                        @csrf

                        <div class="form-grid">
                            <!-- LEFT SIDE -->
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Pelanggan</label>
                                    <div class="input-group">
                                        <div class="custom-select-container">
                                            <input type="hidden" name="id_pelanggan" id="hiddenCustomerInput" required>
                                            <div id="selectTrigger" class="form-control" style="cursor: pointer; display: flex; justify-content: space-between; align-items: center;">
                                                <span id="selectedCustomerText">Pilih Pelanggan</span>
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 14px; height: 14px; opacity: 0.5;">
                                                    <polyline points="6 9 12 15 18 9"></polyline>
                                                </svg>
                                            </div>
                                            
                                            <div id="selectDropdown" class="select-search-wrap">
                                                <div class="select-search-input-wrap">
                                                    <input type="text" id="customerSearchInput" class="select-search-input" placeholder="Cari nama pelanggan..." autocomplete="off">
                                                </div>
                                                <div id="selectLoading" class="select-loading">Mencari...</div>
                                                <div id="optionsList" class="select-options-list">
                                                    @foreach($customers as $customer)
                                                        <div class="select-option" data-id="{{ $customer->id_pelanggan }}" data-nama="{{ $customer->nama }}">
                                                            {{ $customer->nama }}
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn-inline" onclick="openModal()">
                                            + Baru
                                        </button>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Nama Pesanan / Layanan</label>
                                    <input type="text" name="nama_pesanan" class="form-control" placeholder="Contoh: Service AC, Cuci Karpet..." required>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Tanggal Pemesanan</label>
                                    <input type="date" name="tanggal_pemesanan" class="form-control" value="{{ date('Y-m-d') }}" required>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Deadline / Estimasi Selesai</label>
                                    <input type="date" name="deadline" class="form-control" required>
                                </div>
                            </div>

                            <!-- RIGHT SIDE -->
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Status Pesanan</label>
                                    <select name="status_pemesanan" class="form-control" required>
                                        <option value="pending">Pending</option>
                                        <option value="diproses">Diproses</option>
                                        <option value="selesai">Selesai</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Deskripsi / Detail Pesanan</label>
                                    <textarea name="deskripsi_pemesanan" class="form-control" placeholder="Masukkan detail teknis atau catatan tambahan..."></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-footer">
                            <button type="submit" class="btn-submit">
                                Simpan Pesanan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- MODAL TAMBAH PELANGGAN -->
<div id="customerModal" class="modal-overlay">
    <div class="modal-card">
        <div class="modal-header">
            <span class="modal-title">Tambah Pelanggan Cepat</span>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label class="form-label">Nama</label>
                <input type="text" id="modal_nama" class="form-control" placeholder="Nama lengkap">
            </div>
            <div class="form-group">
                <label class="form-label">No. Telp</label>
                <input type="text" id="modal_no_telp" class="form-control" placeholder="08xxxx">
            </div>
            <div class="form-group">
                <label class="form-label">Alamat</label>
                <textarea id="modal_alamat" class="form-control" placeholder="Alamat lengkap" rows="3"></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-modal-cancel" onclick="closeModal()">Batal</button>
            <button type="button" class="btn-modal-save" onclick="saveCustomer()">Simpan</button>
        </div>
    </div>
</div>

<script>
    function openModal(){
        document.getElementById("customerModal").style.display = "flex";
    }

    function closeModal(){
        document.getElementById("customerModal").style.display = "none";
    }

    function saveCustomer(){
        const nama = document.getElementById("modal_nama").value;
        const no_telp = document.getElementById("modal_no_telp").value;
        const alamat = document.getElementById("modal_alamat").value;

        if(!nama || !no_telp) {
            alert("Nama dan No. Telp wajib diisi");
            return;
        }

        fetch("{{ route('admin.customers.store') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                nama: nama,
                no_telp: no_telp,
                alamat: alamat
            })
        })
        .then(res => res.json())
        .then(data => {
            if(data.id_pelanggan) {
                // Select the new customer
                selectCustomer(data.id_pelanggan, data.nama);

                // Clear fields
                document.getElementById("modal_nama").value = "";
                document.getElementById("modal_no_telp").value = "";
                document.getElementById("modal_alamat").value = "";

                closeModal();
            } else {
                alert("Gagal menambahkan pelanggan");
            }
        })
        .catch(err => {
            console.error(err);
            alert("Terjadi kesalahan sistem");
        });
    }

    // ── Searchable Dropdown Logic ──
    const selectTrigger = document.getElementById('selectTrigger');
    const selectDropdown = document.getElementById('selectDropdown');
    const customerSearchInput = document.getElementById('customerSearchInput');
    const hiddenCustomerInput = document.getElementById('hiddenCustomerInput');
    const selectedCustomerText = document.getElementById('selectedCustomerText');
    const optionsList = document.getElementById('optionsList');
    const selectLoading = document.getElementById('selectLoading');

    // Toggle dropdown
    selectTrigger.addEventListener('click', () => {
        const isOpen = selectDropdown.style.display === 'block';
        selectDropdown.style.display = isOpen ? 'none' : 'block';
        if (!isOpen) customerSearchInput.focus();
    });

    // Close when clicking outside
    document.addEventListener('click', (e) => {
        if (!selectTrigger.contains(e.target) && !selectDropdown.contains(e.target)) {
            selectDropdown.style.display = 'none';
        }
    });

    // Handle option selection
    optionsList.addEventListener('click', (e) => {
        const option = e.target.closest('.select-option');
        if (option) {
            const id = option.dataset.id;
            const nama = option.dataset.nama;
            selectCustomer(id, nama);
            selectDropdown.style.display = 'none';
        }
    });

    function selectCustomer(id, nama) {
        hiddenCustomerInput.value = id;
        selectedCustomerText.innerText = nama;
        
        // Mark as selected in UI
        document.querySelectorAll('.select-option').forEach(opt => {
            opt.classList.toggle('selected', opt.dataset.id == id);
        });
    }

    // AJAX Search
    let searchTimeout;
    customerSearchInput.addEventListener('input', (e) => {
        clearTimeout(searchTimeout);
        const q = e.target.value;

        searchTimeout = setTimeout(() => {
            if (q.length < 1) {
                // If cleared, we don't necessarily show only 5 again, 
                // but let's just keep the last results or reset for simplicity
                return;
            }

            selectLoading.style.display = 'block';
            optionsList.style.opacity = '0.5';

            fetch("{{ route('admin.customers.search') }}?q=" + encodeURIComponent(q))
                .then(res => res.json())
                .then(data => {
                    optionsList.innerHTML = '';
                    if (data.length > 0) {
                        data.forEach(customer => {
                            const opt = document.createElement('div');
                            opt.className = 'select-option';
                            opt.dataset.id = customer.id_pelanggan;
                            opt.dataset.nama = customer.nama;
                            opt.innerText = customer.nama;
                            if (hiddenCustomerInput.value == customer.id_pelanggan) opt.classList.add('selected');
                            optionsList.appendChild(opt);
                        });
                    } else {
                        optionsList.innerHTML = '<div style="padding: 14px; text-align: center; font-size: 13px; color: var(--muted);">Tidak ada hasil</div>';
                    }
                })
                .finally(() => {
                    selectLoading.style.display = 'none';
                    optionsList.style.opacity = '1';
                });
        }, 300);
    });
</script>

</body>
</html>