<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\order;

class customer extends Model
{
    protected $table = 'pelanggan'; // pastikan nama tabel sesuai dengan yang ada di database
    protected $fillable = [
        'nama', // ini harus sesuai dengan nama kolom di database ? 
        'alamat',
        'no_telp',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
