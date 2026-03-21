<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Desainer</title>
</head>
<body>

<h1>Dashboard Desainer</h1>

<hr>

<h2>Daftar Tugas</h2>

<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama Pesanan</th>
            <th>Deadline</th>
            <th>Status</th>
        </tr>
    </thead>

    <tbody>
        @forelse($desains as $desain)
        <tr>
            <td>#{{ $desain->id_pemesanan }}</td>
            <td>{{ $desain->order->nama_pesanan ?? '-' }}</td>
            <td>{{ $desain->order->deadline ?? '-' }}</td>
            <td>{{ $desain->status_desain }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="4">Belum ada tugas</td>
        </tr>
        @endforelse
    </tbody>
</table>

<hr>

<form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit">Logout</button>
</form>

</body>
</html>