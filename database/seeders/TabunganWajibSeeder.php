<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TabWajib;
use App\Models\User;
use Illuminate\Support\Carbon;

class TabunganWajibSeeder extends Seeder
{
    public function run(): void
    {
        $anggotaList = User::where('role', 'anggota')->get();
        $jenisList = ['pokok', 'wajib', 'dakem'];

        foreach ($anggotaList as $anggota) {
            $total = 0;

            foreach ($jenisList as $jenis) {
                $nominal = rand(100000, 500000);
                $tanggal = Carbon::now()->subDays(rand(1, 60));

                $total += $nominal;

                TabWajib::create([
                    'user_id' => $anggota->id,
                    'jenis'   => $jenis,
                    'nominal' => $nominal,
                    'total'   => $total,
                    'tanggal' => $tanggal,
                ]);
            }

            echo "✅ Tabungan untuk {$anggota->name} berhasil dibuat. Total: Rp " . number_format($total, 0, ',', '.') . "\n";
        }

        echo "Seeder tabungan wajib selesai.\n";
    }
}
