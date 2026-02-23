<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class customer extends Model
{
    protected $table = 'pelanggan'; // pastikan nama tabel sesuai dengan yang ada di database
    protected $fillable = [
        'nama', // ini harus sesuai dengan nama kolom di database ? 
        'alamat',
        'no_telp',
    ];
}
