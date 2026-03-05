<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

class Customer extends Model
{
    protected $table = 'pelanggan';

    protected $fillable = [
        'id_pelanggan',
        'nama',
        'alamat',
        'no_telp',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'id_pelanggan');
    }
}