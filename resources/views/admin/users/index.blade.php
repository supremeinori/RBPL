@extends('layouts.app')
@section('title', 'Kelola Pengguna Sistem')
@section('subtitle', 'Daftar staff dan hak akses aplikasi')

@section('content')
<div class="section-card">
    <div class="section-header">
        <h2 class="section-title">Data Staf & Pengguna</h2>
        <a href="{{ route('admin.users.create') }}" class="btn-primary">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            Tambah User
        </a>
    </div>

    @if(session('success'))
        <div style="padding: 16px 24px; background: rgba(16, 185, 129, 0.1); color: var(--success); border-bottom: 1px solid var(--border);">
            <strong>{{ session('success') }}</strong>
        </div>
    @endif

    <div class="table-wrap">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama User</th>
                    <th>Alamat Email</th>
                    <th>Otoritas (Role)</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td><strong>#{{ $user->id }}</strong></td>
                    <td>{{ $user->name }}</td>
                    <td style="color:var(--muted);">{{ $user->email }}</td>
                    <td>
                        @if($user->role === 'superadmin')
                            <span style="background: rgba(192,132,252,0.15); color: #c084fc; padding:4px 10px; border-radius:6px; font-size:12px; font-weight:700; border: 1px solid rgba(192,132,252,0.3);">
                                ★ SUPER ADMIN
                            </span>
                        @elseif($user->role === 'admin')
                            <span style="background: rgba(59,130,246,0.12); color: #60a5fa; padding:4px 8px; border-radius:6px; font-size:12px; border:1px solid rgba(59,130,246,0.2);">ADMIN</span>
                        @elseif($user->role === 'akuntan')
                            <span style="background: rgba(16,185,129,0.12); color: #34d399; padding:4px 8px; border-radius:6px; font-size:12px; border:1px solid rgba(16,185,129,0.2);">AKUNTAN</span>
                        @elseif($user->role === 'desainer')
                            <span style="background: rgba(251,146,60,0.12); color: #fb923c; padding:4px 8px; border-radius:6px; font-size:12px; border:1px solid rgba(251,146,60,0.2);">DESAINER</span>
                        @else
                            <span style="background:var(--mid); padding:4px 8px; border-radius:6px; font-size:12px; border:1px solid var(--border);">{{ strtoupper($user->role) }}</span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex; gap:6px;">
                            @if($user->role !== 'superadmin')
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn-primary" style="padding: 4px 12px; font-size:12px;">Edit</a>
                                @if(Auth::id() !== $user->id)
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="margin:0;" onsubmit="return confirm('Hapus user {{ $user->name }}? Aksi ini tidak bisa dibatalkan.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-primary" style="padding: 4px 12px; font-size:12px; background:rgba(239, 68, 68, 0.1); color:var(--danger); box-shadow:none;">Hapus</button>
                                </form>
                                @endif
                            @else
                                <span style="font-size:12px; color:var(--muted); font-style:italic;">—Terlindungi—</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center; padding:40px; color:var(--muted);">Data pengguna masih kosong.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->count() > 0 && method_exists($users, 'links'))
    <div style="padding: 16px 24px; border-top: 1px solid var(--border);">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection