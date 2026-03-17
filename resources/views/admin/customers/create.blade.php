<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Pelanggan</title>
</head>
<body>

    <div>
        <h1>Tambah Pelanggan</h1>
        <a href="{{ route('admin.customers.index') }}">Kembali</a>

        <form action="{{ route('admin.customers.store') }}" method="POST">
            @csrf
            <div>
                <label>Nama Pelanggan:</label><br>
                <input type="text" name="nama" required autofocus>
            </div>
            <br>
            <div>
                <label>No. Telepon / WhatsApp:</label><br>
                <input type="text" name="no_telp" required>
            </div>
            <br>
            <div>
                <label>Alamat Lengkap:</label><br>
                <textarea name="alamat" rows="4"></textarea>
            </div>
            <br>
            <button type="submit">Simpan Pelanggan</button>
        </form>
    </div>

</body>
</html>