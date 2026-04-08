@extends('layouts.app')
@section('title', 'Tambah Pesanan')
@section('subtitle', 'Daftarkan projek / pesanan pelanggan baru')

@section('styles')
<style>
    /* Custom Dropdown Specific Styles */
    .custom-select-wrapper { position: relative; flex: 1; user-select: none; }
    .custom-select-trigger { display: flex; justify-content: space-between; align-items: center; cursor: pointer; background: var(--black); }
    .custom-select-menu { position: absolute; top: 110%; left: 0; width: 100%; background: var(--dark); border: 1px solid var(--border); border-radius: 6px; z-index: 100; box-shadow: 0 4px 15px rgba(0,0,0,0.1); padding-bottom: 8px; }
    .custom-option { padding: 10px 14px; font-size: 14px; cursor: pointer; color: var(--light); transition: var(--transition); }
    .custom-option:hover { background: rgba(37, 99, 235, 0.05); color: var(--accent); }
    .search-input-box { background: var(--black); border: 1px solid var(--border); color: var(--light); padding: 8px 12px; border-radius: 6px; width: 100%; font-size: 13px; outline: none; }
    .search-input-box:focus { border-color: var(--accent); }

    /* Modal Khusus Halaman Create */
    .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); display: none; justify-content: center; align-items: center; z-index: 1000; }
    .modal-content { background: var(--dark); border: 1px solid var(--border); border-radius: 12px; padding: 24px; width: 100%; max-width: 500px; max-height: 90vh; overflow-y: auto; }
</style>
@endsection

@section('content')
<!-- Form Utama Card -->
<div class="card" style="max-width: 600px;">
    <h2 style="font-size: 18px; font-weight: 600; margin-bottom: 24px;">Formulir Pesanan Baru</h2>

    @if ($errors->any())
        <div style="background: rgba(239, 68, 68, 0.1); color: var(--danger); padding: 12px 24px; border-bottom: 1px solid var(--border);">
            <ul style="margin-left: 16px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div style="padding: 24px;">
        <form action="{{ route('admin.orders.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label class="form-label">Pelanggan Pengorder</label>
                <div style="display: flex; gap: 8px;">
                    <input type="hidden" name="id_pelanggan" id="input_id_pelanggan" required>
                    <!-- 1. Dropdown Pelanggan Custom -->
                    <div class="custom-select-wrapper" id="customSelectWrapper">
                        <div class="custom-select-trigger form-control" onclick="toggleDropdown()">
                            <span id="customSelectDisplay" style="color: var(--muted);">-- Pilih Data Pelanggan --</span>
                            <span style="font-size: 12px; opacity: 0.5;">▼</span>
                        </div>
                        
                        <div class="custom-select-menu" id="customSelectMenu" style="display: none;">
                            <div id="recentList">
                                @foreach($customers as $customer)
                                    <div class="custom-option" onclick="selectOption({{ $customer->id_pelanggan }}, '{{ htmlspecialchars($customer->nama, ENT_QUOTES) }}')">
                                        {{ $customer->nama }}
                                    </div>
                                @endforeach
                            </div>
                            
                            <hr style="border: none; border-top: 1px solid var(--border); margin: 6px 0;">
                            
                            <div style="padding: 0 10px;">
                                <input type="text" id="liveSearchInput" class="search-input-box" placeholder="🔍 Cari nama pelanggan lain..." autocomplete="off">
                                <div id="liveSearchResults" style="margin-top: 4px; max-height: 150px; overflow-y: auto;"></div>
                            </div>
                        </div>
                    </div>

                    <button type="button" onclick="openAddModal()" class="btn-primary" style="margin-top: 0; padding: 0 16px; font-size: 18px; box-shadow: none;" title="Tambah Pelanggan Baru">+</button>
                </div>
            </div>

            <!-- 2. Input Nama Layanan -->
            <div class="form-group">
                <label class="form-label">Nama Pesanan / Layanan</label>
                <input type="text" name="nama_pesanan" value="{{ old('nama_pesanan') }}" required class="form-control" placeholder="Contoh: Pembuatan Baliho Festival">
            </div>

            <!-- 3. Input Tanggal -->
            <div style="display:grid; grid-template-columns: 1fr; gap: 16px;">
                <div class="form-group">
                    <label class="form-label">Tanggal Pemesanan</label>
                    <input type="date" name="tanggal_pemesanan" value="{{ old('tanggal_pemesanan', date('Y-m-d')) }}" required class="form-control">
                </div>
            </div>

            <!-- 4. Input Status -->
            <div class="form-group">
                <label class="form-label">Status Awalan Pesanan</label>
                <select name="status_pemesanan" required class="form-control">
                    <option value="pending" {{ old('status_pemesanan') == 'pending' ? 'selected' : '' }}>Pending</option>
                </select>
                <p style="font-size:12px; color:var(--muted); margin-top:6px;">Order baru akan berada di status pending hingga DP dibayar.</p>
            </div>

            <!-- 5. Input Deskripsi -->
            <div class="form-group">
                <label class="form-label">Deskripsi / Detail Pesanan</label>
                <textarea name="deskripsi_pemesanan" rows="5" class="form-control" placeholder="Tuliskan catatan teknis secara lengkap disini...">{{ old('deskripsi_pemesanan') }}</textarea>
            </div>

            <!-- 6. Tombol Submit Utama -->
            <div style="display: flex; gap: 12px; margin-top: 32px;">
                <button type="submit" class="btn-primary">Publikasi Order</button>
                <a href="/admin/dashboard" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<!-- Customer Quick Add Modal -->
