<!-- Bagian: Manajemen Desain / Draft -->
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

@php
    $latestDesain = $order->desains->sortByDesc('draft_ke')->first();
    $isApproved   = $latestDesain && $latestDesain->status_desain === 'setuju';
@endphp

<!-- Komponen Assignee / Penugasan Desainer -->
<div class="card" style="margin-bottom: 24px;">
    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
        <div>
            <h4 style="margin: 0 0 8px 0;">Penanggung Jawab Desain (PIC)</h4>
            @if($order->designer)
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div style="width: 32px; height: 32px; background: var(--accent); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; color: white;">
                        {{ substr($order->designer->name, 0, 1) }}
                    </div>
                    <div>
                        <span style="font-weight: 600; font-size: 14px; color: var(--light);">{{ $order->designer->name }}</span>
                        <p style="margin: 0; font-size: 12px; color: var(--muted);">{{ $order->designer->email }}</p>
                    </div>
                </div>
            @else
                <p style="margin: 0; font-size: 13px; color: var(--danger);">⚠️ Belum ada desainer yang ditunjuk untuk pesanan ini.</p>
            @endif
        </div>
        
        <div style="width: 300px;">
            @if($order->status_pemesanan !== 'dibatalkan')
                <form action="{{ route('admin.orders.assignDesigner', $order->id_pemesanan) }}" method="POST">
                    @csrf
                    <label class="form-label">{{ $order->designer ? 'Ganti Desainer' : 'Tunjuk Desainer PIC' }}</label>
                    <div style="display: flex; gap: 8px;">
                        <select name="id_desainer" required class="form-control">
                            <option value="" disabled selected>-- Pilih Desainer --</option>
                            @foreach($designers as $designer)
                                <option value="{{ $designer->id }}" {{ $order->id_desainer == $designer->id ? 'selected' : '' }}>
                                    {{ $designer->name }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn-primary">Simpan</button>
                    </div>
                </form>
            @else
                <p style="margin: 0; font-size: 12px; color: var(--muted); text-align: right;">Penugasan desainer dikunci (Pesanan Batal)</p>
            @endif
        </div>
    </div>
</div>

<!-- Komponen Tabel Draft Desain -->
<div class="card">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 16px;">
        <h3 style="font-size: 18px; margin: 0;">Histori Perancangan Draft</h3>
        @if($order->status_pemesanan !== 'dibatalkan')
            @if(!$isApproved)
                @if($order->id_desainer)
                    <a href="{{ route('admin.desain.create', $order->id_pemesanan) }}" class="btn-primary">+ Ajukan Antrean Desain Baru</a>
                @else
                    <button class="btn-secondary" disabled style="opacity: 0.5; cursor: not-allowed;">Tunjuk Desainer Dulu</button>
                @endif
            @else
                <span class="alert-success" style="padding: 8px 16px; margin: 0;">Desain Telah Disetujui (Final)</span>
            @endif
        @endif
    </div>

    @if($order->desains->isEmpty())
        <div style="text-align:center; padding: 40px; color: var(--muted); border: 1px dashed var(--border); border-radius: 6px;">
            Belum ada antrean draft desain yang diajukan ke tim desainer.
        </div>
    @else
        <table class="table">
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
                        <a href="{{ route('admin.desain.show', $desain->id_desain) }}" class="btn-secondary" style="font-size: 12px;">Buka Detail Karya</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
