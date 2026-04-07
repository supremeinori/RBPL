@extends('layouts.app')
@section('title', 'Detail Pesanan')
@section('subtitle', 'Pesanan #' . $order->id_pemesanan . ' - ' . $order->nama_pesanan)

@section('styles')
<style>
    .tab-nav {
        display: flex;
        gap: 12px;
        position: fixed;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%);
        background: var(--dark);
        padding: 12px 24px;
        border-radius: 40px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.15);
        border: 1px solid var(--border);
        z-index: 1000;
    }
    .tab-item {
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        color: var(--muted);
        text-decoration: none;
        background: var(--dark);
        border: 1px solid var(--border);
        transition: all 0.2s;
    }
    .tab-item:hover { background: var(--mid); color: var(--light); }
    .tab-item.active { background: var(--accent); color: var(--white); border-color: var(--accent); }
    
    .info-table th { padding: 12px 16px; color: var(--muted); text-align: left; font-weight: 600; font-size: 13.5px; width: 220px; border-bottom: 1px solid var(--border); }
    .info-table td { padding: 12px 16px; border-bottom: 1px solid var(--border); font-size: 14px; }
</style>
@endsection

@section('content')
<div class="tab-nav" style="display: flex; gap: 12px; position: fixed; bottom: 40px; left: calc(50% + 125px); transform: translateX(-50%); background: var(--dark); padding: 12px 24px; border-radius: 40px; box-shadow: 0 10px 40px rgba(0,0,0,0.15); border: 1px solid var(--border); z-index: 9999;">
    <a href="{{ route('admin.orders.show', [$order, 'tab' => 'informasi']) }}" class="tab-item {{ $tab === 'informasi' ? 'active' : '' }}" style="border-radius: 30px;">Informasi & Timeline</a>
    <a href="{{ route('admin.orders.show', [$order, 'tab' => 'desain']) }}" class="tab-item {{ $tab === 'desain' ? 'active' : '' }}" style="border-radius: 30px;">Manajemen Desain (Draft)</a>
    <a href="{{ route('admin.orders.show', [$order, 'tab' => 'pembayaran']) }}" class="tab-item {{ $tab === 'pembayaran' ? 'active' : '' }}" style="border-radius: 30px;">Pembayaran & Keuangan</a>
</div>

