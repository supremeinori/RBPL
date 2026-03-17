<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pesanan</title>
</head>
<body>
<div>
    <h1>Tambah Pesanan</h1>
    <a href="/admin/dashboard">Kembali</a>
    <br><br>

    @if ($errors->any())
        <div style="color: red; border: 1px solid red; padding: 10px; margin-bottom: 20px;">
            <strong>Terjadi Kesalahan:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.orders.store') }}" method="POST">
        @csrf
        
        <div>
            <label>Pelanggan:</label><br>
            <select name="id_pelanggan" required>
                <option value="">-- Pilih Pelanggan --</option>
                @foreach($customers as $customer)
                    <option value="{{ $customer->id_pelanggan }}" {{ old('id_pelanggan') == $customer->id_pelanggan ? 'selected' : '' }}>
                        {{ $customer->nama }}
                    </option>
                @endforeach
            </select>
            @error('id_pelanggan')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>
        <br>

        <div>
            <label>Nama Pesanan / Layanan:</label><br>
            <input type="text" name="nama_pesanan" value="{{ old('nama_pesanan') }}" required>
            @error('nama_pesanan')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>
        <br>

        <div>
            <label>Tanggal Pemesanan:</label><br>
            <input type="date" name="tanggal_pemesanan" value="{{ old('tanggal_pemesanan', date('Y-m-d')) }}" required>
            @error('tanggal_pemesanan')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>
        <br>

        <div>
            <label>Deadline / Estimasi Selesai:</label><br>
            <input type="date" name="deadline" value="{{ old('deadline') }}" required>
            @error('deadline')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>
        <br>

        <div>
            <label>Status Pesanan:</label><br>
            <select name="status_pemesanan" required>
                <option value="pending" {{ old('status_pemesanan') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="diproses" {{ old('status_pemesanan') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                <option value="selesai" {{ old('status_pemesanan') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="dibatalkan" {{ old('status_pemesanan') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
            </select>
            @error('status_pemesanan')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>
        <br>

        <div>
            <label>Deskripsi / Detail Pesanan:</label><br>
            <textarea name="deskripsi_pemesanan" rows="5" cols="40">{{ old('deskripsi_pemesanan') }}</textarea>
            @error('deskripsi_pemesanan')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>
        <br>

        <button type="submit">Simpan Pesanan</button>
    </form>
</div>
</body>
</html>