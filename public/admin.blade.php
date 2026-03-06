<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
</head>
<body>
    <form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit">Logout</button>
</form>
    <a href="/admin/users">KELOLA USER</a>
    <a href="/admin/customers">KELOLA CUSTOMER</a>
    <h1>Welcome to the Dashboard Admin</h1>
    hait

    <h1>TABLE PEMESANAN</h1>
    <table border="1">
    <tr>
        <th>ID</th>
        <th>Nama Pesanan</th>
        <th>Pelanggan</th>
        <th>tanggal Pesanan</th>
        <th>Deadline</th>
        <th>Status_Pemesanan</th>     
    </tr>

    @forelse($orders as $order)
<tr>
    <td>{{ $order->id }}</td>
        <td>{{ $order->nama_pesanan }}</td>
        <td>{{ $order->customer->nama }}</td>
        <td>{{ $order->tanggal_pemesanan}}</td>
        <td>{{ $order->deadline }}</td>
        <td>{{ $order->status_pemesanan }}</td>
</tr>
@empty
<tr>
    <td colspan="6" style="text-align:center;">
        Data Pemesanan kosong
    </td>
    <a href="{{ route('admin.orders.create') }}">Tambah Pesanan</a>
</tr>
@endforelse
   



</body>
</html>