<div id="customerModal" class="modal-overlay">
    <div class="modal-content">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="font-size: 18px; margin: 0;">Pendaftaran Pelanggan Baru</h3>
            <button type="button" onclick="closeAddModal()" style="background: none; border: none; color: var(--muted); cursor: pointer; font-size: 20px;">&times;</button>
        </div>

        <p style="font-size: 12px; color: var(--muted); margin-bottom: 16px;">Silakan lengkapi data profil pelanggan baru di bawah ini.</p>
        
        <form id="quick-add-customer-form" onsubmit="event.preventDefault(); submitNewCustomer();">
            <div class="form-group">
                <label class="form-label" style="font-size: 12px;">Nama Lengkap</label>
                <input type="text" id="qc_nama" required class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label" style="font-size: 12px;">Nomor HP / WhatsApp</label>
                <input type="text" id="qc_hp" required class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label" style="font-size: 12px;">Alamat Lengkap</label>
                <textarea id="qc_alamat" rows="2" required class="form-control"></textarea>
            </div>
            <div style="display: flex; gap: 8px;">
                <button type="submit" class="btn-primary" style="flex: 1; padding: 10px;">Simpan & Pilih Pelanggan</button>
                <button type="button" onclick="closeAddModal()" class="btn-secondary" style="padding: 10px;">Batal</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')

<script>
    // Custom Dropdown Logic
    const selectMenu = document.getElementById('customSelectMenu');
    const searchInput = document.getElementById('liveSearchInput');
    const searchResults = document.getElementById('liveSearchResults');
    const hiddenInput = document.getElementById('input_id_pelanggan');
    const displaySpan = document.getElementById('customSelectDisplay');

    function toggleDropdown() {
        if(selectMenu.style.display === 'none') {
            selectMenu.style.display = 'block';
            searchInput.focus();
        } else {
            selectMenu.style.display = 'none';
        }
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const wrapper = document.getElementById('customSelectWrapper');
        if (!wrapper.contains(event.target)) {
            selectMenu.style.display = 'none';
        }
    });

    function selectOption(id, name) {
        hiddenInput.value = id;
        displaySpan.textContent = name;
        displaySpan.style.color = 'var(--light)'; // remove muted color
        selectMenu.style.display = 'none';
        
        // Reset Search
        searchInput.value = '';
        searchResults.innerHTML = '';
        document.getElementById('recentList').style.display = 'block';
    }

    // Live Search Logic (Debounced)
    let searchTimeout;
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        const query = this.value.trim();
        const recentList = document.getElementById('recentList');
        
        if (query.length === 0) {
            searchResults.innerHTML = '';
            recentList.style.display = 'block';
            return;
        }

        recentList.style.display = 'none'; // Hide recent list when searching
        searchResults.innerHTML = '<div style="padding: 10px; font-size: 12px; color: var(--muted); text-align: center;">Mencari...</div>';
        
        searchTimeout = setTimeout(async () => {
            try {
                const response = await fetch(`{{ route('admin.customers.search') }}?q=${encodeURIComponent(query)}`);
                const data = await response.json();
                
                searchResults.innerHTML = '';
                
                if (data.length === 0) {
                    searchResults.innerHTML = `<div style="padding: 10px; font-size: 12px; color: var(--danger); text-align: center;">❌ Tidak ditemukan. Klik tombol [+] untuk menambah.</div>`;
                } else {
                    data.forEach(cust => {
                        const div = document.createElement('div');
                        div.className = 'custom-option';
                        const safeName = cust.nama.replace(/'/g, "\\'").replace(/"/g, '&quot;');
                        div.innerHTML = cust.nama;
                        div.onclick = () => selectOption(cust.id_pelanggan, cust.nama);
                        searchResults.appendChild(div);
                    });
                }
            } catch (e) {
                searchResults.innerHTML = '<div style="padding: 10px; font-size: 12px; color: var(--danger); text-align: center;">Error koneksi.</div>';
            }
        }, 300); // 300ms delay
    });

    // Add Modal Logic
    const modal = document.getElementById('customerModal');

    function openAddModal() {
        modal.style.display = 'flex';
        // if user typed something in search, pre-fill it
        if(searchInput.value) document.getElementById('qc_nama').value = searchInput.value;
    }

    function closeAddModal() {
        modal.style.display = 'none';
    }

    async function submitNewCustomer() {
        const nama = document.getElementById('qc_nama').value;
        const hp = document.getElementById('qc_hp').value;
        const alamat = document.getElementById('qc_alamat').value;
        const submitBtn = document.querySelector('#quick-add-customer-form button[type="submit"]');
        
        submitBtn.disabled = true;
        submitBtn.textContent = 'Menyimpan...';
        
        try {
            const formData = new FormData();
            formData.append('nama', nama);
            formData.append('no_telp', hp);
            formData.append('alamat', alamat);
            formData.append('_token', '{{ csrf_token() }}');
            
            const response = await fetch('{{ route("admin.customers.storeApi") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json'
                }
            });
            
            const data = await response.json();
            
            if (data.success) {
                // Instantly select the new customer
                selectOption(data.customer.id_pelanggan, data.customer.nama);
                
                // Clean up modal
                document.getElementById('quick-add-customer-form').reset();
                closeAddModal();
            } else {
                alert('Gagal menyimpan data.');
            }
        } catch (e) {
            alert('Kesalahan jaringan.');
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Simpan & Pilih Pelanggan';
        }
    }
</script>
@endsection