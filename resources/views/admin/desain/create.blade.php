<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Tambah Draft</h1>

<form action="{{ route('admin.desain.store', $order->id_pemesanan) }}" method="POST" enctype="multipart/form-data">
    @csrf

    <label>File Desain</label><br>
    <input type="file" name="file_desain"><br><br>

    <label>Deskripsi</label><br>
    <textarea name="deskripsi_desain"></textarea><br><br>

    <button type="submit">Upload</button>
</form>
</body>
</html>