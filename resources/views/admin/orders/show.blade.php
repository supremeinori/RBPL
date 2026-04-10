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

    <!-- Render Komponen Tab Dinamis -->
    <div style="margin-bottom: 100px;"> <!-- Beri ruang di bawah agar tidak tertutup tab -->
        @if($tab === 'informasi')
            @include('admin.orders.tabs.informasi')
        @elseif($tab === 'desain')
            @include('admin.orders.tabs.desain')
        @elseif($tab === 'pembayaran')
            @include('admin.orders.tabs.pembayaran')
        @endif
    </div>

    <!-- Tab Navigasi Sederhana Bersih - PINDAH KE BAWAH TENGAH (BERDASARKAN AREA KONTEN) -->
    <div
        style="position: fixed; bottom: 30px; left: calc(50% + 125px); transform: translateX(-50%); z-index: 999; width: auto;">
        <div class="tabs-container"
            style="background: rgba(17, 17, 17, 0.8); backdrop-filter: blur(10px); padding: 8px; border-radius: 50px; border: 1px solid var(--border); box-shadow: 0 10px 30px rgba(0,0,0,0.5); display: flex; gap: 8px; border-bottom: none;">
            <a href="{{ route('admin.orders.show', [$order, 'tab' => 'informasi']) }}"
                class="tab-link {{ $tab === 'informasi' ? 'active' : '' }}"
                style="border-radius: 40px; border: none; padding: 10px 20px;">
                Informasi & Timeline
            </a>
            <a href="{{ route('admin.orders.show', [$order, 'tab' => 'desain']) }}"
                class="tab-link {{ $tab === 'desain' ? 'active' : '' }}"
                style="border-radius: 40px; border: none; padding: 10px 20px;">
                Manajemen Desain (Draft)
            </a>
            <a href="{{ route('admin.orders.show', [$order, 'tab' => 'pembayaran']) }}"
                class="tab-link {{ $tab === 'pembayaran' ? 'active' : '' }}"
                style="border-radius: 40px; border: none; padding: 10px 20px;">
                Pembayaran & Keuangan
            </a>
        </div>
    </div>

@endsection