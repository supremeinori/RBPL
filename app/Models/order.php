<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\customer;

class order extends Model
{
    protected $table = 'pemesanan'; // pastikan nama tabel sesuai dengan yang ada di database
    protected $fillable = [
        'nama_pesanan', // ini harus sesuai dengan nama kolom di database ?
        'tanggal_pemesanan',
        // 'customer_id',
        'status_pemesanan',
        'deskripsi_pesanan',
        'deadline',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_pelanggan');
    }
}

