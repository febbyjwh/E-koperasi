<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PengajuanPinjaman;
use App\Models\Modal;
use Faker\Factory as Faker;
use Illuminate\Support\Carbon;

class PeminjamanSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $anggotaIds = range(2, 10); // contoh user anggota mulai dari id 2
        $totalPinjaman = 20;

        foreach (range(1, $totalPinjaman) as $i) {
            $userId = $anggotaIds[array_rand($anggotaIds)];
            $jumlah = rand(5_000_000, 20_000_000);
            $lama = [6, 12, 24][array_rand([6, 12, 24])];
            $jenis = rand(0, 1) ? 'barang' : 'kms';

            // 3 data pending, sisanya disetujui
            $status = $i <= 3 ? 'pending' : 'disetujui';

            $tanggalPengajuan   = Carbon::now()->subDays(rand(10, 90));
            $tanggalKonfirmasi  = $status === 'disetujui'
                ? $tanggalPengajuan->copy()->addDays(rand(1, 5))
                : null;

            $pinjaman = PengajuanPinjaman::create([
                'user_id'   => $userId,
                'jumlah'    => $faker->numberBetween(1000000, 20000000), // wajib angka
                'lama_angsuran' => $faker->randomElement([6, 12, 24]),
                'jenis_pinjaman' => 'kms',
                'tujuan'    => $faker->sentence(3),
                'status'    => 'disetujui',
                'tanggal_pengajuan' => now()->subDays(rand(1, 30)),
                'tanggal_dikonfirmasi' => now(),
            ]);

            // kalau status disetujui → kurangi modal
            if ($status === 'disetujui') {
                Modal::create([
                    'user_id'    => 1, // admin
                    'tanggal'    => $tanggalKonfirmasi,
                    'jumlah'     => $jumlah,
                    'keterangan' => "Penyaluran pinjaman ID #{$pinjaman->id} ke anggota #{$userId}",
                    'sumber'     => 'peminjaman',
                    'status'     => 'keluar',
                ]);
            }
        }

        echo "✅ Seeder Pengajuan Pinjaman selesai. (Disetujui otomatis kurangi modal)\n";
    }
}
