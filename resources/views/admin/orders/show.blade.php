<h1>Detail Pesanan</h1>
<a href="/admin/dashboard">Kembali</a>
<p><strong>Nama:</strong> {{ $order->nama_pesanan }}</p>

<hr>

<!-- TAB NAVIGATION -->
<ul>
    <li><a href="{{ route('admin.orders.show', [$order, 'tab' => 'informasi']) }}">Informasi</a></li>
    <li><a href="{{ route('admin.orders.show', [$order, 'tab' => 'desain']) }}">Desain</a></li>
    <li><a href="{{ route('admin.orders.show', [$order, 'tab' => 'pembayaran']) }}">Pembayaran</a></li>
</ul>

<hr>

<!-- TAB CONTENT -->
@if($tab === 'informasi')
    <h2>Informasi Pesanan</h2>
    <p>Deskripsi: {{ $order->deskripsi_pemesanan }}</p>
    <p>Deadline: {{ $order->deadline }}</p>
    <p>Status: {{ $order->status_pemesanan }}</p>

@elseif($tab === 'desain')
    <h2>Desain (Draft)</h2>

    <a href="{{ route('admin.desain.create', $order->id_pemesanan) }}">
    Tambah Draft
</a>

    <table border="1">
        <tr>
            <th>Draft Ke</th>
            <th>Status</th>
            <th>Tanggal</th>
            <th>Aksi</th>
        </tr>

        @foreach($order->desains as $desain)
        <tr>
            <td>{{ $desain->draft_ke }}</td>
            <td>{{ $desain->status }}</td>
            <td>{{ $desain->created_at }}</td>
            <td>
                <a href="#">Lihat</a>
            </td>
        </tr>
        @endforeach
    </table>

@elseif($tab === 'pembayaran')
    <h2>Pembayaran</h2>
    <p>Belum diimplementasikan</p>
@endif
