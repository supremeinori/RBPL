<?php

namespace App\Models;
use App\Models\Order;
use Illuminate\Database\Eloquent\Model;

class Desain extends Model
{
    protected $table = 'desain';
    protected $primaryKey = 'id_desain';
    protected $fillable = [
        // 'id_desain',
        'draft_ke',
        'status_desain',
        'catatan_admin',
        'file_desain',
        'file_referensi',
        'id_pemesanan',
    ];


    public function order()
    {
        return $this->belongsTo(Order::class, 'id_pemesanan', 'id_pemesanan');
    }
}
