<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Modal;
use App\Models\PengajuanPinjaman;
use Illuminate\Support\Carbon;

class ModalSeeder extends Seeder
{
    public function run(): void
    {
        $modalAwal = 300_000_000;

        // 1. Simpan modal awal
        Modal::create([
            'user_id'    => 1, // ID admin
            'tanggal'    => Carbon::create(2025, 6, 1)->toDateString(),
            'jumlah'     => $modalAwal,
            'keterangan' => 'Modal awal koperasi',
            'sumber'     => 'investor',
            'status'     => 'masuk',
        ]);

        // 2. Ambil semua pinjaman yang disetujui
        $pinjamanDisetujui = PengajuanPinjaman::where('status', 'disetujui')->get();

        $totalKeluar = 0;

        foreach ($pinjamanDisetujui as $pinjaman) {
            Modal::create([
                'user_id'   => 1, // admin
                'tanggal'   => $pinjaman->tanggal_dikonfirmasi ?? now(),
                'jumlah'    => $pinjaman->jumlah ?? 0, // cegah null
                'keterangan' => "Pencairan pinjaman ID #{$pinjaman->id} untuk anggota #{$pinjaman->user_id}",
                'sumber'    => 'peminjaman',
                'status'    => 'keluar',
            ]);

            $totalKeluar += $pinjaman->jumlah_diterima;
        }

        // 3. Hitung saldo akhir
        $saldoAkhir = $modalAwal - $totalKeluar;

        echo "✅ Modal seeding selesai.\n";
        echo "Modal Awal: Rp " . number_format($modalAwal, 0, ',', '.') . "\n";
        echo "Total Modal Keluar (pinjaman disetujui): Rp " . number_format($totalKeluar, 0, ',', '.') . "\n";
        echo "Saldo Modal Akhir: Rp " . number_format($saldoAkhir, 0, ',', '.') . "\n";
    }
}
