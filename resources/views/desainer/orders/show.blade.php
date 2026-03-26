<!DOCTYPE html>
<html>
<head>
    <title>Detail Pesanan</title>
</head>
<body>

<h1>Detail Pesanan</h1>

<a href="{{ route('desainer.dashboard') }}">Kembali</a>

<hr>

<h2>{{ $order->nama_pesanan }}</h2>
<p>Deadline: {{ $order->deadline }}</p>

<hr>

@php
    $latest = $order->desains->sortByDesc('draft_ke')->first();
@endphp

{{-- ========================= --}}
{{-- MODE 1: BELUM ADA HASIL --}}
{{-- ========================= --}}
@if(!$latest || !$latest->file_desain)

<h3>Referensi dari Admin</h3>

@if($order->file_referensi)
    <img src="{{ asset('storage/' . $order->file_referensi) }}" width="300">
@else
    <p>Tidak ada referensi</p>
@endif

<h3>Catatan Admin</h3>
<p>{{ $latest->cacatan_admin ?? '-' }}</p>

<hr>

<h3>Upload Draft Pertama</h3>

<form action="{{ route('desainer.orders.upload', $order->id_pemesanan) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file_desain" required>
    <br><br>
    <button type="submit">Upload</button>
</form>

@endif

{{-- ========================= --}}
{{-- MODE 2: SUDAH ADA HASIL --}}
{{-- ========================= --}}
@if($latest && $latest->file_desain)

<h3>Daftar Draft</h3>

<table border="1" cellpadding="5">
    <tr>
        <th>Draft</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>

    @foreach($order->desains->sortByDesc('draft_ke') as $desain)
    <tr @if($desain->id_desain == $latest->id_desain) style="background-color: #d4edda;" @endif>
        
        <td>Draft {{ $desain->draft_ke }}</td>

        <td>
            {{ $desain->status_desain }}
            @if($desain->id_desain == $latest->id_desain)
                (latest)
            @endif
        </td>

        <td>
            {{-- nanti ini ke detail draft --}}
            <a href="#">Lihat</a>
        </td>

    </tr>
    @endforeach
</table>

<hr>

{{-- ========================= --}}
{{-- UPLOAD LOGIC --}}
{{-- ========================= --}}

@if($latest->status_desain == 'setuju')

<p>Desain sudah disetujui (view only)</p>

@elseif($latest->status_desain == 'revisi')

<h3>Tambah Draft Revisi</h3>

<form action="{{ route('desainer.orders.upload', $order->id_pemesanan) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file_desain" required>
    <br><br>
    <button type="submit">Upload Revisi</button>
</form>

@else

<p>Tunggu review admin</p>

@endif

@endif

</body>
</html>