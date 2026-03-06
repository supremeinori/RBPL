@extends('layouts.app')

@section('title', 'Tambah Pesanan')
@section('subtitle', 'Catat detail pesanan pelanggan baru.')

@section('styles')
<style>
    .form-grid { display: grid; grid-template-columns: 1fr 1.5fr; gap: 32px; }
    .form-group { margin-bottom: 20px; }
    label { display: block; font-size: 13px; font-weight: 500; color: var(--light); margin-bottom: 8px; }
    input, select, textarea {
        width: 100%;
        padding: 12px 14px;
        background: var(--mid);
        border: 1px solid var(--border);
        border-radius: 10px;
        color: var(--white);
        font-size: 14px;
        font-family: 'Inter', sans-serif;
        outline: none;
        transition: border-color var(--transition), box-shadow var(--transition);
    }
    input:focus, select:focus, textarea:focus { border-color: rgba(255,255,255,0.4); box-shadow: 0 0 0 3px rgba(255,255,255,0.06); }
    
    .btn-submit {
        padding: 12px 24px;
        background: var(--white);
        color: var(--black);
        border: none;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: background var(--transition), transform var(--transition);
    }
    .btn-submit:hover { background: #e8e8e8; transform: translateY(-1px); }

    .add-customer-link {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        margin-top: 8px;
        font-size: 12px;
        color: var(--subtle);
        text-decoration: none;
        transition: color var(--transition);
    }
    .add-customer-link:hover { color: var(--white); }
</style>
@endsection

@section('content')
<div class="section-card">
    <div class="section-header">
        <span class="section-title">Form Data Pesanan</span>
    </div>
    <div style="padding: 24px;">
        <form action="{{ route('admin.orders.store') }}" method="POST">
            @csrf
            
            <div class="form-grid">
                {{-- LEFT SIDE --}}
                <div class="form-col">
                    <div class="form-group">
                        <label for="id_pelanggan">Pelanggan</label>
                        <select name="id_pelanggan" id="id_pelanggan" required>
                            <option value="">Pilih Pelanggan</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id_pelanggan }}">{{ $customer->nama }}</option>
                            @endforeach
                        </select>
                        <a href="{{ route('admin.customers.create') }}" class="add-customer-link">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:12px;height:12px;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                            Tambah Pelanggan Baru
                        </a>
                    </div>

                    <div class="form-group">
                        <label for="nama_pesanan">Nama Pesanan</label>
                        <input type="text" name="nama_pesanan" id="nama_pesanan" placeholder="Contoh: Cetak Spanduk 2x1" required>
                    </div>

                    <div class="form-group">
                        <label for="tanggal_pemesanan">Tanggal Pesanan</label>
                        <input type="date" name="tanggal_pemesanan" id="tanggal_pemesanan" value="{{ date('Y-m-d') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="deadline">Deadline</label>
                        <input type="date" name="deadline" id="deadline" required>
                    </div>
                </div>

                {{-- RIGHT SIDE --}}
                <div class="form-col">
                    <div class="form-group">
                        <label for="status_pemesanan">Status Pesanan</label>
                        <select name="status_pemesanan" id="status_pemesanan" required>
                            <option value="pending">Pending</option>
                            <option value="diproses">Diproses</option>
                            <option value="selesai">Selesai</option>
                            <option value="dibatalkan">Dibatalkan</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="deskripsi_pesanan">Deskripsi / Catatan Pesanan</label>
                        <textarea name="deskripsi_pesanan" id="deskripsi_pesanan" rows="10" placeholder="Masukkan detail teknis pesanan..."></textarea>
                    </div>

                    <div style="margin-top: 32px; display: flex; gap: 12px; justify-content: flex-end;">
                        <a href="/admin/dashboard" 
                           style="padding: 12px 24px; border: 1px solid var(--border); border-radius: 10px; color: var(--subtle); text-decoration: none; font-size: 14px; font-weight: 500;">
                            Batal
                        </a>
                        <button type="submit" class="btn-submit">Simpan Pesanan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection