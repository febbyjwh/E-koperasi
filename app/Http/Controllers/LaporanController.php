<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\NeracaExport;
use App\Models\PelunasanPinjaman;
use App\Models\TabWajib;
use App\Models\TabManasuka;
use App\Models\PengajuanPinjaman;
use App\Models\User;
use App\Models\ModalLog;
use App\Models\Modal;
use App\Models\Angsuran;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
class LaporanController extends Controller
{
    public function index()
    {
        return view ('admin.laporan.index');
    }

    public function neraca()
    {
        $kas = Modal::where('status', 'masuk')->sum('jumlah')
        - Modal::where('status', 'keluar')->sum('jumlah')
        + PelunasanPinjaman::sum('jumlah_dibayar');

        $total_pinjaman = PengajuanPinjaman::where('status', 'disetujui')->sum('jumlah_harus_dibayar');
        $piutang = $total_pinjaman - PelunasanPinjaman::sum('jumlah_dibayar');

        $simpanan_wajib = TabWajib::sum('nominal');
        $simpanan_manasuka = TabManasuka::sum('nominal_masuk') - TabManasuka::sum('nominal_keluar');
        $simpanan = $simpanan_wajib + $simpanan_manasuka;

        $modal_awal = Modal::where('sumber', 'modal_awal')->sum('jumlah');

        $modal_anggota = $simpanan;

        $shu_ditahan = Angsuran::whereMonth('tanggal_bayar', now()->month)
            ->whereYear('tanggal_bayar', now()->year)
            ->sum('bunga');

        $total_aset = $kas + $piutang;

        $total_modal = $modal_awal + $modal_anggota + $shu_ditahan;

        return view('admin.laporan.neraca', compact(
            'kas', 'piutang', 'simpanan', 'modal_anggota', 'modal_awal', 'shu_ditahan',
            'total_aset', 'total_modal'
        ));
    }

    public function arusKas(Request $request)
    {
        // Ambil periode (misal: '2025-07')
        $periode = $request->input('periode', now()->format('Y-m')); // default: bulan ini
        $periodeCarbon = Carbon::createFromFormat('Y-m', $periode)->startOfMonth();

        // Saldo Kas Awal: semua kas masuk - kas keluar SEBELUM periode
        $kasMasukSebelumnya = TabWajib::where('created_at', '<', $periodeCarbon)->sum('nominal')
            + TabManasuka::where('created_at', '<', $periodeCarbon)->sum('nominal_masuk')
            + PelunasanPinjaman::where('created_at', '<', $periodeCarbon)->sum('jumlah_dibayar')
            + Angsuran::where('tanggal_bayar', '<', $periodeCarbon)->sum('bunga');

        $kasKeluarSebelumnya = TabManasuka::where('created_at', '<', $periodeCarbon)->sum('nominal_keluar')
            + PengajuanPinjaman::where('created_at', '<', $periodeCarbon)->where('status', 'disetujui')->sum('jumlah_diterima');

        $saldoKasAwal = $kasMasukSebelumnya - $kasKeluarSebelumnya;

        // Kas Masuk PERIODE INI
        $kasMasuk = [
            [
                'keterangan' => 'Setoran Simpanan Wajib',
                'jumlah' => TabWajib::whereBetween('created_at', [$periodeCarbon, $periodeCarbon->copy()->endOfMonth()])->sum('nominal')
            ],
            [
                'keterangan' => 'Setoran Simpanan Sukarela',
                'jumlah' => TabManasuka::whereBetween('created_at', [$periodeCarbon, $periodeCarbon->copy()->endOfMonth()])->sum('nominal_masuk')
            ],
            [
                'keterangan' => 'Pelunasan Pinjaman',
                'jumlah' => PelunasanPinjaman::whereBetween('created_at', [$periodeCarbon, $periodeCarbon->copy()->endOfMonth()])->sum('jumlah_dibayar')
            ],
            [
                'keterangan' => 'Bunga Pinjaman (SHU)',
                'jumlah' => Angsuran::whereBetween('tanggal_bayar', [$periodeCarbon, $periodeCarbon->copy()->endOfMonth()])->sum('bunga')
            ],
        ];

        // Kas Keluar PERIODE INI
        $kasKeluar = [
            [
                'keterangan' => 'Pencairan Pinjaman',
                'jumlah' => PengajuanPinjaman::where('status', 'disetujui')
                    ->whereBetween('created_at', [$periodeCarbon, $periodeCarbon->copy()->endOfMonth()])
                    ->sum('jumlah_diterima')
            ],
            [
                'keterangan' => 'Penarikan Simpanan Sukarela',
                'jumlah' => TabManasuka::whereBetween('created_at', [$periodeCarbon, $periodeCarbon->copy()->endOfMonth()])
                    ->sum('nominal_keluar')
            ],
        ];

        // Total
        $totalKasMasuk = collect($kasMasuk)->sum('jumlah');
        $totalKasKeluar = collect($kasKeluar)->sum('jumlah');

        // Kenaikan kas bersih = masuk - keluar
        $kasBersih = $totalKasMasuk - $totalKasKeluar;

        // Saldo Kas Akhir
        $saldoKas = $saldoKasAwal + $kasBersih;

        return view('admin.laporan.arus_kas', compact(
            'kasMasuk',
            'kasKeluar',
            'totalKasMasuk',
            'totalKasKeluar',
            'kasBersih',
            'saldoKasAwal',
            'saldoKas',
            'periode'
        ));
    }

