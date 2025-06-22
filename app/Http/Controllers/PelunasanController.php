<?php

namespace App\Http\Controllers;

use App\Models\Angsuran;
use App\Models\PelunasanPinjaman;
use App\Models\PengajuanPinjaman;
use Illuminate\Http\Request;

class PelunasanController extends Controller
{
    public function index(Request $request)
    {
        $query = PelunasanPinjaman::with(['user', 'pinjaman']);

        if ($search = $request->search) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        }

        $pelunasans = $query->latest()->paginate(10);

        // ====== Tambahkan perhitungan ini ======
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
        $pelunasans = Angsuran::where('pinjaman_id', $id)->get();

            // dd($pelunasans);

        return view('admin.pelunasan_anggota.show', compact('pelunasans'));
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

        $pelunasanTerverifikasi = $pinjaman->pelunasan
            ->where('status', 'terverifikasi')
            ->sortBy('tanggal_bayar');

        foreach ($pelunasanTerverifikasi as $cicilan) {
            $riwayat[] = [
                'tanggal_bayar' => $cicilan->tanggal_bayar,
                'jumlah_dibayar' => $cicilan->jumlah_dibayar,
                'sisa_setelah' => $sisa - $cicilan->jumlah_dibayar,
            ];

            $sisa -= $cicilan->jumlah_dibayar;
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

        return redirect()->route('pelunasan_anggota.index')->with('success', 'Pelunasan berhasil ditambahkan.');
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
        $request->validate([
            'pinjaman_id' => 'required|exists:pengajuan_pinjaman,id',
            'jumlah_dibayar' => 'required|numeric|min:0',
            'tanggal_bayar' => 'required|date',
            'metode_pembayaran' => 'required|string|max:50',
            'status' => 'required|in:pending,terverifikasi,ditolak',
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
            'status' => $request->status,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('pelunasan_anggota.index')
                         ->with('success', 'Data pelunasan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pelunasan = PelunasanPinjaman::findOrFail($id);
        $pelunasan->delete();

        return redirect()->route('pelunasan_anggota.index')
                         ->with('success', 'Data pelunasan berhasil dihapus.');
    }
}
