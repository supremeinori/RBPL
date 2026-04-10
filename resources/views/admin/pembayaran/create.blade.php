@extends('layouts.app')
@section('title', 'Tambah Riwayat Pembayaran')
@section('subtitle', 'Pesanan #' . $order->id_pemesanan)

@section('content')
    @php
        $totalDibayar = $order->pembayarans->where('status_verifikasi', '!=', 'ditolak')->sum('nominal');
        $sisaTagihan = $order->total_harga - $totalDibayar;
        $totalHarga = $order->total_harga ?? 0;
    @endphp

    <div class="section-card">
        <div class="section-header">
            <h2 class="section-title">Form Input Pembayaran</h2>
        </div>

        <div style="padding: 24px;">
            <p style="margin-bottom: 24px; color: var(--muted);">Sisa tagihan otomatis dikalkulasi sistem. Segala bentuk
                input akan memerlukan validasi dari divisi Akuntan.</p>

            @if ($errors->any())
                <div
                    style="background: rgba(239, 68, 68, 0.1); color: var(--danger); padding: 12px; border-radius: 8px; margin-bottom: 24px;">
                    <ul style="margin-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.pembayaran.store', $order->id_pemesanan) }}" method="POST"
                enctype="multipart/form-data">
                @csrf

                <div style="margin-bottom: 16px;">
                    <label style="display:block; margin-bottom:8px; font-weight:600; font-size: 13.5px;">Sifat Pembayaran:
                        <span style="color:red;">*</span></label>
                    <div style="display:flex; gap:16px;">
                        <select name="jenis_pembayaran" id="jenis_pembayaran" required
                            style="width:100%; padding: 10px; border: 1px solid var(--border); border-radius: 6px; background:var(--black); color:var(--light);">
                            <option value="" disabled selected>Pilih Salah Satu</option>
                            @if (!$hasdp)
                                <!-- Fase A: Belum ada pembayaran DP awal -->
                                <option value="dp">DP (Uang Muka)</option>
                                <option value="lunas">Lunas (100%)</option>
                            @else
                                <!-- Fase B: Sudah ada DP yang disetujui -->
                                <option value="cicil">Cicil Nominal Lain</option>
                                <option value="pelunasan">Pelunasan (Sisa Otomatis)</option>
                            @endif
                        </select>
                    </div>
                </div>

                <!-- Opsi Persentase DP yang muncul khusus jika milih DP -->
                <div id="persentase_dp_container" style="margin-bottom: 16px; display: none; background: var(--mid); padding: 12px; border-radius: 8px; border: 1px solid var(--border);">
                    <label style="display:block; margin-bottom:8px; font-weight:600; font-size: 13.5px;">Persentase DP:</label>
                    <div style="display:flex; gap:16px;">
                        <label style="cursor:pointer; display:flex; align-items:center; gap:6px;">
                            <input type="radio" name="persen_dp" value="30"> 30%
                        </label>
                        <label style="cursor:pointer; display:flex; align-items:center; gap:6px;">
                            <input type="radio" name="persen_dp" value="50"> 50%
                        </label>
                    </div>
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="display:block; margin-bottom:8px; font-weight:600; font-size: 13.5px;">Nominal (Rp):
                        <span style="color:red;">*</span></label>
                    <p style="font-size:12px; color:var(--muted); margin-bottom:6px;">Sisa yang belum dibayar: Rp
                        <span id="label_sisa">{{ number_format($sisaTagihan, 0, ',', '.') }}</span>
                    </p>
                    <input type="number" name="nominal" id="nominal_input" min="1" max="{{ $sisaTagihan }}"
                        style="width:100%; padding: 10px; border: 1px solid var(--border); border-radius: 6px; background:var(--black); color:var(--light);"
                        required>
                    <p id="nominal_hint" style="font-size: 11px; margin-top: 6px; color: var(--accent); display: none;">*Dihitung otomatis</p>
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="display:block; margin-bottom:8px; font-weight:600; font-size: 13.5px;">Metode Pembayaran:
                        <span style="color:red;">*</span></label>
                    <select name="metode_pembayaran" required
                        style="width:100%; padding: 10px; border: 1px solid var(--border); border-radius: 6px; background:var(--black); color:var(--light);">
                        <option value="" disabled selected>Pilih Salah Satu</option>
                        <option value="Tunai">Tunai / Cash</option>
                        <option value="Transfer Bank Mandiri">Transfer Bank Mandiri</option>
                        <option value="Transfer Bank BCA">Transfer Bank BCA</option>
                        <option value="Transfer Bank BRI">Transfer Bank BRI</option>
                        <option value="E-Wallet">E-Wallet (OVO/Dana/Gopay)</option>
                        <option value="Lainnya">Lainnya...</option>
                    </select>
                </div>

                <div style="margin-bottom: 24px;">
                    <label style="display:block; margin-bottom:8px; font-weight:600; font-size: 13.5px;">Upload Bukti Pembayaran:
                        <span style="color:red;">*</span></label>
                    <input type="file" name="bukti_pembayaran" accept="image/*"
                        style="width:100%; padding: 8px; border: 1px dashed var(--border); border-radius: 6px;"
                        required>
                </div>

                <div style="display:flex; gap: 12px;">
                    <button type="submit" class="btn-primary">Simpan Transaksi</button>
                    <a href="{{ route('admin.orders.show', $order->id_pemesanan) }}" class="btn-primary"
                        style="background:var(--mid); color:var(--light); box-shadow:none;">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const jenisSelect = document.getElementById('jenis_pembayaran');
        const nominalInput = document.getElementById('nominal_input');
        const containerDP = document.getElementById('persentase_dp_container');
        const radiosDP = document.querySelectorAll('input[name="persen_dp"]');
        const nominalHint = document.getElementById('nominal_hint');

        const totalHarga = {{ $totalHarga }};
        const sisaTagihan = {{ $sisaTagihan }};

        function calculateNominal() {
            let jenis = jenisSelect.value;
            
            // Tampilkan atau sembunyikan persentase DP
            if (jenis === 'dp') {
                containerDP.style.display = 'block';
            } else {
                containerDP.style.display = 'none';
                // Reset radios jika bukan DP
                radiosDP.forEach(r => r.checked = false);
            }

            // Logika kalkulasi
            if (jenis === 'lunas') {
                nominalInput.value = totalHarga;
                nominalInput.readOnly = true;
                nominalInput.max = totalHarga;
                nominalHint.style.display = 'block';
            } else if (jenis === 'pelunasan') {
                nominalInput.value = sisaTagihan;
                nominalInput.readOnly = true;
                nominalInput.max = sisaTagihan;
                nominalHint.style.display = 'block';
            } else if (jenis === 'cicil') {
                nominalInput.value = '';
                nominalInput.readOnly = false;
                nominalInput.max = sisaTagihan;
                nominalHint.style.display = 'none';
            } else if (jenis === 'dp') {
                nominalInput.value = '';
                nominalInput.readOnly = true; // Akan diisi dari radio button
                nominalInput.max = totalHarga;
                nominalHint.style.display = 'block';
            }
        }

        // Listener untuk select jenis pembayaran
        jenisSelect.addEventListener('change', calculateNominal);

        // Listener khusus untuk radio button DP
        radiosDP.forEach(radio => {
            radio.addEventListener('change', function() {
                if(this.checked) {
                    let persentase = parseInt(this.value) / 100;
                    nominalInput.value = Math.round(totalHarga * persentase);
                }
            });
        });
    });
</script>
@endsection