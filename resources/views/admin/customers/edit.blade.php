<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
</head>
<body>
    <h2>EDIT customer</h2>
    <a href="{{ route('admin.customers.index') }}">Back</a>
<form action="{{ route('admin.customers.update', $customer->id_pelanggan) }}" method="POST">
    @csrf
    @method('PUT')

    <input type="text" name="nama" value="{{ old('nama', $customer->nama) }}">
    <input type="text" name="alamat" value="{{ old('alamat', $customer->alamat) }}">
    <input type="text" name="no_telp" value="{{ old('no_telp', $customer->no_telp) }}">

    <button type="submit">Update</button>
</form>
</body>
</html>