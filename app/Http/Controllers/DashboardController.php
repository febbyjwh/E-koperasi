<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TabWajib;
use App\Models\TabManasuka;
use App\Models\PelunasanPinjaman;
use App\Models\Angsuran;
use App\Models\PengajuanPinjaman;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahAnggota = User::where('role', 'anggota')->count();

        $totalTabunganWajib = TabWajib::sum('nominal');
        $totalTabunganManasuka = TabManasuka::sum('nominal_masuk') - TabManasuka::sum('nominal_keluar');
        $totalTabungan = $totalTabunganWajib + $totalTabunganManasuka;

        $pinjamanAktif = PelunasanPinjaman::where('status', '!=', 'lunas')->sum('sisa_pinjaman');
        $cicilanMasuk = Angsuran::where('status', 'sudah_bayar')->sum('total_angsuran');

        // Data grafik pengajuan pinjaman per bulan
        $pengajuanPerBulan = PengajuanPinjaman::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as bulan, COUNT(*) as jumlah')
            ->where('created_at', '>=', now()->subMonths(11)->startOfMonth())
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        return view('dashboard', compact(
            'jumlahAnggota',
            'totalTabungan',
            'pinjamanAktif',
            'cicilanMasuk',
            'pengajuanPerBulan'
        ));
    }
}
