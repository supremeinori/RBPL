<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
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
        return $this->belongsTo(Order::class, 'id_pemesanan', 'id_pemesanan')->withTrashed();
    }

    public function validator()
    {
        return $this->belongsTo(User::class, 'id_validator');
    }
}
