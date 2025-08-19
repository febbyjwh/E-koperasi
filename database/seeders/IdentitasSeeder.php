<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\DataDiri;

class IdentitasSeeder extends Seeder
{
    public function run(): void
    {
        // Cari user anggota spesifik
        $user = User::where('email', 'anggota1@koperasi.com')->first();

        if (!$user) {
            $this->command->info('User anggota1@koperasi.com belum ada. Jalankan UserSeeder terlebih dahulu.');
            return;
        }

        // Cegah duplikat
        if (DataDiri::where('user_id', $user->id)->exists()) {
            $this->command->info('DataDiri untuk anggota ini sudah ada.');
            return;
        }

        DataDiri::create([
            'user_id'               => $user->id,
            'foto_ktp'              => 'ktp/ktp_anggota1.jpg',
            'nik'                   => '1234567890123456',
            'nama_pengguna'         => $user->name,
            'tanggal_lahir'         => '1995-05-15',
            'jenis_kelamin'         => 'L',
            'email'                 => $user->email,
            'no_wa'                 => $user->no_hp,
            'alamat'                => $user->alamat,
            'no_anggota'            => 'ANG-' . str_pad($user->id, 4, '0', STR_PAD_LEFT),
            'nip'                   => '9876543210',
            'jabatan'               => 'Staff',
            'unit_kerja'            => 'Koperasi Unit A',
            'tanggal_mulai_kerja'   => '2018-01-01',
            'status_kepegawaian'    => 'Aktif',
            'tanggal_bergabung'     => '2019-06-01',
            'status_keanggotaan'    => 'Aktif',
            'nama_keluarga'         => 'Budi Santoso',
            'hubungan_keluarga'     => 'Ayah',
            'nomor_telepon_keluarga'=> '081234567890',
            'alamat_keluarga'       => 'Jl. Keluarga No. 1',
            'email_keluarga'        => 'keluarga@example.com',
        ]);

        $this->command->info('DataDiri untuk anggota1@koperasi.com berhasil dibuat.');
    }
}
