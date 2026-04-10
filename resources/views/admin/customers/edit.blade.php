@extends('layouts.app')
@section('title', 'Edit Pelanggan')
@section('subtitle', 'Pembaruan data pelanggan #' . $customer->id_pelanggan)

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
<div class="section-card">
    <div class="section-header">
        <h2 class="section-title">Formulir Edit Pelanggan</h2>
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
        <form action="{{ route('admin.customers.update', $customer->id_pelanggan) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label class="form-label">Nama Pelanggan</label>
                <input type="text" name="nama" value="{{ old('nama', $customer->nama) }}" required class="form-input">
            </div>

            <div class="form-group">
                <label class="form-label">Alamat</label>
                <textarea name="alamat" required class="form-input" rows="4">{{ old('alamat', $customer->alamat) }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label">No. Telepon</label>
                <input type="text" name="no_telp" value="{{ old('no_telp', $customer->no_telp) }}" required class="form-input">
            </div>

            <div class="form-action">
                <button type="submit" class="btn-primary">Update Pelanggan</button>
                <a href="{{ route('admin.customers.index') }}" class="btn-primary" style="background:var(--mid); color:var(--light); box-shadow:none;">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection