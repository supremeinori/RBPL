@extends('layouts.app')

@section('title', 'Dashboard Akuntan')
@section('subtitle', 'Selamat datang di area keuangan.')

@section('content')
    <div class="stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px;">
        <div class="section-card" style="padding: 24px; margin-bottom: 0;">
            <div style="font-size: 11px; color: var(--muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 8px;">Total Pemasukan</div>
            <div style="font-size: 24px; font-weight: 700; color: var(--white);">Rp 0</div>
        </div>
        <div class="section-card" style="padding: 24px; margin-bottom: 0;">
            <div style="font-size: 11px; color: var(--muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 8px;">Tagihan Pending</div>
            <div style="font-size: 24px; font-weight: 700; color: var(--white);">0</div>
        </div>
    </div>

    <div class="section-card">
        <div class="section-header">
            <span class="section-title">Informasi Akuntansi</span>
        </div>
        <div style="padding: 24px; color: var(--subtle); font-size: 14px;">
            <p>Selamat datang di sistem manajemen keuangan MR BONGKENG. Anda memiliki akses untuk melihat laporan pesanan dan status pembayaran.</p>
        </div>
    </div>
@endsection