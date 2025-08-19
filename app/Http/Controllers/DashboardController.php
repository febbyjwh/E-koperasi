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
        // Statistik anggota
        $jumlahAnggota = User::where('role', 'anggota')->count();

        // Statistik tabungan
        $totalTabunganWajib = TabWajib::sum('total'); // total tabungan wajib
        $totalTabunganManasuka = TabManasuka::sum('total'); // total tabungan manasuka
        $totalTabungan = $totalTabunganWajib + $totalTabunganManasuka;

        // Jumlah pinjaman per jenis
        $pinjamanBarang = PengajuanPinjaman::where('jenis_pinjaman', 'barang')->count();
        $pinjamanManasuka = PengajuanPinjaman::where('jenis_pinjaman', 'kms')->count();

        // Statistik pinjaman
        $pinjamanAktif = PelunasanPinjaman::where('status', '!=', 'lunas')->sum('sisa_pinjaman');
        $cicilanMasuk = Angsuran::where('status', 'sudah_bayar')->sum('total_angsuran');

        // Data grafik pengajuan pinjaman per bulan (12 bulan terakhir)
        $pengajuanPerBulan = PengajuanPinjaman::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as bulan, COUNT(*) as jumlah')
            ->where('created_at', '>=', now()->subMonths(11)->startOfMonth())
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        // Data untuk tabel pinjaman (nama, nominal, status)
        $pengajuan = PengajuanPinjaman::with('user') // ambil relasi user
            ->select('id', 'user_id', 'jumlah', 'status') // ambil field yang diperlukan
            ->get();

        return view('dashboard', compact(
            'jumlahAnggota',
            'totalTabungan',
            'pinjamanAktif',
            'cicilanMasuk',
            'pengajuanPerBulan',
            'totalTabunganWajib',
            'totalTabunganManasuka',
            'pinjamanBarang',
            'pinjamanManasuka',
            'pengajuan'
        ));
    }
}
