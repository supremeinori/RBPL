@extends('layouts.app')

@section('title', 'Edit User')
@section('subtitle', 'Perbarui informasi pengguna yang sudah ada.')

@section('styles')
<style>
    .form-container { max-width: 600px; }
    .form-group { margin-bottom: 20px; }
    label { display: block; font-size: 13px; font-weight: 500; color: var(--light); margin-bottom: 8px; }
    input, select {
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
    input:focus, select:focus { border-color: rgba(255,255,255,0.4); box-shadow: 0 0 0 3px rgba(255,255,255,0.06); }
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
            <span class="section-title">Edit Detail User</span>
        </div>
        <div style="padding: 24px;">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required>
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required>
                </div>

                <div class="form-group">
                    <label for="role">Role / Peran</label>
                    <select name="role" id="role" required>
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="desainer" {{ $user->role == 'desainer' ? 'selected' : '' }}>Desainer</option>
                        <option value="akuntan" {{ $user->role == 'akuntan' ? 'selected' : '' }}>Akuntan</option>
                    </select>
                </div>

                <div style="margin-top: 32px; display: flex; gap: 12px;">
                    <a href="{{ route('admin.users.index') }}" 
                       style="flex: 1; text-align: center; padding: 12px; border: 1px solid var(--border); border-radius: 10px; color: var(--subtle); text-decoration: none; font-size: 14px; font-weight: 500;">
                        Batal
                    </a>
                    <button type="submit" class="btn-submit" style="flex: 2;">Update User</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection