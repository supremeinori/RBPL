@extends('layouts.app')
@section('title', 'Kelola Pelanggan')
@section('subtitle', 'Daftar semua pelanggan yang terdaftar')

@section('content')
<div class="card">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 24px;">
        <h2 style="margin:0; font-size: 18px; font-weight: 600;">Data Pelanggan</h2>
        <a href="{{ route('admin.customers.create') }}" class="btn-primary">
            + Tambah Pelanggan
        </a>
    </div>

    @if(session('success'))
        <div class="alert-success">
            <strong>{{ session('success') }}</strong>
        </div>
    @endif

    <table class="table">
        <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Pelanggan</th>
                    <th>No. Telepon</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $customer)
                <tr>
                    <td><strong>#{{ $customer->id_pelanggan }}</strong></td>
                    <td>{{ $customer->nama }}</td>
                    <td>{{ $customer->no_telp }}</td>
                    <td style="color:var(--muted); max-width:250px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ $customer->alamat }}</td>
                    <td>
                        <a href="{{ route('admin.customers.edit', $customer->id_pelanggan) }}" class="btn-primary" style="padding: 4px 12px; font-size:12px;">Edit</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center; padding:40px; color:var(--muted);">Data pelanggan masih kosong.</td>
                </tr>
                @endforelse
        </tbody>
    </table>

    @if($customers->count() > 0 && method_exists($customers, 'links'))
    <div style="margin-top: 16px;">
        {{ $customers->links() }}
    </div>
    @endif
</div>
@endsection