@extends('layouts.app')

@section('title', 'Tambah Pelanggan')
@section('subtitle', 'Daftar pelanggan baru.')

@section('styles')
<style>
    .form-container { max-width: 600px; }
    .form-group { margin-bottom: 20px; }
    label { display: block; font-size: 13px; font-weight: 500; color: var(--light); margin-bottom: 8px; }
    input, textarea {
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
    input:focus, textarea:focus { border-color: rgba(255,255,255,0.4); box-shadow: 0 0 0 3px rgba(255,255,255,0.06); }
    .btn-submit {
        width: 100%;
        padding: 12px;
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
</style>
@endsection

@section('content')
<div class="form-container">
    <div class="section-card">
        <div class="section-header">
            <span class="section-title">Form Pelanggan Baru</span>
        </div>
        <div style="padding: 24px;">
            <form action="{{ route('admin.customers.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nama">Nama Pelanggan</label>
                    <input type="text" name="nama" id="nama" placeholder="Masukkan nama pelanggan" required autofocus>
                </div>

                <div class="form-group">
                    <label for="no_telp">No. Hp / WhatsApp</label>
                    <input type="text" name="no_telp" id="no_telp" placeholder="Contoh: 08123456789" required>
                </div>

                <div class="form-group">
                    <label for="alamat">Alamat Lengkap</label>
                    <textarea name="alamat" id="alamat" rows="4" placeholder="Masukkan alamat lengkap"></textarea>
                </div>

                <div style="margin-top: 32px; display: flex; gap: 12px;">
                    <a href="{{ route('admin.customers.index') }}" 
                       style="flex: 1; text-align: center; padding: 12px; border: 1px solid var(--border); border-radius: 10px; color: var(--subtle); text-decoration: none; font-size: 14px; font-weight: 500;">
                        Batal
                    </a>
                    <button type="submit" class="btn-submit" style="flex: 2;">Simpan Pelanggan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection