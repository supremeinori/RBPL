@extends('layouts.app')
@section('title', 'Tambah User')
@section('subtitle', 'Daftarkan admin, desainer, atau akuntan baru')

@section('styles')
<style>
    .form-group { margin-bottom: 20px; }
    .form-label { display: block; margin-bottom: 8px; font-weight: 500; font-size: 13.5px; }
    .form-input { 
        width: 100%; 
        padding: 10px 14px; 
        border: 1px solid var(--border); 
        border-radius: 8px; 
        background: var(--black); 
        color: var(--light); 
        font-family: inherit;
    }
    .form-input:focus { outline: none; border-color: var(--accent); }
    .form-action { display: flex; gap: 12px; margin-top: 32px; }
</style>
@endsection

@section('content')
<div class="section-card" style="max-width: 600px;">
    <div class="section-header">
        <h2 class="section-title">Formulir Pendaftaran Staf</h2>
    </div>

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
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="form-input">
            </div>

            <div class="form-group">
                <label class="form-label">Alamat Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="form-input">
            </div>

            <div class="form-group">
                <label class="form-label">Password Setup</label>
                <input type="password" name="password" required class="form-input" minlength="8">
            </div>

            <div class="form-group">
                <label class="form-label">Hak Akses (Role)</label>
                <select name="role" required class="form-input">
                    <option value="" disabled selected>Pilih Role</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="desainer" {{ old('role') == 'desainer' ? 'selected' : '' }}>Desainer</option>
                    <option value="akuntan" {{ old('role') == 'akuntan' ? 'selected' : '' }}>Akuntan</option>
                </select>
            </div>

            <div class="form-action">
                <button type="submit" class="btn-primary">Registrasi User</button>
                <a href="{{ route('admin.users.index') }}" class="btn-primary" style="background:var(--mid); color:var(--light); box-shadow:none;">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection