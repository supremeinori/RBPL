<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
    
<a href="/admin/dashboard">DASHBOARD</a>
    <h2>Kelola Pelanggan</h2>

<a href="{{ route('admin.customers.create') }}">Tambah Pelanggan</a>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Nama</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Aksi</th>
    </tr>

    @forelse($customers as $customer)
<tr>
    <td>{{ $customer->id_pelanggan }}</td>
        <td>{{ $customer->nama }}</td>
        <td>{{ $customer->alamat }}</td>
    <td>{{ $customer->no_telp }}</td>
    <td>
        <a href="{{ route('admin.customers.edit', $customer->id_pelanggan) }}">Edit</a>
        <!-- <form action="{{ route('admin.customers.destroy', $customer->id_pelanggan) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
        </form> --> <!-- Hapus tombol delete untuk sementara -->
    </td>
</tr>
@empty
<tr>
    <td colspan="4" style="text-align:center;">
        Data pelanggan kosong
    </td>
</tr>
@endforelse
</table>
</body>
</html>