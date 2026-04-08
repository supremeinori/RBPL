@extends('layouts.app')
@section('title', 'Detail Pesanan')
@section('subtitle', 'Pesanan #' . $order->id_pemesanan . ' - ' . $order->nama_pesanan)

@section('content')

<!-- Notifikasi Global Halaman Admin -->
@if(session('success'))
    <div class="alert-success">
        <strong>{{ session('success') }}</strong>
    </div>
@endif

<!-- Tab Navigasi Sederhana Bersih -->
<div class="tabs-container">
    <a href="{{ route('admin.orders.show', [$order, 'tab' => 'informasi']) }}" class="tab-link {{ $tab === 'informasi' ? 'active' : '' }}">
        Informasi & Timeline
    </a>
    <a href="{{ route('admin.orders.show', [$order, 'tab' => 'desain']) }}" class="tab-link {{ $tab === 'desain' ? 'active' : '' }}">
        Manajemen Desain (Draft)
    </a>
    <a href="{{ route('admin.orders.show', [$order, 'tab' => 'pembayaran']) }}" class="tab-link {{ $tab === 'pembayaran' ? 'active' : '' }}">
        Pembayaran & Keuangan
    </a>
</div>

<!-- Render Komponen Tab Dinamis -->
<div style="margin-top: 24px;">
    @if($tab === 'informasi')
        @include('admin.orders.tabs.informasi')
    @elseif($tab === 'desain')
        @include('admin.orders.tabs.desain')
    @elseif($tab === 'pembayaran')
        @include('admin.orders.tabs.pembayaran')
    @endif
</div>

@endsection
