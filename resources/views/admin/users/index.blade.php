<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>KELOLA USER</h1>
    <a href="/admin/dashboard">DASHBOARD</a>
    <table border=1>
        <tr> 
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Action</th>
            <th>Delete</th>
        </tr>
        @foreach ($users as $user)
         <tr> 
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->role }}</td>
            <td><a href="{{ route('admin.users.edit', $user->id) }}">Edit</a></td>
            <td>
                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach

    </table>
    <a href="{{ route('admin.users.create') }}">Tambah User</a>

</body>
</html>