<div class="section-card" style="margin-bottom: 100px;">
    @if(session('success'))
        <div style="padding: 16px 24px; background: rgba(16, 185, 129, 0.1); color: var(--success); border-bottom: 1px solid var(--border); margin-bottom: 24px; border-radius: 8px;">
            <strong>{{ session('success') }}</strong>
        </div>
    @endif

    @if($tab === 'informasi')
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
            <h3 style="font-size: 18px;">Informasi Teknis Pesanan</h3>
            <button class="btn-primary" onclick="toggleEditInfo()" id="btn-edit-info" style="font-size: 12px; padding: 6px 12px; background: var(--mid); box-shadow: none;">Edit Deskripsi</button>
        </div>
        
        <form action="{{ route('admin.orders.update', $order->id_pemesanan) }}" method="POST" id="form-edit-info">
            @csrf
            @method('PUT')
            
            <div style="border: 1px solid var(--border); border-radius: 8px; overflow: hidden; margin-bottom: 16px;">
                <table class="info-table" style="width: 100%; border-collapse: collapse;">
                    <tbody>
                        <tr>
                            <th>Pelanggan Pemesan</th>
                            <td>
                                {{ $order->customer->nama ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            <th>Deskripsi / Instruksi Tambahan</th>
                            <td>
                                <div id="display-desc">{{ $order->deskripsi_pemesanan ?: '-' }}</div>
                                <div id="edit-desc" style="display: none;">
                                    <textarea name="deskripsi_pemesanan" rows="4" style="width: 100%; padding: 8px; border: 1px solid var(--border); border-radius: 6px; background: var(--black); color: var(--light);">{{ $order->deskripsi_pemesanan }}</textarea>
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
                                    <!-- Form Muncul jika status pesanan diproses tapi deadline belum diset -->
                                    <div style="margin-top: 12px; background: var(--mid); padding: 12px; border-radius: 8px; border: 1px dashed var(--accent);">
                                        <p style="font-size: 11px; margin-bottom: 8px; font-weight: 600; color: var(--light);">⚠️ Action Required: Tentukan Deadline Produksi</p>
                                        <form action="{{ route('admin.orders.updateDeadline', $order->id_pemesanan) }}" method="POST" style="display:flex; gap: 8px;">
                                            @csrf
                                            <input type="date" name="deadline" required style="padding: 6px; border-radius: 4px; border: 1px solid var(--border); background: var(--black); color: var(--light); font-size: 12px; flex: 1;">
                                            <button type="submit" class="btn-primary" style="padding: 6px 12px; font-size: 12px;">Simpan</button>
                                        </form>
                                    </div>
                                @endif
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Status Saat Ini</th>
                        <td>
                            <span style="background:var(--mid); padding:6px 12px; border-radius:6px; font-size:12px; font-weight:600; display:inline-block; border: 1px solid var(--border);">{{ strtoupper($order->status_pemesanan) }}</span>
                            @if($order->status_pemesanan === 'pending')
                                <span style="font-size:12px; color:var(--muted); margin-left:8px;">(Menunggu Approval Harga/DP)</span>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div style="display: none; justify-content: flex-end;" id="submit-desc-btn">
            <button type="button" onclick="cancelEditInfo()" class="btn-primary" style="background:var(--mid); margin-right:8px; box-shadow:none;">Batal</button>
            <button type="submit" class="btn-primary">Update Deskripsi</button>
        </div>
        </form>

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
                document.getElementById('btn-edit-info').style.display = 'inline-block';
                // Reset form optionally
                document.getElementById('form-edit-info').reset();
            }
        </script>

    @elseif($tab === 'desain')
        @php
            $latestDesain = $order->desains->sortByDesc('draft_ke')->first();
            $isApproved   = $latestDesain && $latestDesain->status_desain === 'setuju';
        @endphp

        <!-- Blok Penugasan Desainer (Assignee PIC) -->
        <div style="background: var(--dark); padding: 20px; border-radius: 8px; border: 1px solid var(--border); margin-bottom: 24px;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h4 style="margin: 0 0 4px 0; font-size: 15px;">Penanggung Jawab Desain (PIC)</h4>
                    @if($order->designer)
                        <div style="display: flex; align-items: center; gap: 10px; margin-top: 8px;">
                            <div style="width: 32px; height: 32px; background: var(--accent); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; color: white;">
                                {{ substr($order->designer->name, 0, 1) }}
                            </div>
                            <div>
                                <span style="font-weight: 600; font-size: 14px; color: var(--white);">{{ $order->designer->name }}</span>
                                <p style="margin: 0; font-size: 12px; color: var(--muted);">{{ $order->designer->email }}</p>
                            </div>
                        </div>
                    @else
                        <p style="margin: 8px 0 0 0; font-size: 13px; color: var(--danger);">⚠️ Belum ada desainer yang ditunjuk untuk pesanan ini.</p>
                    @endif
                </div>
                
                <div style="width: 250px;">
                    <form action="{{ route('admin.orders.assignDesigner', $order->id_pemesanan) }}" method="POST">
                        @csrf
                        <label style="display: block; font-size: 11px; color: var(--muted); margin-bottom: 6px;">{{ $order->designer ? 'Ganti Desainer' : 'Tunjuk Desainer PIC' }}</label>
                        <div style="display: flex; gap: 8px;">
                            <select name="id_desainer" required style="flex: 1; padding: 6px; border-radius: 6px; border: 1px solid var(--border); background: var(--black); color: var(--light); font-size: 12px;">
                                <option value="" disabled selected>-- Pilih Desainer --</option>
                                @foreach($designers as $designer)
                                    <option value="{{ $designer->id }}" {{ $order->id_desainer == $designer->id ? 'selected' : '' }}>
                                        {{ $designer->name }}
                                    </div>
                                @endforeach
                            </select>
                            <button type="submit" class="btn-primary" style="padding: 6px 12px; font-size: 11px;">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 16px;">
            <h3 style="font-size: 18px;">Histori Perancangan Draft</h3>
            @if(!$isApproved)
                @if($order->id_desainer)
                    <a href="{{ route('admin.desain.create', $order->id_pemesanan) }}" class="btn-primary" style="padding: 8px 16px; font-size: 13px;">+ Ajukan Antrean Desain Baru</a>
                @else
                    <button class="btn-primary" disabled style="padding: 8px 16px; font-size: 13px; opacity: 0.5; cursor: not-allowed; background: var(--mid);">Tunjuk Desainer Dulu</button>
                @endif
            @else
                <span style="background: rgba(16, 185, 129, 0.1); color: var(--success); padding: 8px 16px; border-radius: 6px; font-size: 13px; font-weight: 600;">Desain Telah Disetujui (Final)</span>
            @endif
        </div>

        <div class="table-wrap">
            @if($order->desains->isEmpty())
                <div style="text-align:center; padding: 40px; color: var(--muted);">Belum ada antrean draft desain yang diajukan ke tim desainer.</div>
            @else
                <table>
                    <thead>
                        <tr>
                            <th>Iterasi Draft</th>
                            <th>Status Reviu Admin</th>
                            <th>Tgl Update Terakhir</th>
                            <th>Tindakan Lanjutan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->desains->sortByDesc('draft_ke') as $desain)
                        <tr>
                            <td><strong>Draft Ke-{{ $desain->draft_ke }}</strong></td>
                            <td>
                                @if($desain->status_desain === 'pending')
                                    <span style="color:var(--warning);">Sedang Dikerjakan Desainer</span>
                                @elseif($desain->status_desain === 'revisi')
                                    <span style="color:var(--danger);">Menunggu Revisi Ulang</span>
                                @elseif($desain->status_desain === 'setuju')
                                    <span style="color:var(--success); font-weight:600;">✓ Disetujui / Acc</span>
                                @else
                                    <span style="color:var(--accent);">Menunggu Review Anda (Cek Bukti)</span>
                                @endif
                            </td>
                            <td>{{ $desain->updated_at->format('d M Y H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.desain.show', $desain->id_desain) }}" class="btn-primary" style="padding: 4px 12px; font-size: 12px; background:var(--mid); color:var(--light); box-shadow:none;">Buka Detail Karya</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

    @elseif($tab === 'pembayaran')
        <div style="margin-bottom: 40px;">
            <h3 style="margin-bottom: 16px; font-size: 18px;">Kesepakatan Nominal Project</h3>
            @if($order->total_harga)
                <div style="background: var(--dark); padding: 24px; border-radius: 8px; border: 1px solid var(--border); display:flex; justify-content:space-between; align-items:center;">
                    <div>
                        <p style="font-size: 13px; color: var(--muted); margin-bottom: 8px;">Total Nilai Invoice yang Disepakati bersama Pelanggan:</p>
                        <h2 style="font-size: 36px; color: var(--accent); margin: 0; font-weight:800;">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</h2>
                    </div>
                    
                    @if($order->bukti_kesepakatan)
                        <div style="text-align:right;">
                            <p style="font-size: 12px; color: var(--muted); margin-bottom: 6px;">SS/Dokumen Bukti Deal Harga:</p>
                            <a href="{{ asset('uploads/pembayaran/' . $order->bukti_kesepakatan) }}" target="_blank">
                                <img src="{{ asset('uploads/pembayaran/' . $order->bukti_kesepakatan) }}" alt="Bukti Kesepakatan" style="max-height:80px; border-radius: 6px; border: 1px solid var(--border); box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                            </a>
                        </div>
                    @endif
                </div>
            @else
                <div style="background: rgba(245, 158, 11, 0.05); border: 1px dashed var(--warning); padding: 24px; border-radius: 8px;">
                    <p style="color:var(--warning); margin-bottom: 16px; font-weight:600; font-size: 15px;">⚠️ Admin Belum Mengunci Harga Final Pekerjaan Ini!</p>
                    <form action="{{ route('admin.orders.storeKesepakatan', $order->id_pemesanan) }}" method="POST" enctype="multipart/form-data" style="display:flex; gap:16px; align-items:flex-end;">
                        @csrf
                        <div style="flex:1;">
                            <label style="display:block; margin-bottom:6px; font-size:13px; font-weight:600;">Masukkan Total Harga Tepat (Rp):</label>
                            <input type="number" name="total_harga" required style="width:100%; padding:10px; border:1px solid var(--border); border-radius:6px; background:var(--black); color:var(--light);">
                        </div>
                        <div style="flex:1;">
                            <label style="display:block; margin-bottom:6px; font-size:13px; font-weight:600;">Upload SS Bukti Chat (Screenshot Deal):</label>
                            <input type="file" name="bukti_kesepakatan" required accept="image/*" style="width:100%; padding:8px; border:1px solid var(--border); border-radius:6px; background:var(--black); color:var(--light);">
                        </div>
                        <button type="submit" class="btn-primary" style="padding: 10px 24px; height: 43px;">Simpan Bukti Final</button>
                    </form>
                </div>
            @endif
        </div>

        <div>
            @php
                $totalDibayar = $order->pembayarans->where('status_verifikasi', '!=', 'ditolak')->sum('nominal');
            @endphp
            
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 16px;">
                <h3 style="font-size: 18px;">Histori Penagihan / Riwayat Transaksi</h3>
                @if($order->total_harga && $totalDibayar < $order->total_harga)
                    <a href="{{ route('admin.pembayaran.create', $order->id_pemesanan) }}" class="btn-primary" style="padding: 8px 16px; font-size: 13px;">+ Buat Record Pembayaran Masuk</a>
                @elseif($order->total_harga && $totalDibayar >= $order->total_harga)
                    <span style="background: rgba(16, 185, 129, 0.1); color: var(--success); padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: 600; border:1px solid var(--success);">✔ PEMBAYARAN LUNAS</span>
                @endif
            </div>

            <div class="table-wrap">
                @if($order->pembayarans->isEmpty())
                    <div style="text-align:center; padding: 40px; color: var(--muted);">Belum ada termin cicilan / transaksi uang yang dilaporkan ke sistem.</div>
                @else
                    <table>
                        <thead>
                            <tr>
                                <th>Tgl Transaksi Bayar</th>
                                <th>Jenis Setoran</th>
                                <th>Lewat Saluran</th>
                                <th>Penerimaan Nominal</th>
                                <th>Keputusan (Finance)</th>
                                <th>Bukti Lampiran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->pembayarans->sortByDesc('tanggal_bayar') as $bayar)
                            <tr>
                                <td>{{ date('d M Y (H:i)', strtotime($bayar->tanggal_bayar)) }}</td>
                                <td><span style="background:var(--mid); padding:4px 8px; border-radius:4px; font-size:11px; font-weight:bold;">{{ strtoupper($bayar->jenis_pembayaran) }}</span></td>
                                <td>{{ $bayar->metode_pembayaran ?? 'Penerimaan Kasir Manual' }}</td>
                                <td style="font-weight:700; color:var(--white);">Rp {{ number_format($bayar->nominal, 0, ',', '.') }}</td>
                                <td>
                                    @if($bayar->status_verifikasi === 'disetujui')
                                        <span style="color:var(--success); font-weight:600;">✓ Diverifikasi Akuntan</span>
                                    @elseif($bayar->status_verifikasi === 'ditolak')
                                        <span style="color:var(--danger); font-weight:600;">✗ Tertolak Kas ({{ $bayar->alasan_penolakan ?? 'Tidak Layak' }})</span>
                                    @else
                                        <span style="color:var(--warning); font-weight:600;">⌛ Pengecekan Rekening</span>
                                    @endif
                                </td>
                                <td>
                                    @if($bayar->bukti_pembayaran)
                                        <a href="{{ asset('uploads/pembayaran/' . $bayar->bukti_pembayaran) }}" target="_blank" style="color:var(--accent); text-decoration:none; font-size:13px; font-weight:600;">Buka Gambar Struk ↗</a>
                                    @else
                                        <span style="color:var(--muted);">- Kosong -</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    @endif
</div>
@endsection
