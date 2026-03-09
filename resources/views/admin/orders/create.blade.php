<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Tambah Data Pesanan</title>
</head>
<body>

<a href="/admin/dashboard">DASHBOARD</a>

<h2>Tambah Data Pesanan</h2>

<form action="{{ route('admin.orders.store') }}" method="POST">
@csrf

<div style="display:flex; gap:40px;">

<!-- LEFT SIDE -->
<div style="width:40%;">

<label>Pelanggan :</label><br>

<select id="customerSelect" name="id_pelanggan">
<option value="">Pilih Pelanggan</option>

@foreach($customers as $customer)
<option value="{{ $customer->id_pelanggan }}">
{{ $customer->nama }}
</option>
@endforeach

</select>

<button type="button" onclick="openModal()">+ Tambah Pelanggan</button>

<br><br>

<label>Nama Pesanan :</label><br>
<input type="text" name="nama_pesanan">

<br><br>

<label>Tanggal Pesanan :</label><br>
<input type="date" name="tanggal_pemesanan">

<br><br>

<label>Deadline :</label><br>
<input type="date" name="deadline">

<br><br><br>

<button type="submit">Simpan</button>

</div>


<!-- RIGHT SIDE -->
<div style="width:60%;">

<label>Status Pesanan :</label><br>

<select name="status_pemesanan">
<option>pending</option>
<option>diproses</option>
<option>selesai</option>
</select>

<br><br>

<label>Deskripsi Pesanan :</label><br>

<textarea name="deskripsi_pemesanan" rows="15" cols="50"></textarea>

</div>

</div>

</form>



<!-- POPUP TAMBAH CUSTOMER -->

<div id="customerModal" style="display:none; position:fixed; top:30%; left:40%; background:white; padding:20px; border:1px solid black;">

<h3>Tambah Pelanggan</h3>

<input type="text" id="nama" placeholder="Nama">
<br><br>

<input type="text" id="no_telp" placeholder="No Telp">
<br><br>

<textarea id="alamat" placeholder="Alamat"></textarea>

<br><br>

<button onclick="saveCustomer()">Simpan</button>
<button onclick="closeModal()">Batal</button>

</div>



<script>

function openModal(){
document.getElementById("customerModal").style.display = "block";
}

function closeModal(){
document.getElementById("customerModal").style.display = "none";
}

function saveCustomer(){

fetch("{{ route('admin.customers.store') }}",{

method:"POST",

headers:{
"Content-Type":"application/json",
"X-CSRF-TOKEN":"{{ csrf_token() }}"
},

body:JSON.stringify({

nama:document.getElementById("nama").value,
no_telp:document.getElementById("no_telp").value,
alamat:document.getElementById("alamat").value

})

})
.then(res=>res.json())
.then(data=>{

let select=document.getElementById("customerSelect");

let option=document.createElement("option");

option.value=data.id_pelanggan;
option.text=data.nama;

select.add(option);

select.value=data.id_pelanggan;

closeModal();

});

}

</script>

</body>
</html>