@extends('layouts.app')

@section('title', 'Dashboard Desainer')
@section('subtitle', 'Selamat datang di area desain.')

@section('content')
    <div class="stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px;">
        <div class="section-card" style="padding: 24px; margin-bottom: 0;">
            <div style="font-size: 11px; color: var(--muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 8px;">Proyek Aktif</div>
            <div style="font-size: 24px; font-weight: 700; color: var(--white);">0</div>
        </div>
        <div class="section-card" style="padding: 24px; margin-bottom: 0;">
            <div style="font-size: 11px; color: var(--muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 8px;">Menunggu Review</div>
            <div style="font-size: 24px; font-weight: 700; color: var(--white);">0</div>
        </div>
    </div>

    <div class="section-card">
        <div class="section-header">
            <span class="section-title">Informasi Desainer</span>
        </div>
        <div style="padding: 24px; color: var(--subtle); font-size: 14px;">
            <p>Selamat datang di sistem manajemen MR BONGKENG. Anda memiliki akses untuk mengelola aset desain dan status pengerjaan visual.</p>
        </div>
    </div>
@endsection