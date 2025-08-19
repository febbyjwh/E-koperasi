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
            $jumlahTransaksi = rand(2, 5); // jumlah transaksi random per anggota

            for ($i = 0; $i < $jumlahTransaksi; $i++) {
                // Kalau saldo kosong, otomatis masuk
                $isMasuk = $total <= 0 || rand(0, 1) === 1;

                if ($isMasuk) {
                    $masuk  = rand(50000, 200000); // setor antara 50rb - 200rb
                    $keluar = 0;
                    $total += $masuk;
                } else {
                    // keluar max saldo saat ini (biar tidak minus)
                    $keluar = rand(10000, min($total, 100000));
                    $masuk  = 0;
                    $total -= $keluar;

                    // antisipasi jika tetap minus
                    if ($total < 0) {
                        $total = 0;
                    }
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

        echo "✅ Tabungan Manasuka dummy berhasil dibuat tanpa saldo minus.\n";
    }
}
