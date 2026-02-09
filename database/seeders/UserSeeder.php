<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
{
    \App\Models\User::create([
        'username' => 'admin',
        'nama'     => 'Administrator Utama',
        'email'    => 'admin@gmail.com',
        'password' => \Illuminate\Support\Facades\Hash::make('admin123'),
        'level'    => 'admin',
        'foto'     => 'default.png'
    ]);

    \App\Models\User::create([
        'username' => 'petugas',
        'nama' => 'Petugas Utama',
        'email'    => 'petugas@gmail.com',
        'password' => \Illuminate\Support\Facades\Hash::make('petugas123'),
        'nama'     => 'Petugas Kasir',
        'level'    => 'petugas',
        'foto'     => 'default.jpg'
    ]);
}
}