    public function laporanSHU(Request $request)
    {
        $periode = $request->input('periode', now()->format('Y-m')); // contoh filter bulan
        $start = Carbon::createFromFormat('Y-m', $periode)->startOfMonth();
        $end = $start->copy()->endOfMonth();

        // Pendapatan
        $jasa_simpan_pinjam = Angsuran::whereBetween('tanggal_bayar', [$start, $end])->sum('bunga');

        $pendapatan_lain = Modal::where('status', 'masuk')
            ->where('sumber', 'pendapatan_lain')
            ->whereBetween('created_at', [$start, $end])
            ->sum('jumlah');

        $penjualan_barang = 0; // default nol, atau ambil dari tabel penjualan jika ada

        $total_pendapatan = $penjualan_barang + $jasa_simpan_pinjam + $pendapatan_lain;

        // Biaya
        $biaya_operasional = Modal::where('status', 'keluar')
            ->where('sumber', 'biaya_operasional')
            ->whereBetween('created_at', [$start, $end])
            ->sum('jumlah');

        $biaya_gaji = Modal::where('status', 'keluar')
            ->where('sumber', 'gaji')
            ->whereBetween('created_at', [$start, $end])
            ->sum('jumlah');

        $biaya_lain = Modal::where('status', 'keluar')
            ->where('sumber', 'biaya_lain')
            ->whereBetween('created_at', [$start, $end])
            ->sum('jumlah');

        $total_biaya = $biaya_operasional + $biaya_gaji + $biaya_lain;

        // SHU
        $shu_sebelum_pajak = $total_pendapatan - $total_biaya;
        $pajak = $shu_sebelum_pajak * 0.10;
        $shu_bersih = $shu_sebelum_pajak - $pajak;

        return view('admin.laporan.shu', compact(
            'penjualan_barang',
            'jasa_simpan_pinjam',
            'pendapatan_lain',
            'total_pendapatan',
            'biaya_operasional',
            'biaya_gaji',
            'biaya_lain',
            'total_biaya',
            'shu_sebelum_pajak',
            'pajak',
            'shu_bersih'
        ));
    }

    public function anggota() {
        $anggota = User::with('tabunganWajib', 'tabunganManasuka')->get();
        return view('laporan.anggota', compact('anggota'));
    }

