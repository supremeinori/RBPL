<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pembayaran extends Model
{
    protected $table = 'pembayaran';
    protected $primaryKey = 'id_pembayaran';
    protected $fillable = [
        'id_pemesanan',
        'tanggal_bayar',
        'jenis_pembayaran',
        'metode_pembayaran',
        'nominal',
        'bukti_kesepakatan_harga',
        'bukti_pembayaran',
        'status_verifikasi',
        'id_validator',
        'tanggal_validasi',
        'alasan_penolakan',
    ];

    public function order()
    {
        return $this->belongsTo(order::class, 'id_pemesanan', 'id_pemesanan');
    }

    public function validator()
    {
        return $this->belongsTo(User::class, 'id_validator');
    }
}
