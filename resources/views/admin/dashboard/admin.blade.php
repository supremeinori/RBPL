<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body>
<div>
    <h1>Dashboard Admin</h1>
    <p>Welcome back! Here's what's happening today.</p>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>

    <hr>
    
    <h2>Menu</h2>
    <ul>
        <li><a href="/admin/users">Kelola User</a></li>
        <li><a href="/admin/customers">Kelola Customer</a></li>
        <li><a href="{{ route('admin.orders.create') }}">Tambah Pesanan</a></li>
    </ul>

    <hr>

    <h2>Statistik</h2>
    <ul>
        <li>Total Pesanan: {{ $orders->count() }}</li>
        <li>Pending: {{ $orders->where('status_pemesanan','pending')->count() }}</li>
        <li>Selesai: {{ $orders->where('status_pemesanan','selesai')->count() }}</li>
        <li>Dibatalkan: {{ $orders->where('status_pemesanan','dibatalkan')->count() }}</li>
    </ul>

    <hr>

    <h2>Tabel Pemesanan</h2>
    <a href="{{ route('admin.orders.create') }}">Tambah Pesanan</a>
    <br><br>

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Pesanan</th>
                <th>Pelanggan</th>
                <th>Tanggal Pesanan</th>
                <th>Deadline</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
            <tr>
                <td>#{{$order->id_pemesanan }}</td>
                <td>{{ $order->nama_pesanan }}</td>
                <td>{{ $order->customer->nama ?? '' }}</td>
                <td>{{ $order->tanggal_pemesanan }}</td>
                <td>{{ $order->deadline }}</td>
                <td>{{ $order->status_pemesanan }}</td>
                <td>
                 <a href="{{ route('admin.orders.show', $order) }}">
                    Lihat
                     </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7">Data pemesanan masih kosong.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <br>
    @if($orders->count() > 0 && method_exists($orders, 'links'))
    <div>
        {{ $orders->links() }}
    </div>
    @endif
</div>
</body>
</html>