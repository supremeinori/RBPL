@extends('layouts.app')

@section('title', 'Kelola Pelanggan')
@section('subtitle', 'Daftar pelanggan yang terdaftar di sistem.')

@section('content')
    <div class="section-card">
        <div class="section-header">
            <span class="section-title">Daftar Pelanggan</span>
            <a href="{{ route('admin.customers.create') }}" class="btn-primary">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width:14px;height:14px;">
                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Tambah Pelanggan
            </a>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Phone</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $customer)
                    <tr>
                        <td style="color: var(--muted); font-variant-numeric: tabular-nums;">#{{ $customer->id_pelanggan }}</td>
                        <td style="font-weight: 500; color: var(--white);">{{ $customer->nama }}</td>
                        <td>{{ $customer->alamat }}</td>
                        <td style="font-variant-numeric: tabular-nums;">{{ $customer->no_telp }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4">
                            <div style="padding: 48px; text-align: center; color: var(--muted); font-size: 14px;">
                                <p>Data pelanggan masih kosong.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection