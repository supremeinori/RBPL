@extends('layouts.app')
@section('title', 'Tambah Pelanggan')
@section('subtitle', 'Pendaftaran data pelanggan baru')



@section('content')
<div class="card" style="max-width: 600px;">
    <h2 style="font-size: 18px; font-weight: 600; margin-bottom: 24px;">Formulir Pelanggan Baru</h2>

    @if ($errors->any())
        <div style="background: rgba(239, 68, 68, 0.1); color: var(--danger); padding: 12px 24px; border-bottom: 1px solid var(--border);">
            <ul style="margin-left: 16px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div>
        <form action="{{ route('admin.customers.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label class="form-label">Nama Pelanggan</label>
                <input type="text" name="nama" value="{{ old('nama') }}" required class="form-control">
            </div>

            <div class="form-group">
                <label class="form-label">Alamat</label>
                <textarea name="alamat" required class="form-control" rows="4">{{ old('alamat') }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label">No. Telepon</label>
                <input type="text" name="no_telp" value="{{ old('no_telp') }}" required class="form-control">
            </div>

            <div style="display: flex; gap: 12px; margin-top: 32px;">
                <button type="submit" class="btn-primary">Simpan Pelanggan</button>
                <a href="{{ route('admin.customers.index') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection