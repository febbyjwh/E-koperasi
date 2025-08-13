<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\TabManasuka;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class TabunganManasukaSeeder extends Seeder
{
    public function run(): void
    {
        $anggotaList = User::where('role', 'anggota')->get();

        foreach ($anggotaList as $anggota) {
            $total = 0;
            $jumlahTransaksi = rand(2, 5);

            for ($i = 0; $i < $jumlahTransaksi; $i++) {
                // Tentukan jenis transaksi: true = masuk, false = keluar
                $isMasuk = $total <= 0 || rand(0, 1) === 1;
                // Jika saldo 0 atau negatif, wajib masuk

                if ($isMasuk) {
                    $masuk = rand(50000, 200000);
                    $keluar = 0;
                    $total += $masuk;
                } else {
                    $keluar = rand(10000, min($total, 100000)); // max 100rb atau saldo
                    $masuk = 0;
                    $total -= $keluar;
                }

                TabManasuka::create([
                    'user_id'        => $anggota->id,
                    'nominal_masuk'  => $masuk,
                    'nominal_keluar' => $keluar,
                    'total'          => $total,
                    'tanggal'        => Carbon::now()->subDays(rand(5, 90)),
                ]);
            }
        }

        echo "Tabungan Manasuka dummy berhasil dibuat.\n";
    }
}
