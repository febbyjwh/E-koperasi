<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengajuanPinjaman;
use App\Models\User;
use App\Models\ModalLog;
use App\Models\Modal;
use Illuminate\Support\Facades\Auth;
use App\Models\Angsuran;
use App\Models\PelunasanPinjaman;

class PengajuanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $pengajuan = PengajuanPinjaman::with('user')
            ->when($search, function ($query, $search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->get();

        return view('admin.pengajuan_pinjaman.index', compact('pengajuan', 'search'));
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
        $peminjaman = PengajuanPinjaman::create($validated);

        $this->generateAngsuran($peminjaman, $validated['user_id'], $validated['jumlah'], $validated['lama_angsuran']);

        return redirect()->route('pengajuan_pinjaman.index')->with('success', 'Pengajuan berhasil disimpan.');
    }
    
    public function generateAngsuran($peminjaman, $userId, $jumlah, $lama_angsuran)
    {
        $jumlah = $peminjaman->jumlah;
        $lama = $peminjaman->lama_angsuran;
        $bunga = 2.5;
        $pokok_per_bulan = $jumlah / $lama;

        for ($bulan = 1; $bulan <= $lama; $bulan++) {
            $sisa_pinjaman = $jumlah - $pokok_per_bulan * ($bulan - 1);
            $bunga_bulan_ini = $sisa_pinjaman * ($bunga / 100);
            $total = $pokok_per_bulan + $bunga_bulan_ini;

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
            'tanggal_bayar' => now(),
            'metode_pembayaran' => 'tunai',
            'status' => 'pending',
        ]);
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

}