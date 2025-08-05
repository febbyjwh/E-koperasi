<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\PengajuanPinjaman;
use Illuminate\Support\Carbon;

class PeminjamanSeeder extends Seeder
{
    public function run(): void
    {
        $anggota = User::where('role', 'anggota')->get();
        $totalPinjaman = 0;
        $maxTotal = 175_000_000;

        $approvedCount = 0;
        $pendingCount = 0;
        $juliCount = 0;
        $agustusCount = 0;

        $i = 0;
        while ($i < 30) {
            $user = $anggota->random();
            $jumlah = rand(3, 10) * 1_000_000;
            $tenor = rand(3, 18);
            $jenis = ['barang', 'kms'][rand(0, 1)];

            $propisi = $jumlah * 0.02;
            $totalJasa = 0;

            if ($jenis === 'barang') {
                $jasaFlat = $jumlah * 0.02;
                $totalJasa = $jasaFlat * $tenor;
            } else {
                $pokokBulanan = $jumlah / $tenor;
                $sisaPokok = $jumlah;
                for ($j = 1; $j <= $tenor; $j++) {
                    $jasaBulan = $sisaPokok * 0.025;
                    $totalJasa += $jasaBulan;
                    $sisaPokok -= $pokokBulanan;
                }
            }

            $jumlahDiterima = $jenis === 'barang' ? $jumlah - $propisi : $jumlah;
            $jumlahHarusDibayar = $jumlah + $totalJasa;

            // Tentukan tanggal pengajuan
            if ($juliCount < 15) {
                $bulan = 7;
                $juliCount++;
            } else {
                $bulan = 8;
                $agustusCount++;
            }
            $tanggalPengajuan = Carbon::create(2025, $bulan, rand(1, 28));

            // Tentukan status dan cek plafon hanya untuk disetujui
            if ($i >= 28) {
                $status = 'pending';
                $tanggalDikonfirmasi = null;
                $pendingCount++;
            } else {
                if ($totalPinjaman + $jumlah > $maxTotal) {
                    continue; // Skip dan coba jumlah baru
                }

                $status = 'disetujui';
                $tanggalDikonfirmasi = $tanggalPengajuan->copy()->addDays(rand(1, 3));
                $approvedCount++;
                $totalPinjaman += $jumlah;
            }

            PengajuanPinjaman::create([
                'user_id'               => $user->id,
                'jumlah'                => $jumlah,
                'lama_angsuran'         => $tenor,
                'tujuan'                => fake()->sentence(3),
                'jenis_pinjaman'        => $jenis,
                'potongan_propisi'      => $propisi,
                'jumlah_diterima'       => $jumlahDiterima,
                'jumlah_harus_dibayar'  => $jumlahHarusDibayar,
                'total_jasa'            => $totalJasa,
                'cicilan_per_bulan'     => null,
                'tanggal_pengajuan'     => $tanggalPengajuan->toDateString(),
                'tanggal_dikonfirmasi'  => $tanggalDikonfirmasi?->toDateString(),
                'status'                => $status,
            ]);

            $i++;
        }

        // echo "✅ Seeder selesai.\n";
        echo "Disetujui: $approvedCount\n";
        echo "Pending: $pendingCount\n";
        echo "Juli: $juliCount, Agustus: $agustusCount\n";
        echo "Total pinjaman: Rp " . number_format($totalPinjaman, 0, ',', '.') . "\n";
    }
}
