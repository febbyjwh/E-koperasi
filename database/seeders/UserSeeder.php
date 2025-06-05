<?php

namespace Database\Seeders;

use App\Models\User;
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
            'id' => 1,
            'name' => 'Admin Koperasi',
            'username' => 'admin',
            'email' => 'admin@koperasi.com',
            'no_hp' => '081234567890',
            'alamat' => 'Jl. Koperasi No. 1',
            'role' => 'admin',
            'password' => bcrypt('password'),
        ]);

        User::create([
            'id' => 2,
            'name' => 'Anggota Satu',
            'username' => 'anggotasatu',
            'email' => 'anggota1@koperasi.com',
            'no_hp' => '081298765432',
            'alamat' => 'Jl. Anggota No. 2',
            'role' => 'anggota',
            'password' => bcrypt('password123'),
        ]);
    }
}
