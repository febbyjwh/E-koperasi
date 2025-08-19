<?php

namespace App\Http\Controllers;

use App\Models\Angsuran;
use App\Models\PelunasanPinjaman;
use App\Models\PengajuanPinjaman;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
class PelunasanController extends Controller
{
    public function index(Request $request)
    {
        $query = PelunasanPinjaman::with(['user', 'pinjaman'])
            ->whereHas('pinjaman', function ($q) {
                $q->where('status', 'disetujui');
            });

        if ($search = $request->search) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        }

        $pelunasans = $query->latest()->paginate(10)->withQueryString();
        // dd($pelunasans->pluck('id'));

        foreach ($pelunasans as $item) {
            $pinjaman = $item->pinjaman;

            if ($pinjaman) {
                $jumlah = $pinjaman->jumlah;
                $bunga = $pinjaman->bunga;
                $lama = $pinjaman->lama_angsuran;

                $totalBayar = $jumlah + ($jumlah * $bunga / 100);
                $dibayarSebelumnya = PelunasanPinjaman::where('pinjaman_id', $item->pinjaman_id)
                    ->where('status', 'terverifikasi')
                    ->where('id', '<=', $item->id)
                    ->sum('jumlah_dibayar');

                $item->total_harus_bayar = $totalBayar;
                $item->sisa_cicilan = max($totalBayar - $dibayarSebelumnya, 0);
            } else {
                $item->total_harus_bayar = 0;
                $item->sisa_cicilan = 0;
            }
        }