    public function exportNeracaPdf()
    {
        $kas = Modal::where('status', 'masuk')->sum('jumlah')
            - Modal::where('status', 'keluar')->sum('jumlah')
            + PelunasanPinjaman::sum('jumlah_dibayar');

        $total_pinjaman = PengajuanPinjaman::where('status', 'disetujui')->sum('jumlah_harus_dibayar');
        $piutang = $total_pinjaman - PelunasanPinjaman::sum('jumlah_dibayar');

        $simpanan_wajib = TabWajib::sum('nominal');
        $simpanan_manasuka = TabManasuka::sum('nominal_masuk') - TabManasuka::sum('nominal_keluar');
        $simpanan = $simpanan_wajib + $simpanan_manasuka;

        $modal_awal = Modal::where('sumber', 'modal_awal')->sum('jumlah');
        $modal_anggota = $simpanan;

        $shu_ditahan = Angsuran::whereMonth('tanggal_bayar', now()->month)
            ->whereYear('tanggal_bayar', now()->year)
            ->sum('bunga');

        $total_aset = $kas + $piutang;
        $total_modal = $modal_awal + $modal_anggota + $shu_ditahan;

        $data = compact(
            'kas', 'piutang', 'modal_awal', 'modal_anggota', 'shu_ditahan',
            'total_aset', 'total_modal'
        );

        $tanggal_cetak = Carbon::now()->translatedFormat('d F Y') . ' pukul ' . Carbon::now()->format('H:i') . ' WIB';

        $data['tanggal_cetak'] = $tanggal_cetak;
        $pdf = Pdf::loadView('admin.laporan.neracapdf', $data)->setPaper('a4', 'portrait');
        return $pdf->download('laporan_neraca.pdf');
    }

    public function exportExcel()
    {
        $kas = Modal::where('status', 'masuk')->sum('jumlah')
            - Modal::where('status', 'keluar')->sum('jumlah')
            + PelunasanPinjaman::sum('jumlah_dibayar');

        $total_pinjaman = PengajuanPinjaman::where('status', 'disetujui')->sum('jumlah_harus_dibayar');
        $piutang = $total_pinjaman - PelunasanPinjaman::sum('jumlah_dibayar');

        $simpanan_wajib = TabWajib::sum('nominal');
        $simpanan_manasuka = TabManasuka::sum('nominal_masuk') - TabManasuka::sum('nominal_keluar');
        $simpanan = $simpanan_wajib + $simpanan_manasuka;

        $modal_awal = Modal::where('sumber', 'modal_awal')->sum('jumlah');
        $modal_anggota = $simpanan;

        $shu_ditahan = Angsuran::whereMonth('tanggal_bayar', now()->month)
            ->whereYear('tanggal_bayar', now()->year)
            ->sum('bunga');

        $total_aset = $kas + $piutang;
        $total_modal = $modal_awal + $modal_anggota + $shu_ditahan;

        $data = [
            ['Kategori', 'Keterangan', 'Jumlah (Rp)'],
            ['Aset', 'Kas / Saldo Kas', $kas],
            ['', 'Piutang Anggota', $piutang],
            ['', 'Total Aset', $total_aset],
            ['Modal', 'Modal Awal', $modal_awal],
            ['', 'Modal Anggota', $modal_anggota],
            ['', 'SHU Ditahan', $shu_ditahan],
            ['', 'Total Modal', $total_modal],
        ];

        return Excel::download(new NeracaExport($data), 'laporan_neraca.xlsx');
    }

    public function exportExcelArusKas()
    {
        // Perhitungan neraca dipindah dari export ke sini
        $kas = Modal::where('status', 'masuk')->sum('jumlah')
            - Modal::where('status', 'keluar')->sum('jumlah')
            + PelunasanPinjaman::sum('jumlah_dibayar');

        $total_pinjaman = PengajuanPinjaman::where('status', 'disetujui')->sum('jumlah_harus_dibayar');
        $piutang = $total_pinjaman - PelunasanPinjaman::sum('jumlah_dibayar');

        $simpanan_wajib = TabWajib::sum('nominal');
        $simpanan_manasuka = TabManasuka::sum('nominal_masuk') - TabManasuka::sum('nominal_keluar');
        $simpanan = $simpanan_wajib + $simpanan_manasuka;

        $modal_awal = Modal::where('sumber', 'modal_awal')->sum('jumlah');
        $modal_anggota = $simpanan;

        $shu_ditahan = Angsuran::whereMonth('tanggal_bayar', now()->month)
            ->whereYear('tanggal_bayar', now()->year)
            ->sum('bunga');

        $total_aset = $kas + $piutang;
        $total_modal = $modal_awal + $modal_anggota + $shu_ditahan;

        $data = [
            ['Kategori', 'Keterangan', 'Jumlah (Rp)'],
            ['Aset', 'Kas / Saldo Kas', $kas],
            ['', 'Piutang Anggota', $piutang],
            ['', 'Total Aset', $total_aset],
            ['Modal', 'Modal Awal', $modal_awal],
            ['', 'Modal Anggota', $modal_anggota],
            ['', 'SHU Ditahan', $shu_ditahan],
            ['', 'Total Modal', $total_modal],
        ];

        return Excel::download(new NeracaExport($data), 'laporan_ArusKas.xlsx');
    }
    
    public function exportPdfArusKas(Request $request)
    {
        $periode = $request->input('periode', now()->format('Y-m')); // default bulan ini
        $periodeCarbon = Carbon::createFromFormat('Y-m', $periode)->startOfMonth();
        $periodeAkhir = $periodeCarbon->copy()->endOfMonth();

        // Saldo Kas Awal = total masuk - total keluar sebelum periode
        $kasMasukSebelumnya = TabWajib::where('created_at', '<', $periodeCarbon)->sum('nominal')
            + TabManasuka::where('created_at', '<', $periodeCarbon)->sum('nominal_masuk')
            + PelunasanPinjaman::where('created_at', '<', $periodeCarbon)->sum('jumlah_dibayar')
            + Angsuran::where('tanggal_bayar', '<', $periodeCarbon)->sum('bunga');

        $kasKeluarSebelumnya = TabManasuka::where('created_at', '<', $periodeCarbon)->sum('nominal_keluar')
            + PengajuanPinjaman::where('created_at', '<', $periodeCarbon)
                ->where('status', 'disetujui')->sum('jumlah_diterima');

        $saldoKasAwal = $kasMasukSebelumnya - $kasKeluarSebelumnya;

        // Kas Masuk periode ini
        $kasMasuk = collect([
            [
                'keterangan' => 'Setoran Simpanan Wajib',
                'jumlah' => TabWajib::whereBetween('created_at', [$periodeCarbon, $periodeAkhir])->sum('nominal'),
            ],
            [
                'keterangan' => 'Setoran Simpanan Sukarela',
                'jumlah' => TabManasuka::whereBetween('created_at', [$periodeCarbon, $periodeAkhir])->sum('nominal_masuk'),
            ],
            [
                'keterangan' => 'Pelunasan Pinjaman',
                'jumlah' => PelunasanPinjaman::whereBetween('created_at', [$periodeCarbon, $periodeAkhir])->sum('jumlah_dibayar'),
            ],
            [
                'keterangan' => 'Bunga Pinjaman (SHU)',
                'jumlah' => Angsuran::whereBetween('tanggal_bayar', [$periodeCarbon, $periodeAkhir])->sum('bunga'),
            ],
        ]);

        $totalKasMasuk = $kasMasuk->sum('jumlah');

        // Kas Keluar periode ini
        $kasKeluar = collect([
            [
                'keterangan' => 'Pencairan Pinjaman',
                'jumlah' => PengajuanPinjaman::where('status', 'disetujui')
                    ->whereBetween('created_at', [$periodeCarbon, $periodeAkhir])
                    ->sum('jumlah_diterima'),
            ],
            [
                'keterangan' => 'Penarikan Simpanan Sukarela',
                'jumlah' => TabManasuka::whereBetween('created_at', [$periodeCarbon, $periodeAkhir])
                    ->sum('nominal_keluar'),
            ],
        ]);

        $totalKasKeluar = $kasKeluar->sum('jumlah');

        // Kenaikan kas bersih
        $kasBersih = $totalKasMasuk - $totalKasKeluar;

        // Saldo kas akhir
        $saldoKas = $saldoKasAwal + $kasBersih;

        // PDF Export
        $pdf = Pdf::loadView('admin.laporan.aruskaspdf', [
            'kasMasuk' => $kasMasuk,
            'totalKasMasuk' => $totalKasMasuk,
            'kasKeluar' => $kasKeluar,
            'totalKasKeluar' => $totalKasKeluar,
            'kasBersih' => $kasBersih,
            'saldoKasAwal' => $saldoKasAwal,
            'saldoKas' => $saldoKas,
            'periode' => $periode,
        ])->setPaper('A4', 'portrait');

        return $pdf->download('laporan_arus_kas_' . $periode . '.pdf');
    }

    
}