<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
</head>
<body>
<div>
    <h1>Edit User</h1>
    <a href="{{ route('admin.users.index') }}">Kembali</a>
    <br><br>

    @if ($errors->any())
        <div style="color: red; border: 1px solid red; padding: 10px; margin-bottom: 20px;">
            <strong>Terjadi Kesalahan:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
        @csrf
        @method('PUT')

        <div>
            <label>Nama Lengkap:</label><br>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
        </div>
        <br>

        <div>
            <label>Alamat Email (tidak dapat diubah):</label><br>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" readonly>
        </div>
        <br>

        <div>
            <label>Password Baru (kosongkan jika tidak diubah):</label><br>
            <input type="password" name="password">
        </div>
        <br>

        <div>
            <label>Role Akses:</label><br>
            <select name="role" required>
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="desainer" {{ $user->role == 'desainer' ? 'selected' : '' }}>Desainer</option>
                <option value="akuntan" {{ $user->role == 'akuntan' ? 'selected' : '' }}>Akuntan</option>
            </select>
        </div>
        <br>

        <button type="submit">Simpan Perubahan</button>
    </form>
</div>
</body>
</html>