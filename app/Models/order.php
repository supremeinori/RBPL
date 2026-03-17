<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\customer;
use App\Models\desain;
class order extends Model
{
    protected $table = 'pemesanan'; // pastikan nama tabel sesuai dengan yang ada di database
    protected $primaryKey = 'id_pemesanan';
    protected $fillable = [
        'nama_pesanan', // ini harus sesuai dengan nama kolom di database ?
        'tanggal_pemesanan',
        'id_pelanggan',
        'status_pemesanan',
        'deskripsi_pemesanan',
        'deadline',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_pelanggan');
    }

    public function desains()
    {
    return $this->hasMany(Desain::class, 'id_pemesanan', 'id_pemesanan');
    }
}

