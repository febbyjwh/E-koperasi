<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\PengajuanPinjaman;
use App\Models\User;
use App\Models\ModalLog;
use App\Models\Modal;
use App\Models\Angsuran;
use App\Models\PelunasanPinjaman;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class PengajuanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Data pengajuan dipisah berdasarkan status
        $pengajuanPending = PengajuanPinjaman::with('user')
            ->where('status', 'pending')
            ->when($search, function ($query, $search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            })
            ->latest()->get();

        $pengajuanDisetujui = PengajuanPinjaman::with('user')
            ->where('status', 'disetujui')
            ->when($search, function ($query, $search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            })
            ->latest()->get();

        $pengajuanDitolak = PengajuanPinjaman::with('user')
            ->where('status', 'ditolak')
            ->when($search, function ($query, $search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            })
            ->latest()->get();

        return view('admin.pengajuan_pinjaman.index', compact(
            'pengajuanPending',
            'pengajuanDisetujui',
            'pengajuanDitolak',
            'search'
        ));
    }

    // Form pengajuan pinjaman (anggota/user)
    public function create()
    {
        $anggota = User::where('role', 'anggota')->get();
        return view('admin.pengajuan_pinjaman.create', compact('anggota'));
    }

    // Simpan pengajuan pinjaman baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'jenis_pinjaman' => 'required|in:barang,kms',
            'jumlah' => 'required|numeric|min:1',
            'lama_angsuran' => 'required|integer|min:1',
            'tujuan' => 'required|string',
        ]);

        $validated['tanggal_pengajuan'] = now();

        // Hitung propisi & jasa
        $jumlah = $validated['jumlah'];
        $tenor = $validated['lama_angsuran'];
        $jenis = $validated['jenis_pinjaman'];

        $propisi = $jumlah * 0.02;
        $totalJasa = 0;

        if ($jenis === 'barang') {
            $jasaFlat = $jumlah * 0.02;
            $totalJasa = $jasaFlat * $tenor;
        } else {
            $pokokBulanan = $jumlah / $tenor;
            $sisaPokok = $jumlah;
            for ($i = 1; $i <= $tenor; $i++) {
                $jasaBulan = $sisaPokok * 0.025;
                $totalJasa += $jasaBulan;
                $sisaPokok -= $pokokBulanan;
            }
        }

        // Set jumlah_harus_dibayar dan jumlah_diterima
        $validated['jumlah_harus_dibayar'] = $jumlah + $totalJasa;
        $validated['jumlah_diterima'] = $jenis === 'barang' ? $jumlah - $propisi : $jumlah;
        $validated['potongan_propisi'] = $propisi;
        $validated['total_jasa'] = $totalJasa;

        $peminjaman = PengajuanPinjaman::create($validated);

        return redirect()->route('pengajuan_pinjaman.index')->with('success', 'Pengajuan berhasil disimpan.');
    }

    // Tampilkan form edit
    public function edit($id)
    {
        $pengajuan = PengajuanPinjaman::findOrFail($id);
        $anggota = User::where('role', 'anggota')->get();
        return view('admin.pengajuan_pinjaman.edit', compact('pengajuan', 'anggota'));
    }

    // Proses update pengajuan
    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'jumlah' => 'required|numeric|min:100000',
            'lama_angsuran' => 'required|integer|min:1|max:20',
            'tujuan' => 'required|string|max:255',
            'tanggal_pengajuan' => 'required|date',
            'jenis_pinjaman' => 'required|in:kms,barang',
        ]);

        $jumlah = $request->jumlah;
        $tenor = $request->lama_angsuran;
        $jenis = $request->jenis_pinjaman;

        $propisi = $jumlah * 0.02;
        $totalJasa = 0;
        $cicilanPertama = 0;

        if ($jenis === 'kms') {
            $pokokBulanan = $jumlah / $tenor;
            $sisaPokok = $jumlah;
            for ($i = 1; $i <= $tenor; $i++) {
                $jasaBulan = $sisaPokok * 0.025;
                $totalJasa += $jasaBulan;
                if ($i === 1) {
                    $cicilanPertama = $pokokBulanan + $jasaBulan;
                }
                $sisaPokok -= $pokokBulanan;
            }
        } else {
            $jasaFlat = $jumlah * 0.02;
            $totalJasa = $jasaFlat * $tenor;
            $cicilanPertama = ($jumlah / $tenor) + $jasaFlat;
        }

        $pengajuan = PengajuanPinjaman::findOrFail($id);
        $pengajuan->update([
            'user_id' => $request->user_id,
            'jumlah' => $jumlah,
            'lama_angsuran' => $tenor,
            'tujuan' => $request->tujuan,
            'tanggal_pengajuan' => $request->tanggal_pengajuan,
            'jenis_pinjaman' => $jenis,
            'potongan_propisi' => $propisi,
            'total_jasa' => $totalJasa,
            'cicilan_per_bulan' => $cicilanPertama,
        ]);

        return redirect()->route('pengajuan_pinjaman.index')
            ->with('success', 'Pengajuan berhasil diperbarui.');
    }

    // Hapus pengajuan
    public function destroy($id)
    {
        $pengajuan = PengajuanPinjaman::findOrFail($id);
        $pengajuan->delete();

        return redirect()->route('pengajuan_pinjaman.index')
            ->with('success', 'Pengajuan berhasil dihapus.');
    }

    // Konfirmasi pengajuan (admin)
    public function konfirmasi(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
        ]);

        $pengajuan = PengajuanPinjaman::findOrFail($id);
        $pengajuan->status = $request->status;
        $pengajuan->save();

        $this->generateAngsuran($pengajuan, $pengajuan->user_id, $pengajuan->jumlah, $pengajuan->lama_angsuran);

        // Jika pengajuan disetujui, kurangi modal dan log
        if ($request->status === 'disetujui') {
            // Catat ke modal_logs
            ModalLog::create([
                'tipe' => 'keluar',
                'jumlah' => $pengajuan->jumlah,
                'sumber' => 'Pinjaman untuk ' . $pengajuan->user->name,
            ]);

            // Catat ke modals (supaya tampil di modal utama)
            Modal::create([
                'tanggal' => now(),
                'jumlah' => $pengajuan->jumlah,
                'keterangan' => 'Pengeluaran untuk pinjaman ' . $pengajuan->user->name,
                'sumber' => 'pinjaman',
                'status' => 'keluar', // pastikan validasi `status` menerima 'keluar'
                'user_id' => auth()->id(),
            ]);
        }

        return redirect()->back()->with('success', 'Pengajuan berhasil dikonfirmasi.');
    }

    public function invoice($id)
    {
        $pinjaman = PengajuanPinjaman::with('user')->findOrFail($id);

        if (Auth::user()->role !== 'admin' && Auth::id() !== $pinjaman->user_id) {
        abort(403, 'Unauthorized');
        }
        
        $nama = $pinjaman->user->name;
        $tanggal = $pinjaman->created_at;
        $jumlah_pinjaman = $pinjaman->jumlah; 
        $propisi = $pinjaman->potongan_propisi;
        $jenis_pinjaman = $pinjaman->jenis_pinjaman;
        $lama_angsuran = $pinjaman->lama_angsuran;
        $jumlah_diterima = $pinjaman->jumlah_diterima;
        $status_konfirmasi = $pinjaman->status;

        return view('admin.pengajuan_pinjaman.invoice', compact(
            'pinjaman',
            'nama',
            'tanggal',
            'jumlah_pinjaman',
            'propisi',
            'jenis_pinjaman',
            'lama_angsuran',
            'jumlah_diterima',
            'status_konfirmasi'
        ));
    }

    public function exportPdfInvoice($id)
    {
        $pinjaman = PengajuanPinjaman::findOrFail($id);

        $tanggal = now();
        $nama = $pinjaman->user->name;
        $tanggal = $pinjaman->created_at;
        $jumlah_pinjaman = $pinjaman->jumlah; 
        $propisi = $pinjaman->potongan_propisi;
        $jenis_pinjaman = $pinjaman->jenis_pinjaman;
        $lama_angsuran = $pinjaman->lama_angsuran;
        $jumlah_diterima = $pinjaman->jumlah_diterima;
        $status_konfirmasi = $pinjaman->status;

        $pdf = Pdf::loadView('admin.pengajuan_pinjaman.invoicepdf', compact(
            'pinjaman', 'tanggal', 'jumlah_diterima', 'jumlah_pinjaman',
            'propisi', 'nama', 'jenis_pinjaman', 'lama_angsuran', 'status_konfirmasi'
        ))->setPaper('a5', 'portrait');

        return $pdf->download('bukti-pencairan-' . $pinjaman->id . '.pdf');
    }

    public function generateAngsuran($peminjaman, $userId, $jumlah, $lama_angsuran)
    {
        $jumlah = $peminjaman->jumlah;
        $lama = $peminjaman->lama_angsuran;
        $bunga = 2.5;
        $pokok_per_bulan = $jumlah / $lama;
        $total_bunga = 0;

        for ($bulan = 1; $bulan <= $lama; $bulan++) {
            $sisa_pinjaman = $jumlah - $pokok_per_bulan * ($bulan - 1);
            $bunga_bulan_ini = $sisa_pinjaman * ($bunga / 100);
            $total = $pokok_per_bulan + $bunga_bulan_ini;

            $total_bunga += $bunga_bulan_ini;
            $jumlah_dan_total_bunga = $jumlah + $total_bunga;

            $angsuran = Angsuran::create([
                'pinjaman_id' => $peminjaman->id,
                'bulan_ke' => $bulan,
                'pokok' => $pokok_per_bulan,
                'bunga' => $bunga_bulan_ini,
                'total_angsuran' => $total,
                'tanggal_jatuh_tempo' => now()->addMonths($bulan),
            ]);
        }

        PelunasanPinjaman::create([
            'user_id' => $userId,
            'pinjaman_id' => $peminjaman->id,
            'angsuran_id' => $angsuran->id,
            'jumlah_dibayar' => 0,
            'sisa_pinjaman' => $jumlah_dan_total_bunga,
            'tanggal_bayar' => now(),
            'metode_pembayaran' => 'tunai',
            'status' => 'belum_lunas',
        ]);
    }

    public static function hitungCicilanBulanan($pengajuan)
    {
        $cicilan = [];
        $jumlah = $pengajuan->jumlah;
        $tenor = $pengajuan->lama_angsuran;
        $jenis = $pengajuan->jenis_pinjaman;

        if ($jenis === 'barang') {
            $jasa = $jumlah * 0.02;
            $pokok = $jumlah / $tenor;
            for ($i = 1; $i <= $tenor; $i++) {
                $cicilan[] = $pokok + $jasa;
            }
        } elseif ($jenis === 'kms') {
            $pokok = $jumlah / $tenor;
            $sisaPokok = $jumlah;
            for ($i = 1; $i <= $tenor; $i++) {
                $jasa = $sisaPokok * 0.025;
                $cicilan[] = $pokok + $jasa;
                $sisaPokok -= $pokok;
            }
        }

        return $cicilan;
    }

    public static function hitungJumlahDiterima($pengajuan)
    {
        return $pengajuan->jenis_pinjaman === 'barang'
            ? $pengajuan->jumlah - ($pengajuan->jumlah * 0.02)
            : $pengajuan->jumlah;
    }

    function renderTable($data, $judul, $showKonfirmasi = false) {
        echo "<h3 class='text-md font-semibold text-gray-800 mb-2 mt-6'>$judul</h3>";
        echo '<div class="overflow-x-auto w-full mb-6">';
        echo '<table class="min-w-full text-sm text-left text-gray-500 border rounded-lg">';
        echo '<thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th class="px-6 py-3">No</th>
                    <th class="px-6 py-3">Nama</th>
                    <th class="px-6 py-3">Jenis</th>
                    <th class="px-6 py-3">Jumlah Pinjaman</th>
                    <th class="px-6 py-3">Jumlah Harus Dibayar</th>
                    <th class="px-6 py-3">Jumlah Diterima</th>
                    <th class="px-6 py-3">Tenor</th>
                    <th class="px-6 py-3">Cicilan / Bulan</th>
                    <th class="px-6 py-3">Tujuan</th>
                    <th class="px-6 py-3">Tanggal</th>
                    <th class="px-6 py-3">Status</th>';
        if ($showKonfirmasi) echo '<th class="px-6 py-3">Konfirmasi</th>';
        echo '<th class="px-6 py-3 text-right">Aksi</th>
              </tr>
            </thead><tbody>';

        if ($data->isEmpty()) {
            $colspan = $showKonfirmasi ? 13 : 12;
            echo "<tr><td colspan='{$colspan}' class='px-6 py-4 text-center text-gray-500'>Tidak ada data.</td></tr>";
        } else {
            foreach ($data as $i => $item) {
                $cicilanList = hitungCicilanBulanan($item);
                $jumlahDiterima = hitungJumlahDiterima($item);

                $tooltip = collect($cicilanList)->map(function ($val, $i) {
                    return 'Bulan ' . ($i + 1) . ': Rp ' . number_format($val, 0, ',', '.');
                })->implode("\n");

                $statusColor = match ($item->status) {
                    'pending' => 'bg-yellow-100 text-yellow-800',
                    'disetujui' => 'bg-green-100 text-green-800',
                    'ditolak' => 'bg-red-100 text-red-800',
                    default => 'bg-gray-100 text-gray-800',
                };

                echo '<tr class="bg-white hover:bg-gray-50 border-b">';
                echo '<td class="px-6 py-4 font-medium text-gray-900">' . ($i + 1) . '</td>';
                echo '<td class="px-6 py-4">' . e($item->user->name ?? '-') . '</td>';
                echo '<td class="px-6 py-4 capitalize">' . ($item->jenis_pinjaman === 'barang' ? 'Kredit Barang' : 'Kredit Manasuka (KMS)') . '</td>';
                echo '<td class="px-6 py-4">Rp ' . number_format($item->jumlah, 0, ',', '.') . '</td>';
                echo '<td class="px-6 py-4">Rp ' . number_format(array_sum($cicilanList), 0, ',', '.') . '</td>';
                echo '<td class="px-6 py-4">Rp ' . number_format($jumlahDiterima, 0, ',', '.') . '</td>';
                echo '<td class="px-6 py-4">' . $item->lama_angsuran . ' bulan</td>';
                echo '<td class="px-6 py-4" title="' . e($tooltip) . '">Rp ' . number_format(round(array_sum($cicilanList) / count($cicilanList)), 0, ',', '.') . '</td>';
                echo '<td class="px-6 py-4">' . e($item->tujuan) . '</td>';
                echo '<td class="px-6 py-4">' . \Carbon\Carbon::parse($item->tanggal_pengajuan)->format('d M Y') . '</td>';
                echo '<td class="px-6 py-4 capitalize"><span class="px-2 py-1 text-xs rounded-full font-medium ' . $statusColor . '">' . $item->status . '</span></td>';

                if ($showKonfirmasi) {
                    echo '<td class="px-6 py-4 space-x-2">
                        <form action="' . route('pengajuan_pinjaman.konfirmasi', $item->id) . '" method="POST" class="inline-block">
                            ' . csrf_field() . method_field('PATCH') . '
                            <button name="status" value="disetujui" class="px-2 py-2 rounded hover:bg-green-100 text-xs" title="Setujui">
                                <i class="bx bx-check-circle" style="color:#40ce3b; font-size: 1.2rem"></i>
                            </button>
                            <button name="status" value="ditolak" class="px-2 py-2 rounded hover:bg-red-100 text-xs" title="Tolak">
                                <i class="bx bx-x-circle" style="color:#e91919; font-size: 1.2rem"></i>
                            </button>
                        </form>
                    </td>';
                }

                echo '<td class="px-6 py-4 text-right space-x-2">
                    <a href="' . route('pengajuan_pinjaman.edit', $item->id) . '" class="text-blue-600 hover:underline text-xs">Edit</a>
                    <form action="' . route('pengajuan_pinjaman.destroy', $item->id) . '" method="POST" class="inline-block" onsubmit="return confirm(\'Yakin ingin menghapus pengajuan ini?\')">
                        ' . csrf_field() . method_field('DELETE') . '
                        <button type="submit" class="text-red-600 hover:underline text-xs ml-2">Hapus</button>
                    </form>
                </td>';
                echo '</tr>';
            }
        }

        echo '</tbody></table></div>';
    }

}
