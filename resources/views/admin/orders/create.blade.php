<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Tambah Data Pesanan</title>
</head>
<body>
 <a href="/admin/dashboard">DASHBOARD</a>
<h2>Tambah Data Pesanan</h2>

<form action="#" method="POST">

<div style="display:flex; gap:40px;">

<!-- LEFT SIDE -->
<div style="width:40%;">

<label>Pelanggan :</label><br>

<select name="id_pelanggan">
<option>Pilih Pelanggan</option>
<option>Andi</option>
<option>Budi</option>
<option>Siti</option>
</select>

<br><br>
<a href="{{ route('admin.customers.create') }}">+ Tambah Pelanggan</a>
</form>

<br><br>

<label>Nama Pesanan :</label><br>
<input type="text" name="nama_pesanan">

<br><br>

<label>Tanggal Pesanan :</label><br>
<input type="date" name="tanggal_pesanan">

<br><br>

<label>Deadline :</label><br>
<input type="date" name="deadline">

<br><br><br>

<button type="submit">Simpan</button>

</div>


<!-- RIGHT SIDE -->
<div style="width:60%;">

<label>Status Pesanan :</label><br>

<select name="status_pesanan">
<option>Dicatat</option>
<option>Diproses</option>
<option>Selesai</option>
</select>

<br><br>

<label>Deskripsi Pesanan :</label><br>

<textarea name="deskripsi_pesanan" rows="15" cols="50"></textarea>

</div>

</div>

</form>

</body>
</html>