        return view('admin.pelunasan_anggota.index', compact('pelunasans'));
    }

    public function show($id)
    {
        $user = auth()->user();

        if ($user->role === 'anggota') {
            $pinjamanUser = PelunasanPinjaman::where('id', $id)->where('user_id', $user->id)->first();
            if (!$pinjamanUser) {
                abort(403, 'Akses ditolak.');
            }
        }

        $pelunasans = Angsuran::with('peminjaman')->where('pinjaman_id', $id)->get();
        return view('admin.pelunasan_anggota.show', compact('pelunasans'));
    }

    public function bayar(Request $request, $id)
    {
        // Bersihkan input dari format Rp dan titik
        $jumlahBayar = floatval(str_replace(',', '', $request->jumlah_bayar));
        $jumlahBayar = (int) $jumlahBayar;

        $pinjaman = Angsuran::with('peminjaman')->findOrFail($id);
        $pinjaman->update([
            'status' => 'sudah_bayar',
            'tanggal_bayar' => now(),
        ]);

        $pelunasan = PelunasanPinjaman::where('pinjaman_id', $pinjaman->pinjaman_id)->firstOrFail();
        $jenis = $pinjaman->peminjaman->jenis_pinjaman;

        if ($jenis === 'barang') {
            // dd($pelunasan->jumlah_dibayar, $jumlahBayar);
            $pelunasan->increment('jumlah_dibayar', $jumlahBayar);

            $sisaBaru = max($pelunasan->sisa_pinjaman - $jumlahBayar, 0);
            $pelunasan->update(['sisa_pinjaman' => $sisaBaru]);
        } elseif ($jenis === 'kms') {
            $pelunasan->increment('jumlah_dibayar', $jumlahBayar);

            $sisaBaru = max($pelunasan->sisa_pinjaman - $jumlahBayar, 0);
            $pelunasan->update(['sisa_pinjaman' => $sisaBaru]);
        }

        $redirect = redirect()->route('pelunasan_anggota.show', $pinjaman->pinjaman_id)
            ->with('pesan', 'Pembayaran cicilan berhasil dilakukan.');

        if ($pelunasan->sisa_pinjaman <= 0) {
            $pelunasan->update(['status' => 'lunas']);
            $redirect->with('lunas', 'Pinjaman sudah LUNAS');
        }

        return $redirect;
    }

    private function hitungCicilanBulanan($pinjaman)
    {
        $cicilan = [];
        $jumlah = $pinjaman->jumlah;
        $tenor = $pinjaman->lama_angsuran;
        $jenis = $pinjaman->jenis_pinjaman;

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

    public function hitungTotalPelunasan($pinjaman)
    {
        $jumlah = $pinjaman->jumlah ?? 0;
        $tenor = $pinjaman->lama_angsuran ?? 1;
        $jenis = $pinjaman->jenis_pinjaman ?? 'barang';

        $total = 0;

        if ($jenis === 'barang') {
            $jasa = $jumlah * 0.02;
            $pokok = $jumlah / $tenor;
            $total = ($pokok + $jasa) * $tenor;
        } elseif ($jenis === 'kms') {
            $pokok = $jumlah / $tenor;
            $sisa = $jumlah;
            for ($i = 1; $i <= $tenor; $i++) {
                $jasa = $sisa * 0.025;
                $total += $pokok + $jasa;
                $sisa -= $pokok;
            }
        }

        return $total;
    }

    public function getHistoriPelunasan($pinjaman)
    {
        $totalHarusDibayar = $this->hitungTotalPelunasan($pinjaman);
        $sisa = $totalHarusDibayar;

        $riwayat = [];
        $tenor = $pinjaman->lama_angsuran;
        $jenis = $pinjaman->jenis_pinjaman;
        $jumlah = $pinjaman->jumlah;

        $pelunasanTerverifikasi = $pinjaman->pelunasan
            ->where('status', 'terverifikasi')
            ->sortBy('tanggal_bayar');

        $sisaPokok = $jumlah;
        $pokokBulanan = $jumlah / $tenor;

        foreach ($pelunasanTerverifikasi as $index => $cicilan) {
            // Hitung bunga bulan itu
            if ($jenis === 'barang') {
                $bunga = $jumlah * 0.02; // flat
            } else {
                $bunga = $sisaPokok * 0.025; // menurun
            }

            $totalCicilan = $pokokBulanan + $bunga;
            $sisa -= $cicilan->jumlah_dibayar;
            $sisaPokok -= $pokokBulanan;

            $riwayat[] = [
                'cicilan_ke' => $index + 1,
                'tanggal_bayar' => $cicilan->tanggal_bayar,
                'jumlah_dibayar' => $cicilan->jumlah_dibayar,
                'bunga' => $bunga,
                'sisa_setelah' => max($sisa, 0),
            ];
        }

        return $riwayat;
    }

    public function create()
    {
        $pinjamans = PengajuanPinjaman::where('status', 'disetujui')->get();
        return view('admin.pelunasan_anggota.create', compact('pinjamans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pinjaman_id' => 'required|exists:pengajuan_pinjaman,id',
            'jumlah_dibayar' => 'required|numeric|min:0',
            'metode_pembayaran' => 'nullable|string|max:50',
        ]);

        $pinjaman = PengajuanPinjaman::findOrFail($request->pinjaman_id);

        $jumlahPelunasanSebelumnya = $pinjaman->pelunasan->where('status', 'terverifikasi')->sum('jumlah_dibayar');
        $sisaPokok = max($pinjaman->jumlah - $jumlahPelunasanSebelumnya, 0);

        $cicilanKe = $pinjaman->pelunasan->count() + 1;

        if ($pinjaman->jenis_pinjaman === 'kms') {
            $bunga = $sisaPokok * 0.02;
        } else {
            $bunga = $pinjaman->jumlah * 0.02;
        }

        $pelunasan = new PelunasanPinjaman();
        $pelunasan->pinjaman_id = $pinjaman->id;
        $pelunasan->user_id = auth()->id();
        $pelunasan->jumlah_dibayar = $request->jumlah_dibayar;
        $pelunasan->tanggal_bayar = now();
        $pelunasan->status = 'pending';
        $pelunasan->keterangan = 'Cicilan ke-' . $cicilanKe;
        $pelunasan->bunga = $bunga;
        $pelunasan->sisa_pokok = $sisaPokok;
        $pelunasan->cicilan_ke = $cicilanKe;
        $pelunasan->metode_pembayaran = $request->metode_pembayaran ?? 'Tunai';
        $pelunasan->save();

        return redirect()->back()->with('pesan', 'Pembayaran berhasil');
    }

    public function konfirmasi(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:terverifikasi,ditolak',
        ]);

        $pelunasan = PelunasanPinjaman::findOrFail($id);
        $pelunasan->status = $request->status;
        $pelunasan->admin_id = auth()->id();
        $pelunasan->save();

        return back()->with('success', 'Status pelunasan berhasil diperbarui.');
    }

    public function edit($id)
    {
        $pelunasan = PelunasanPinjaman::with(['user', 'pinjaman'])->findOrFail($id);
        $pinjamans = PengajuanPinjaman::where('status', 'disetujui')->get();
        return view('admin.pelunasan_anggota.edit', compact('pelunasan', 'pinjamans'));
    }

    public function update(Request $request, $id)
    {
        // dd($id, $request->all());
        $request->validate([
            'pinjaman_id' => 'required|exists:pengajuan_pinjaman,id',
            'jumlah_dibayar' => 'required|numeric|min:0',
            'tanggal_bayar' => 'nullable|date',
            'metode_pembayaran' => 'required|string|max:50',
            // 'status' => 'required|in:pending,terverifikasi,ditolak',
            'keterangan' => 'nullable|string',
        ]);

        $pelunasan = PelunasanPinjaman::findOrFail($id);
        $pinjaman = PengajuanPinjaman::findOrFail($request->pinjaman_id);

        $pelunasan->update([
            'pinjaman_id' => $pinjaman->id,
            'user_id' => $pinjaman->user_id,
            'jumlah_dibayar' => $request->jumlah_dibayar,
            'tanggal_bayar' => $request->tanggal_bayar,
            'metode_pembayaran' => $request->metode_pembayaran,
            // 'status' => $request->status,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('pelunasan_anggota.index')
            ->with('edit', 'Data pelunasan berhasil diperbarui.');
    }

    public function invoice($id)
    {
        $pelunasan = Angsuran::with('peminjaman.user')->findOrFail($id);

        // Cek akses
        if (auth()->user()->role !== 'admin') {
            if (!$pelunasan->peminjaman || auth()->id() !== $pelunasan->peminjaman->user_id) {
                abort(403, 'Unauthorized');
            }
        }

        $invoiceId = 'CITA' . str_pad($pelunasan->id, 3, '0', STR_PAD_LEFT) . '-' . \Carbon\Carbon::parse($pelunasan->tanggal_bayar)->format('dmY');
        $tanggal = $pelunasan->tanggal_bayar;
        $nama = optional(optional($pelunasan->peminjaman)->user)->name ?? '-';
        $jenis_kredit = optional($pelunasan->peminjaman)->jenis_pinjaman ?? '-';
        $pokok = $pelunasan->pokok;
        $bunga = $pelunasan->bunga;
        $total_angsuran = $pelunasan->total_angsuran;
        $metode = $pelunasan->metode_pembayaran ?? 'Tunai';
        $keterangan = $pelunasan->keterangan ?? 'Pembayaran angsuran bulan ke-' . $pelunasan->bulan_ke;

        return view('admin.pelunasan_anggota.invoice', compact(
            'pelunasan',
            'invoiceId',
            'tanggal',
            'nama',
            'jenis_kredit',
            'pokok',
            'bunga',
            'total_angsuran',
            'metode',
            'keterangan'
        ));
    }

    public function exportPdfInvoice($id)
    {
        // Ambil data pelunasan dengan relasi peminjaman dan user
        $pelunasan = PelunasanPinjaman::with('pinjaman.user')->findOrFail($id);

        // Generate ID invoice
        $invoiceId = 'CITA' . str_pad($pelunasan->id, 3, '0', STR_PAD_LEFT) . '-' . \Carbon\Carbon::parse($pelunasan->tanggal_bayar)->format('dmY');

        // Data untuk PDF
        $tanggal = $pelunasan->tanggal_bayar;
        $nama = optional(optional($pelunasan->pinjaman)->user)->name ?? '-';
        $jenis_kredit = optional($pelunasan->pinjaman)->jenis_pinjaman ?? '-';
        $pokok = $pelunasan->pokok;
        $bunga = $pelunasan->bunga;
        $total_angsuran = $pelunasan->total_angsuran;
        $metode = $pelunasan->metode_pembayaran ?? 'Tunai';
        $keterangan = $pelunasan->keterangan ?? 'Pembayaran angsuran bulan ke-' . $pelunasan->bulan_ke;

        // Load view invoice PDF
        $pdf = Pdf::loadView('admin.pelunasan_anggota.invoicepdf', compact(
            'pelunasan',
            'invoiceId',
            'tanggal',
            'nama',
            'jenis_kredit',
            'pokok',
            'bunga',
            'total_angsuran',
            'metode',
            'keterangan'
        ))->setPaper('a5', 'portrait');

        return $pdf->download('bukti-pelunasan-' . $pelunasan->id . '.pdf');
    }

    public function bukti($id)
    {
        $pelunasan = PelunasanPinjaman::with('pinjaman.user')->findOrFail($id);

        if (auth()->user()->role !== 'admin') {
            if (!$pelunasan->pinjaman || auth()->id() !== $pelunasan->pinjaman->user_id) {
                abort(403, 'Unauthorized');
            }
        }

        $nama = optional($pelunasan->pinjaman->user)->name ?? '-';
        $jumlahPinjaman = $pelunasan->pinjaman->jumlah ?? 0;
        $jumlahDibayar = $pelunasan->jumlah_dibayar;
        $sisaCicilan = $pelunasan->sisa_pokok;
        $metode = $pelunasan->metode_pembayaran ?? 'Tunai';
        $tanggalPengajuan = $pelunasan->pinjaman->tanggal_pengajuan ?? '-';
        $tanggalDikonfirmasi = $pelunasan->pinjaman->tanggal_dikonfirmasi ?? '-';
        $tanggalBayar = $pelunasan->tanggal_bayar;
        $status = $pelunasan->status;
        $invoiceId = 'CITA' . str_pad($pelunasan->id, 3, '0', STR_PAD_LEFT) . '-' . \Carbon\Carbon::parse($pelunasan->tanggal_bayar)->format('dmY');

        return view('admin.pelunasan_anggota.bukti', compact(
            'pelunasan',
            'invoiceId',
            'nama',
            'jumlahPinjaman',
            'jumlahDibayar',
            'sisaCicilan',
            'metode',
            'tanggalPengajuan',
            'tanggalDikonfirmasi',
            'tanggalBayar',
            'status'
        ));
    }

    public function exportPdfbukti()
    {
        return view('admin.pelunsan_anggota.bukti');
    }

    public function destroy($id)
    {
        $pelunasan = PelunasanPinjaman::findOrFail($id);
        $pelunasan->delete();

        return redirect()->route('pelunasan_anggota.index')
            ->with('hapus', 'Data pelunasan berhasil dihapus.');
    }
}
