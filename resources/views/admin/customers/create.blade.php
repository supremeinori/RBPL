<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <a href="/admin/customers">back</a>
    <!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Tambah Pelanggan</title>
</head>
<body>

<h2>Tambah Pelanggan</h2>

<form action="{{ route('admin.customers.store') }}" method="POST">
@csrf

<br>

<label>Nama :</label><br>
<input type="text" name="nama" required>
<br><br>

<label>No Hp :</label><br>
<input type="text" name="no_telp" required>
<br><br>

<label>Alamat :</label><br>
<textarea name="alamat" rows="4"></textarea>
<br><br>

<button type="submit">Simpan</button>

</form>

</body>
</html>
</body>
</html>