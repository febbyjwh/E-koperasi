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
                $masuk = rand(50000, 200000);
                $keluar = rand(0, $total > 0 ? min($total, 100000) : 0); // tarik max 100rb atau saldo

                $total += $masuk - $keluar;

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
