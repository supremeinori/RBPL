<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          User::create([
        'name' => 'Admin',
        'email' => 'admin@mail.com',
        'password' => Hash::make('123456'),
        'role' => 'admin',
    ]);

    User::create([
        'name' => 'Desainer',
        'email' => 'desainer@email.com',
        'password' => Hash::make('25506'),
        'role' => 'desainer',
    ]);

    User::create([
        'name' => 'Akuntan',
        'email' => 'akuntan@email.com',
        'password' => Hash::make('11226'),
        'role' => 'akuntan',
    ]);
    }
}
