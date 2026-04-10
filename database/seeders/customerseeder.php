<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class customerseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       customer::create([
        'nama' => 'Sheefa Indri',
        'no_telp' => '081234567890',
        'alamat' => 'Jl. Merdeka No. 123, Jakarta',
    ]);

    customer::create([
        'nama' => 'Dryzandra Putri',
        'no_telp' => '081234567890',
        'alamat' => 'Jl. Sudirman No. 456, Bandung',
    ]);

    customer::create([
        'nama' => 'Rizky Pratama',
        'no_telp' => '081234567890',
        'alamat' => 'Jl. Gatot Subroto No. 789, Surabaya',
    ]);
    
    }
}
