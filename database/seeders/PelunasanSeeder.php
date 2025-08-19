<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PengajuanPinjaman;
use App\Models\Angsuran;
use App\Models\PelunasanPinjaman;
use Carbon\Carbon;

class PelunasanSeeder extends Seeder
{
    public function run(): void
    {
        $pinjamanList = PengajuanPinjaman::where('status', 'disetujui')->get();

        foreach ($pinjamanList as $pinjaman) {
            $dibayar = Angsuran::where('pinjaman_id', $pinjaman->id)
                ->where('status', 'sudah_bayar')
                ->sum('total_angsuran');

            $sisa = $pinjaman->jumlah - $dibayar;

            PelunasanPinjaman::create([
                'user_id'             => $pinjaman->user_id,
                'pinjaman_id'         => $pinjaman->id,
                'jumlah_dibayar'      => $dibayar,
                'sisa_pinjaman'       => $sisa,
                'tanggal_pengajuan'   => $pinjaman->tanggal_pengajuan,
                'tanggal_dikonfirmasi'=> $pinjaman->tanggal_dikonfirmasi,
                'tanggal_bayar'       => now(),
                'tengat'              => $pinjaman->tanggal_dikonfirmasi 
                                            ? Carbon::parse($pinjaman->tanggal_dikonfirmasi)->addMonths($pinjaman->lama_angsuran) 
                                            : null,
                'metode_pembayaran'   => 'tunai',
                'admin_id'            => 1,
                'keterangan'          => 'Pelunasan otomatis via seeder',
                'status'              => $sisa <= 0 ? 'lunas' : 'belum_lunas',
            ]);
        }

        $this->command->info('✅ Pelunasan Seeder selesai.');
    }
}
