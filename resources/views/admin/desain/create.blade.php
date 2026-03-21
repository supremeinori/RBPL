<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Tambah Draft</h1>
    <a href="{{ route('admin.orders.show', $order->id_pemesanan) }}">Kembali</a>
    <br><br>
<form action="{{ route('admin.desain.store', $order->id_pemesanan) }}" method="POST" enctype="multipart/form-data">
    @csrf

    <label>Referensi</label><br>
    <input type="file" name="file_referensi"><br><br>

    <label>Catatan untuk desainer</label><br>
    <textarea name="catatan_admin"></textarea><br><br>


    <button type="submit">Simpan Draft</button>

    @if ($errors->any())
    <div>
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

</form>
</body>
</html>