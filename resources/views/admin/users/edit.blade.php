<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
</head>
<body>
    <h2>EDIT USER</h2>
    <h2>EDIT USER</h2>

<form action="{{ route('admin.users.update', $user->id) }}" method="POST">
    @csrf
    @method('PUT')

    <input type="text" name="name" value="{{ old('name', $user->name) }}">
    <input type="email" name="email" value="{{ old('email', $user->email) }}">

    <select name="role">
        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
        <option value="desainer" {{ $user->role == 'desainer' ? 'selected' : '' }}>Desainer</option>
        <option value="akuntan" {{ $user->role == 'akuntan' ? 'selected' : '' }}>Akuntan</option>
    </select>

    <button type="submit">Update</button>
</form>
</body>
</html>