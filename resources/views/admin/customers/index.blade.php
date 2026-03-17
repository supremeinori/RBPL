<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pelanggan</title>
</head>
<body>
<div>
    <h1>Kelola Pelanggan</h1>
    <a href="/admin/dashboard">Kembali</a>
    <br><br>

    <a href="{{ route('admin.customers.create') }}">Tambah Pelanggan</a>
    <br><br>

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>No Telp</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($customers as $customer)
            <tr>
                <td>#{{ $customer->id_pelanggan }}</td>
                <td>{{ $customer->nama }}</td>
                <td>{{ $customer->alamat }}</td>
                <td>{{ $customer->no_telp }}</td>
                <td>
                    <a href="{{ route('admin.customers.edit', $customer->id_pelanggan) }}">Edit</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5">Data pelanggan masih kosong.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <br>
    @if($customers->count() > 0 && method_exists($customers, 'links'))
    <div>
        {{ $customers->links() }}
    </div>
    @endif
</div>
</body>
</html>