<?php

namespace Database\Seeders;

use App\Models\PelunasanPinjaman;
use App\Models\PengajuanPinjaman;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class PelunasanSeeder extends Seeder
{
    public function run(): void
    {
        $pinjamanList = PengajuanPinjaman::where('status', 'disetujui')->take(30)->get();
        $juliCount = 0;
        $agustusCount = 0;
        $lunasCount = 0;
        $belumLunasCount = 0;

        foreach ($pinjamanList as $index => $pinjaman) {
            // Tentukan bulan
            $bulan = $juliCount < 15 ? 7 : 8;
            if ($bulan === 7) $juliCount++; else $agustusCount++;

            // Tanggal-tanggal acak
            $tanggalPengajuan = Carbon::create(2025, $bulan, rand(1, 15));
            $tanggalDikonfirmasi = $tanggalPengajuan->copy()->addDays(rand(1, 3));
            $tanggalBayar = $tanggalDikonfirmasi->copy()->addDays(rand(1, 7));

            // Status selang-seling
            $status = $index % 2 === 0 ? 'lunas' : 'belum_lunas';
            if ($status === 'lunas') {
                $jumlahDibayar = $pinjaman->jumlah_harus_dibayar;
                $sisa = 0;
                $lunasCount++;
            } else {
                $jumlahDibayar = round($pinjaman->jumlah_harus_dibayar * rand(40, 90) / 100, 2);
                $sisa = $pinjaman->jumlah_harus_dibayar - $jumlahDibayar;
                $belumLunasCount++;
            }

            PelunasanPinjaman::create([
                'user_id'              => $pinjaman->user_id,
                'pinjaman_id'          => $pinjaman->id,
                'jumlah_dibayar'       => $jumlahDibayar,
                'sisa_pinjaman'        => $sisa,
                'tanggal_pengajuan'    => $tanggalPengajuan,
                'tanggal_dikonfirmasi' => $tanggalDikonfirmasi,
                'tanggal_bayar'        => $tanggalBayar,
                'metode_pembayaran'    => 'tunai',
                'admin_id'             => 1, // ganti sesuai admin yang ada
                'keterangan'           => 'Cicilan otomatis dari seeder',
                'status'               => $status,
            ]);
        }

        echo "✅ Seeder cicilan selesai.\n";
        echo "Juli: $juliCount, Agustus: $agustusCount\n";
        echo "Lunas: $lunasCount, Belum Lunas: $belumLunasCount\n";
    }
}
