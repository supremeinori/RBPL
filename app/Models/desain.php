<?php

namespace App\Models;
use App\Models\order;
use Illuminate\Database\Eloquent\Model;

class desain extends Model
{
    protected $table = 'desain';
    protected $primaryKey = 'id_desain';
    protected $fillable = [
        // 'id_desain',
        'nama_desain',
        'deskripsi_desain',
        'file_desain',
        'id_pemesanan',
    ];

    
public function order()
{
    return $this->belongsTo(Order::class, 'id_pemesanan', 'id_pemesanan');
}
}
