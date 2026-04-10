<!-- Bagian: Informasi Teknis & Timeline -->
@if($order->status_pemesanan === 'dibatalkan')
    <div style="background: rgba(239, 68, 68, 0.1); border: 1px solid var(--danger); color: var(--danger); padding: 16px; border-radius: 8px; margin-bottom: 24px; display: flex; align-items: center; gap: 12px;">
        <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="12" y1="8" x2="12" y2="12"></line>
            <line x1="12" y1="16" x2="12.01" y2="16"></line>
        </svg>
        <div style="font-weight: 600;">⚠️ Pesanan ini telah dibatalkan. Seluruh aksi perubahan telah dinonaktifkan.</div>
    </div>
@endif

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
        <h3 style="font-size: 18px; margin: 0;">Informasi Teknis Pesanan</h3>
        @if($order->status_pemesanan !== 'dibatalkan' && $order->status_pemesanan !== 'selesai')
            <button type="button" class="btn-secondary" onclick="toggleEditInfo()" id="btn-edit-info">Edit Deskripsi</button>
        @endif
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
                            <div id="display-deadline">
                                <span style="color:var(--danger); font-weight:600;">{{ date('d F Y', strtotime($order->deadline)) }}</span>
                            </div>
                            <div id="edit-deadline" style="display: none;">
                                <input type="date" name="deadline" value="{{ $order->deadline }}" class="form-control" style="width: auto;">
                            </div>
                        @else
                            <div id="display-deadline">
                                <span style="color:var(--muted); font-size: 13px;">Belum Ditentukan (Menunggu DP/Kesepakatan)</span>
                            </div>
                            
                            @php 
                                $isActionable = !in_array($order->status_pemesanan, ['pending', 'dibatalkan', 'selesai']);
                            @endphp

                            @if($isActionable)
                                <div id="edit-deadline" style="display: none; margin-top: 8px;">
                                    <label class="form-label" style="color: var(--danger); font-size: 11px;">⚠️ Tentukan Deadline Produksi</label>
                                    <input type="date" name="deadline" class="form-control" style="width: auto;">
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

    @if($order->status_pemesanan !== 'dibatalkan' && $order->status_pemesanan !== 'selesai')
        <div style="margin-top: 32px; padding-top: 24px; border-top: 1px solid var(--border); display: flex; justify-content: flex-end;">
            <form action="{{ route('admin.orders.cancel', $order->id_pemesanan) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini? Tindakan ini tidak dapat dibatalkan.');">
                @csrf
                <button type="submit" class="btn-secondary" style="color: var(--danger); border-color: rgba(239, 68, 68, 0.2); background: rgba(239, 68, 68, 0.05);">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px; margin-right: 6px;">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="15" y1="9" x2="9" y2="15"></line>
                        <line x1="9" y1="9" x2="15" y2="15"></line>
                    </svg>
                    Batalkan Pesanan
                </button>
            </form>
        </div>
    @endif
</div>

<!-- Script Logika UI Informasi -->
<script>
    function toggleEditInfo() {
        document.getElementById('display-desc').style.display = 'none';
        document.getElementById('edit-desc').style.display = 'block';
        document.getElementById('display-deadline').style.display = 'none';
        if(document.getElementById('edit-deadline')) {
            document.getElementById('edit-deadline').style.display = 'block';
        }
        document.getElementById('submit-desc-btn').style.display = 'flex';
        document.getElementById('btn-edit-info').style.display = 'none';
    }

    function cancelEditInfo() {
        document.getElementById('display-desc').style.display = 'block';
        document.getElementById('edit-desc').style.display = 'none';
        document.getElementById('display-deadline').style.display = 'block';
        if(document.getElementById('edit-deadline')) {
            document.getElementById('edit-deadline').style.display = 'none';
        }
        document.getElementById('submit-desc-btn').style.display = 'none';
        document.getElementById('btn-edit-info').style.display = 'inline-flex';
        document.getElementById('form-edit-info').reset();
    }
</script>
