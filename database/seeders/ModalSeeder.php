<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Modal;
use Illuminate\Support\Carbon;

class ModalSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Modal masuk awal
        Modal::create([
            'user_id'    => 1, // ID admin
            'tanggal'    => now()->toDateString(),
            'jumlah'     => 200_000_000,
            'keterangan' => 'Modal awal koperasi',
            'sumber'     => 'investor',
            'status'     => 'masuk',
        ]);

        // 2. Buat 30 data modal keluar total 175jt
        $totalKeluar = 175_000_000;
        $jumlahTransaksi = 30;
        $sisa = $totalKeluar;
        $keluarList = [];

        // Bagi ke 30 bagian acak
        for ($i = 0; $i < $jumlahTransaksi; $i++) {
            $max = $sisa - ($jumlahTransaksi - $i - 1) * 3_000_000;
            $min = 3_000_000;
            $jumlah = $i === $jumlahTransaksi - 1 ? $sisa : rand($min, min(10_000_000, $max));
            $keluarList[] = $jumlah;
            $sisa -= $jumlah;
        }

        // 3. Simpan data modal keluar
        foreach ($keluarList as $i => $jumlah) {
            Modal::create([
                'user_id'    => 1,
                'tanggal'    => Carbon::now()->subDays(rand(1, 60))->toDateString(),
                'jumlah'     => $jumlah,
                'keterangan' => 'Penyaluran pinjaman ke anggota #' . ($i + 1),
                'sumber'     => 'peminjaman',
                'status'     => 'keluar',
            ]);
        }

        echo "Modal seeding selesai. Total modal keluar: Rp " . number_format($totalKeluar, 0, ',', '.') . "\n";
    }
}
