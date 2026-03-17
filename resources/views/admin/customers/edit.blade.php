<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Pelanggan</title>
</head>
<body>

    <div>
        <h1>Edit Pelanggan</h1>
        <a href="{{ route('admin.customers.index') }}">Kembali</a>

        <form action="{{ route('admin.customers.update', $customer->id_pelanggan) }}" method="POST">
            @csrf
            @method('PUT')

            <div>
                <label>Nama Pelanggan:</label><br>
                <input type="text" name="nama" value="{{ old('nama', $customer->nama) }}" required>
            </div>
            <br>
            <div>
                <label>No. Telepon / WhatsApp:</label><br>
                <input type="text" name="no_telp" value="{{ old('no_telp', $customer->no_telp) }}" required>
            </div>
            <br>
            <div>
                <label>Alamat Lengkap:</label><br>
                <textarea name="alamat" rows="4">{{ old('alamat', $customer->alamat) }}</textarea>
            </div>
            <br>
            <button type="submit">Simpan Perubahan</button>
        </form>
    </div>

</body>
</html>