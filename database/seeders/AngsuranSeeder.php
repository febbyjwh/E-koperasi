<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PengajuanPinjaman;
use App\Models\Angsuran;
use Carbon\Carbon;

class AngsuranSeeder extends Seeder
{
    /**
     * Jalankan seeder.
     */
    public function run(): void
    {
        // Ambil semua pinjaman yang disetujui
        $pinjamanList = PengajuanPinjaman::where('status', 'disetujui')->get();

        foreach ($pinjamanList as $pinjaman) {
            $jumlahPinjaman = $pinjaman->jumlah;
            $lama = $pinjaman->lama_angsuran; // misal 12 bulan
            $bunga = 0.10; // 10% per tahun → sederhana saja untuk contoh

            // hitung pokok & bunga per bulan
            $pokokPerBulan = $jumlahPinjaman / $lama;
            $bungaPerBulan = ($jumlahPinjaman * $bunga) / $lama;
            $totalPerBulan = $pokokPerBulan + $bungaPerBulan;

            for ($i = 1; $i <= $lama; $i++) {
                // jatuh tempo tiap bulan setelah tanggal konfirmasi
                $jatuhTempo = Carbon::parse($pinjaman->tanggal_dikonfirmasi)->addMonths($i);

                // Random: beberapa angsuran dianggap sudah bayar
                $status = ($i <= rand(1, $lama)) ? 'sudah_bayar' : 'belum_bayar';
                $tanggalBayar = $status == 'sudah_bayar' ? $jatuhTempo->copy()->subDays(rand(0,5)) : null;

                Angsuran::create([
                    'pinjaman_id'        => $pinjaman->id,
                    'bulan_ke'           => $i,
                    'pokok'              => $pokokPerBulan,
                    'bunga'              => $bungaPerBulan,
                    'total_angsuran'     => $totalPerBulan,
                    'tanggal_jatuh_tempo'=> $jatuhTempo,
                    'tanggal_bayar'      => $tanggalBayar,
                    'status'             => $status,
                ]);
            }
        }

        $this->command->info('✅ Angsuran Seeder selesai. Semua cicilan bulanan dibuat.');
    }
}
