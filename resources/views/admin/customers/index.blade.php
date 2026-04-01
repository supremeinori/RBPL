@extends('layouts.app')
@section('title', 'Kelola Pelanggan')
@section('subtitle', 'Daftar semua pelanggan yang terdaftar')

@section('content')
<div class="section-card">
    <div class="section-header">
        <h2 class="section-title">Data Pelanggan</h2>
        <a href="{{ route('admin.customers.create') }}" class="btn-primary">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            Tambah Pelanggan
        </a>
    </div>

    @if(session('success'))
        <div style="padding: 16px 24px; background: rgba(16, 185, 129, 0.1); color: var(--success); border-bottom: 1px solid var(--border);">
            <strong>{{ session('success') }}</strong>
        </div>
    @endif

    <div class="table-wrap">
        <table>
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
    </div>

    @if($customers->count() > 0 && method_exists($customers, 'links'))
    <div style="padding: 16px 24px; border-top: 1px solid var(--border);">
        {{ $customers->links() }}
    </div>
    @endif
</div>
@endsection