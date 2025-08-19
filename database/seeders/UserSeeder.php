<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        if (!User::where('email', 'admin@koperasi.com')->exists()) {
            User::create([
                'name' => 'Admin Koperasi',
                'username' => 'admin',
                'email' => 'admin@koperasi.com',
                'no_hp' => '081234567890',
                'alamat' => 'Jl. Koperasi No. 1',
                'role' => 'admin',
                'password' => Hash::make('password'),
            ]);
        }

        if (!User::where('email', 'anggota1@koperasi.com')->exists()) {
            User::create([
                'name' => 'Anggota Satu',
                'username' => 'anggotasatu',
                'email' => 'anggota1@koperasi.com',
                'no_hp' => '081298765432',
                'alamat' => 'Jl. Anggota No. 2',
                'role' => 'anggota',
                'password' => Hash::make('password123'),
            ]);
        }

        // Tambah 28 anggota lagi
        // for ($i = 2; $i <= 30; $i++) {
        //     $email = "anggota{$i}@koperasi.com";

        //     // Hindari duplikat email
        //     if (User::where('email', $email)->exists()) {
        //         continue;
        //     }

        //     User::create([
        //         'name' => "Anggota {$i}",
        //         'username' => "anggota{$i}",
        //         'email' => $email,
        //         'no_hp' => '08' . rand(1000000000, 9999999999),
        //         'alamat' => "Jl. Anggota No. {$i}",
        //         'jenis_kelamin' => $i % 2 == 0 ? 'Perempuan' : 'Laki-laki',
        //         'tanggal_lahir' => now()->subYears(rand(20, 35))->format('Y-m-d'),
        //         'email_verified_at' => now(),
        //         'role' => 'anggota',
        //         'password' => Hash::make('password'),
        //         'remember_token' => Str::random(10),
        //     ]);
        // }
    }
}
