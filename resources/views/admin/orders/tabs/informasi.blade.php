<!-- Bagian: Informasi Teknis & Timeline -->
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
        <h3 style="font-size: 18px; margin: 0;">Informasi Teknis Pesanan</h3>
        <button type="button" class="btn-secondary" onclick="toggleEditInfo()" id="btn-edit-info">Edit Deskripsi</button>
    </div>
    
    <form action="{{ route('admin.orders.update', $order->id_pemesanan) }}" method="POST" id="form-edit-info">
        @csrf
        @method('PUT')
        
        <table class="table">
            <tbody>
                <tr>
                    <th style="width: 250px;">Pelanggan Pemesan</th>
                    <td>{{ $order->customer->nama ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Deskripsi / Instruksi Tambahan</th>
                    <td>
                        <div id="display-desc">{{ $order->deskripsi_pemesanan ?: '-' }}</div>
                        <div id="edit-desc" style="display: none;">
                            <textarea name="deskripsi_pemesanan" rows="4" class="form-control">{{ $order->deskripsi_pemesanan }}</textarea>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>Tgl. Pesanan Dibuat</th>
                    <td>{{ date('d F Y', strtotime($order->tanggal_pemesanan)) }}</td>
                </tr>
                <tr>
                    <th>Tgl. Deadline (Target Selesai)</th>
                    <td>
                        @if($order->deadline)
                            <span style="color:var(--danger); font-weight:600;">{{ date('d F Y', strtotime($order->deadline)) }}</span>
                        @else
                            <span style="color:var(--muted); font-size: 13px;">Belum Ditentukan (Menunggu DP/Kesepakatan)</span>
                            @if($order->status_pemesanan !== 'pending')
                                <!-- Form set deadline -->
                                <div class="form-group" style="margin-top: 12px; background: var(--black); padding: 12px; border-radius: 6px;">
                                    <label class="form-label" style="color: var(--danger);">⚠️ Tentukan Deadline Produksi</label>
                                    <form action="{{ route('admin.orders.updateDeadline', $order->id_pemesanan) }}" method="POST" style="display:flex; gap: 8px;">
                                        @csrf
                                        <input type="date" name="deadline" required class="form-control" style="width: auto;">
                                        <button type="submit" class="btn-primary">Simpan</button>
                                    </form>
                                </div>
                            @endif
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Status Saat Ini</th>
                    <td>
                        <span style="background:var(--mid); padding:6px 12px; border-radius:6px; font-size:12px; font-weight:600; display:inline-block; border: 1px solid var(--border);">
                            {{ strtoupper($order->status_pemesanan) }}
                        </span>
                        @if($order->status_pemesanan === 'pending')
                            <span style="font-size:12px; color:var(--muted); margin-left:8px;">(Menunggu Approval Harga/DP)</span>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
        
        <!-- Tombol Aksi Form Deskripsi -->
        <div style="display: none; justify-content: flex-end; margin-top: 16px; gap: 8px;" id="submit-desc-btn">
            <button type="button" onclick="cancelEditInfo()" class="btn-secondary">Batal</button>
            <button type="submit" class="btn-primary">Update Deskripsi</button>
        </div>
    </form>
</div>

<!-- Script Logika UI Informasi -->
<script>
    function toggleEditInfo() {
        document.getElementById('display-desc').style.display = 'none';
        document.getElementById('edit-desc').style.display = 'block';
        document.getElementById('submit-desc-btn').style.display = 'flex';
        document.getElementById('btn-edit-info').style.display = 'none';
    }

    function cancelEditInfo() {
        document.getElementById('display-desc').style.display = 'block';
        document.getElementById('edit-desc').style.display = 'none';
        document.getElementById('submit-desc-btn').style.display = 'none';
        document.getElementById('btn-edit-info').style.display = 'inline-flex';
        document.getElementById('form-edit-info').reset();
    }
</script>
