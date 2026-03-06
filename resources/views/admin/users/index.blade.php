@extends('layouts.app')

@section('title', 'Kelola User')
@section('subtitle', 'Daftar pengguna yang memiliki akses ke sistem.')

@section('styles')
<style>
    .action-btns {
        display: flex;
        gap: 8px;
    }
    
    .btn-edit {
        color: var(--subtle);
        text-decoration: none;
        font-size: 13px;
        font-weight: 500;
        transition: color var(--transition);
    }
    .btn-edit:hover { color: var(--white); }

    .btn-delete {
        background: none;
        border: none;
        color: rgba(239,68,68,0.6);
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        padding: 0;
        transition: color var(--transition);
    }
    .btn-delete:hover { color: #fca5a5; }

    .role-badge {
        display: inline-block;
        padding: 2px 8px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        background: var(--mid);
        border: 1px solid var(--border);
        color: var(--subtle);
    }
    
    .role-admin { border-color: rgba(255,255,255,0.2); color: var(--white); }
</style>
@endsection

@section('content')
    <div class="section-card">
        <div class="section-header">
            <span class="section-title">Daftar User</span>
            <a href="{{ route('admin.users.create') }}" class="btn-primary">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width:14px;height:14px;">
                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Tambah User
            </a>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr> 
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th style="width: 120px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr> 
                        <td style="color: var(--muted); font-variant-numeric: tabular-nums;">#{{ $user->id }}</td>
                        <td style="font-weight: 500; color: var(--white);">{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="role-badge {{ $user->role === 'admin' ? 'role-admin' : '' }}">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td>
                            <div class="action-btns">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn-edit">Edit</a>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection