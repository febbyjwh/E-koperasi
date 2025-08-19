<?php

namespace App\Http\Controllers;

use App\Exports\ArusKasExport;
use App\Exports\ShuExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        return view('admin.laporan.index');
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

        // Hitung SHU ditahan (sementara ini dari awal tahun hingga sekarang)
        $tahunIni = now()->year;
        $awalTahun = now()->copy()->startOfYear();
        $akhirTahun = now();

        $pendapatan = Angsuran::whereBetween('tanggal_bayar', [$awalTahun, $akhirTahun])
            ->sum('bunga');

        $biaya_operasional = $pendapatan * 0.10;
        $shu_bersih = $pendapatan - $biaya_operasional;

        // SHU Ditahan (dana cadangan 15%)
        $shu_ditahan = $shu_bersih * 0.15;

        // Total Aset dan Modal
        $total_aset = $kas + $piutang;
        $total_modal = $modal_awal + $modal_anggota + $shu_ditahan;

        return view('admin.laporan.neraca', compact(
            'kas',
            'piutang',
            'simpanan',
            'modal_anggota',
            'modal_awal',
            'shu_ditahan',
            'total_aset',
            'total_modal'
        ));
    }


    public function arusKas(Request $request)
    {
        $periode = $request->input('periode', now()->format('Y-m'));
        $periodeCarbon = Carbon::createFromFormat('Y-m', $periode);
        $start = $periodeCarbon->copy()->startOfMonth()->startOfDay();
        $end = $periodeCarbon->copy()->endOfMonth()->endOfDay();

        $kasMasukSebelumnya = TabWajib::where('created_at', '<', $start)->sum('nominal')
            + TabManasuka::where('created_at', '<', $start)->sum('nominal_masuk')
            + PelunasanPinjaman::where('created_at', '<', $start)->sum('jumlah_dibayar')
            + Angsuran::where('tanggal_bayar', '<', $start)->sum('bunga');

        $kasKeluarSebelumnya = TabManasuka::where('created_at', '<', $start)->sum('nominal_keluar')
            + PengajuanPinjaman::where('created_at', '<', $start)->where('status', 'disetujui')->sum('jumlah_diterima');

        $saldoKasAwal = $kasMasukSebelumnya - $kasKeluarSebelumnya;
        $pelunasanPokok = 0;

        PelunasanPinjaman::whereBetween('created_at', [$start, $end])->get()->each(function ($p) use (&$pelunasanPokok, $start, $end) {
            $bunga = Angsuran::where('pinjaman_id', $p->pinjaman_id)
                ->whereBetween('tanggal_bayar', [$start, $end])
                ->sum('bunga');

            $pelunasanPokok += $p->jumlah_dibayar - $bunga;
        });

        $kasMasuk = [
            [
                'keterangan' => 'Setoran Simpanan Wajib',
                'jumlah' => TabWajib::whereBetween('created_at', [$start, $end])->sum('nominal')
            ],
            [
                'keterangan' => 'Setoran Simpanan Sukarela (net)',
                'jumlah' => TabManasuka::whereBetween('created_at', [$start, $end])
                    ->select(DB::raw('SUM(CAST(nominal_masuk AS SIGNED) - CAST(nominal_keluar AS SIGNED)) as total'))
                    ->value('total') ?? 0
            ],
            [
                'keterangan' => 'Pelunasan Pinjaman (Pokok)',
                'jumlah' => $pelunasanPokok,
            ],
            [
                'keterangan' => 'Bunga Pinjaman (SHU)',
                'jumlah' => Angsuran::whereBetween('tanggal_bayar', [$start, $end])->sum('bunga')
            ],
        ];

        $kasKeluar = [
            [
                'keterangan' => 'Pencairan Pinjaman',
                'jumlah' => PengajuanPinjaman::where('status', 'disetujui')
                    ->whereBetween('created_at', [$start, $end])
                    ->sum('jumlah_diterima')
            ],
            // Hanya hitung penarikan sukarela yang
            [
                'keterangan' => 'Penarikan Simpanan Sukarela',
                'jumlah' => 0 // sudah net di kas masuk, bisa dihapus atau ditampilkan 0
            ],
        ];

        $totalKasMasuk = collect($kasMasuk)->sum('jumlah');
        $totalKasKeluar = collect($kasKeluar)->sum('jumlah');
        $kasBersih = $totalKasMasuk - $totalKasKeluar;

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
        $periode = $request->input('periode', now()->format('Y-m'));
        $periodeStart = \Carbon\Carbon::createFromFormat('Y-m', $periode)->startOfMonth();
        $periodeEnd = $periodeStart->copy()->endOfMonth();

        // 1. Hitung pendapatan (bunga pinjaman)
        $pendapatan = Angsuran::whereBetween('tanggal_bayar', [$periodeStart, $periodeEnd])
            ->sum('bunga');

        // 2. Hitung biaya operasional (10% dari pendapatan)
        $biaya_operasional = $pendapatan * 0.10;

        // 3. Hitung SHU bersih
        $shu_bersih = $pendapatan - $biaya_operasional;

        // 4. Bagi SHU sesuai persentase
        $porsi = [
            'jasa_pinjaman' => $shu_bersih * 0.40,
            'jasa_simpanan' => $shu_bersih * 0.35,
            'dana_cadangan' => $shu_bersih * 0.15,
            'dana_sosial'   => $shu_bersih * 0.05,
            'pengurus'      => $shu_bersih * 0.05,
        ];

        return view('admin.laporan.shu', compact(
            'periode',
            'pendapatan',
            'biaya_operasional',
            'shu_bersih',
            'porsi'
        ));
    }

    public function anggota()
    {
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
            'kas',
            'piutang',
            'modal_awal',
            'modal_anggota',
            'shu_ditahan',
            'total_aset',
            'total_modal'
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
            ['Total Aset', '', $total_aset],
            // ['', '', ''],
            ['Modal', 'Modal Awal', $modal_awal],
            ['', 'Modal Anggota', $modal_anggota],
            ['', 'SHU Ditahan', $shu_ditahan],
            ['Total Modal', '', $total_modal],
        ];

        return Excel::download(new NeracaExport($data), 'laporan_neraca.xlsx');
    }

    public function exportExcelArusKas(Request $request)
    {
        $periode = $request->input('periode', now()->format('Y-m'));
        $periodeCarbon = Carbon::createFromFormat('Y-m', $periode)->startOfMonth();
        $periodeAkhir = $periodeCarbon->copy()->endOfMonth();

        // SALDO KAS AWAL
        $kasMasukSebelumnya = TabWajib::where('created_at', '<', $periodeCarbon)->sum('nominal')
            + (TabManasuka::where('created_at', '<', $periodeCarbon)->sum('nominal_masuk')
                - TabManasuka::where('created_at', '<', $periodeCarbon)->sum('nominal_keluar'))
            + (PelunasanPinjaman::where('created_at', '<', $periodeCarbon)->sum('jumlah_dibayar')
                - Angsuran::where('tanggal_bayar', '<', $periodeCarbon)->sum('bunga'))
            + Angsuran::where('tanggal_bayar', '<', $periodeCarbon)->sum('bunga');

        $kasKeluarSebelumnya = PengajuanPinjaman::where('status', 'disetujui')
            ->where('created_at', '<', $periodeCarbon)->sum('jumlah_diterima');

        $saldoKasAwal = $kasMasukSebelumnya - $kasKeluarSebelumnya;

        // KAS MASUK PERIODE
        $kasMasuk = [
            ['Setoran Simpanan Wajib', TabWajib::whereBetween('created_at', [$periodeCarbon, $periodeAkhir])->sum('nominal')],
            [
                'Setoran Simpanan Sukarela (net)',
                TabManasuka::whereBetween('created_at', [$periodeCarbon, $periodeAkhir])->sum('nominal_masuk')
                    - TabManasuka::whereBetween('created_at', [$periodeCarbon, $periodeAkhir])->sum('nominal_keluar')
            ],
            [
                'Pelunasan Pinjaman (Pokok)',
                PelunasanPinjaman::whereBetween('created_at', [$periodeCarbon, $periodeAkhir])->sum('jumlah_dibayar')
                    - Angsuran::whereBetween('tanggal_bayar', [$periodeCarbon, $periodeAkhir])->sum('bunga')
            ],
            ['Bunga Pinjaman (SHU)', Angsuran::whereBetween('tanggal_bayar', [$periodeCarbon, $periodeAkhir])->sum('bunga')],
        ];
        $totalKasMasuk = array_sum(array_column($kasMasuk, 1));

        // KAS KELUAR PERIODE
        $kasKeluar = [
            ['Pencairan Pinjaman', PengajuanPinjaman::where('status', 'disetujui')
                ->whereBetween('created_at', [$periodeCarbon, $periodeAkhir])->sum('jumlah_diterima')],
            // Penarikan Simpanan Sukarela sudah masuk net di kas masuk, bisa tetap dimunculkan kosong
            ['Penarikan Simpanan Sukarela', 0],
        ];
        $totalKasKeluar = array_sum(array_column($kasKeluar, 1));

        // Kenaikan kas bersih
        $kasBersih = $totalKasMasuk - $totalKasKeluar;

        // Saldo kas akhir
        $saldoKas = $saldoKasAwal + $kasBersih;

        $data = [
            ['Kategori', 'Keterangan', 'Jumlah (Rp)'],
            ['Kas Masuk', '', ''],
            ['', 'Setoran Simpanan Wajib', $kasMasuk[0][1]],
            ['', 'Setoran Simpanan Sukarela (net)', $kasMasuk[1][1]],
            ['', 'Pelunasan Pinjaman (Pokok)', $kasMasuk[2][1]],
            ['', 'Bunga Pinjaman (SHU)', $kasMasuk[3][1]],
            ['Total Kas Masuk', '', $totalKasMasuk],
            ['Kas Keluar', '', ''],
            ['', 'Pencairan Pinjaman', $kasKeluar[0][1]],
            ['', 'Penarikan Simpanan Sukarela', $kasKeluar[1][1]],
            ['Total Kas Keluar', '', $totalKasKeluar],
            ['Kenaikan Kas Bersih', '', $kasBersih],
            ['Saldo Kas Awal', '', $saldoKasAwal],
            ['Saldo Kas Akhir', '', $saldoKas],
        ];

        return Excel::download(new ArusKasExport($data), 'laporan_ArusKas_' . $periode . '.xlsx');
    }

    public function exportPdfArusKas(Request $request)
    {
        $periode = $request->input('periode', now()->format('Y-m'));
        $periodeCarbon = Carbon::createFromFormat('Y-m', $periode)->startOfMonth();
        $periodeAkhir = $periodeCarbon->copy()->endOfMonth();

        // SALDO KAS AWAL (net sebelum periode)
        $kasMasukSebelumnya = TabWajib::where('created_at', '<', $periodeCarbon)->sum('nominal')
            + (TabManasuka::where('created_at', '<', $periodeCarbon)->sum('nominal_masuk')
                - TabManasuka::where('created_at', '<', $periodeCarbon)->sum('nominal_keluar'))
            + (PelunasanPinjaman::where('created_at', '<', $periodeCarbon)->sum('jumlah_dibayar')
                - Angsuran::where('tanggal_bayar', '<', $periodeCarbon)->sum('bunga'))
            + Angsuran::where('tanggal_bayar', '<', $periodeCarbon)->sum('bunga');

        $kasKeluarSebelumnya = PengajuanPinjaman::where('status', 'disetujui')
            ->where('created_at', '<', $periodeCarbon)->sum('jumlah_diterima');

        $saldoKasAwal = $kasMasukSebelumnya - $kasKeluarSebelumnya;

        // KAS MASUK PERIODE
        $kasMasuk = collect([
            [
                'keterangan' => 'Setoran Simpanan Wajib',
                'jumlah' => TabWajib::whereBetween('created_at', [$periodeCarbon, $periodeAkhir])->sum('nominal'),
            ],
            [
                'keterangan' => 'Setoran Simpanan Sukarela (net)',
                'jumlah' => TabManasuka::whereBetween('created_at', [$periodeCarbon, $periodeAkhir])->sum('nominal_masuk')
                    - TabManasuka::whereBetween('created_at', [$periodeCarbon, $periodeAkhir])->sum('nominal_keluar'),
            ],
            [
                'keterangan' => 'Pelunasan Pinjaman (Pokok)',
                'jumlah' => PelunasanPinjaman::whereBetween('created_at', [$periodeCarbon, $periodeAkhir])->sum('jumlah_dibayar')
                    - Angsuran::whereBetween('tanggal_bayar', [$periodeCarbon, $periodeAkhir])->sum('bunga'),
            ],
            [
                'keterangan' => 'Bunga Pinjaman (SHU)',
                'jumlah' => Angsuran::whereBetween('tanggal_bayar', [$periodeCarbon, $periodeAkhir])->sum('bunga'),
            ],
        ]);
        $totalKasMasuk = $kasMasuk->sum('jumlah');

        // KAS KELUAR PERIODE
        $kasKeluar = collect([
            [
                'keterangan' => 'Pencairan Pinjaman',
                'jumlah' => PengajuanPinjaman::where('status', 'disetujui')
                    ->whereBetween('created_at', [$periodeCarbon, $periodeAkhir])
                    ->sum('jumlah_diterima'),
            ],
            // Penarikan Simpanan Sukarela sudah masuk net, bisa tetap ditampilkan 0
            [
                'keterangan' => 'Penarikan Simpanan Sukarela',
                'jumlah' => 0,
            ],
        ]);
        $totalKasKeluar = $kasKeluar->sum('jumlah');

        // Kenaikan kas bersih
        $kasBersih = $totalKasMasuk - $totalKasKeluar;

        // Saldo kas akhir
        $saldoKas = $saldoKasAwal + $kasBersih;

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

    public function exportPdfShu(Request $request)
    {
        // Ambil periode dari request atau default bulan ini
        $periode = $request->input('periode', now()->format('Y-m'));
        $periodeStart = \Carbon\Carbon::createFromFormat('Y-m', $periode)->startOfMonth();
        $periodeEnd = $periodeStart->copy()->endOfMonth();

        // 1. Hitung pendapatan (bunga pinjaman) berdasarkan tanggal_bayar
        $pendapatan = Angsuran::whereBetween('tanggal_bayar', [$periodeStart, $periodeEnd])
            ->sum('bunga');

        // 2. Hitung biaya operasional (10% dari pendapatan)
        $biaya_operasional = $pendapatan * 0.10;

        // 3. Hitung SHU bersih
        $shu_bersih = $pendapatan - $biaya_operasional;

        // 4. Bagi SHU sesuai persentase
        $porsi = [
            'jasa_pinjaman' => $shu_bersih * 0.40,
            'jasa_simpanan' => $shu_bersih * 0.35,
            'dana_cadangan' => $shu_bersih * 0.15,
            'dana_sosial'   => $shu_bersih * 0.05,
            'pengurus'      => $shu_bersih * 0.05,
        ];

        // Siapkan data untuk view
        $data = compact('periode', 'pendapatan', 'biaya_operasional', 'shu_bersih', 'porsi');

        // Generate PDF
        $pdf = \PDF::loadView('admin.laporan.shupdf', $data)->setPaper('a4', 'portrait');

        return $pdf->download('laporan_shu_' . $periode . '.pdf');
    }

    public function exportExcelShu(Request $request)
    {
        $periode = $request->input('periode', now()->format('Y-m'));
        $periodeStart = Carbon::createFromFormat('Y-m', $periode)->startOfMonth();
        $periodeEnd = $periodeStart->copy()->endOfMonth();

        $pendapatan = Angsuran::whereBetween('tanggal_bayar', [$periodeStart, $periodeEnd])
            ->sum('bunga');

        $biaya_operasional = $pendapatan * 0.10;

        $shu_bersih = $pendapatan - $biaya_operasional;

        $porsi = [
            'Jasa Pinjaman' => $shu_bersih * 0.40,
            'Jasa Simpanan' => $shu_bersih * 0.35,
            'Dana Cadangan' => $shu_bersih * 0.15,
            'Dana Sosial'   => $shu_bersih * 0.05,
            'Pengurus'      => $shu_bersih * 0.05,
        ];

        $data = [
            ['Keterangan', '', 'Jumlah (Rp)'],
            ['Pendapatan (Bunga Pinjaman)', '', $pendapatan],
            ['Biaya Operasional (10%)', '', '-' . $biaya_operasional],
            ['SHU Bersih', '', $shu_bersih],
            [''],
            ['Pembagian SHU', '', 'Jumlah (Rp)'],
            ['Jasa Pinjaman', '', $porsi['Jasa Pinjaman']],
            ['Jasa Simpanan', '', $porsi['Jasa Simpanan']],
            ['Dana Cadangan', '', $porsi['Dana Cadangan']],
            ['Dana Sosial', '', $porsi['Dana Sosial']],
            ['Pengurus', '', $porsi['Pengurus']],
            ['Total Pembagian SHU', '', $shu_bersih],
        ];
        return Excel::download(new ShuExport($data), 'laporan_shu_' . $periode . '.xlsx');
    }
}
