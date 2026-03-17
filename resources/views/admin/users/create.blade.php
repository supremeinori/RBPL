<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah User</title>
</head>
<body>
<div>
    <h1>Tambah User</h1>
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

    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf

        <div>
            <label>Nama Lengkap:</label><br>
            <input type="text" name="name" value="{{ old('name') }}" required autofocus>
        </div>
        <br>

        <div>
            <label>Alamat Email:</label><br>
            <input type="email" name="email" value="{{ old('email') }}" required>
        </div>
        <br>

        <div>
            <label>Password:</label><br>
            <input type="password" name="password" required>
        </div>
        <br>

        <div>
            <label>Role Akses:</label><br>
            <select name="role" required>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="desainer" {{ old('role') == 'desainer' ? 'selected' : '' }}>Desainer</option>
                <option value="akuntan" {{ old('role') == 'akuntan' ? 'selected' : '' }}>Akuntan</option>
            </select>
        </div>
        <br>

        <button type="submit">Simpan User</button>
    </form>
</div>
</body>
</html>