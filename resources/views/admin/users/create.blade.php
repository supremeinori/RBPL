<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Tambah User</h2>

@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li style="color:red">{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="{{ route('admin.users.store') }}">
    @csrf

    <div>
        <label>Nama</label>
        <input type="text" name="name">
    </div>

    <div>
        <label>Email</label>
        <input type="email" name="email">
    </div>

    <div>
        <label>Password</label>
        <input type="password" name="password">
    </div>

    <div>
        <label>Role</label>
        <select name="role">
            <option value="admin">Admin</option>
            <option value="desainer">Desainer</option>
            <option value="akuntan">Akuntan</option>
        </select>
    </div>

    <button type="submit">Simpan</button>
</form>
</body>
</html>