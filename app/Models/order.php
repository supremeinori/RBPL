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
        'tanggal_pemesanan',
        'id_pelanggan',
        'id_desainer',
        'status_pemesanan',
        'deskripsi_pemesanan',
        'deadline',
        'file_referensi',
        'total_harga',
        'bukti_kesepakatan',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_pelanggan');
    }

    public function designer()
    {
        return $this->belongsTo(User::class, 'id_desainer', 'id');
    }

    public function desains()
    {
        return $this->hasMany(Desain::class, 'id_pemesanan', 'id_pemesanan');
    }

    public function pembayarans()
    {
        return $this->hasMany(pembayaran::class, 'id_pemesanan', 'id_pemesanan');
    }
}

