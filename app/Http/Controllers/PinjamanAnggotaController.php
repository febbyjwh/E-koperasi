<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PengajuanPinjaman;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PinjamanAnggotaController extends Controller
{
    public function index(){
        $pengajuan = PengajuanPinjaman::where('user_id', Auth::id())
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('anggota.pinjaman_anggota.index', compact('pengajuan'));
    }

    public function create(){
        return view('anggota.pinjaman_anggota.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jumlah' => 'required|numeric|min:1',
            'lama_angsuran' => 'required|integer|min:1|max:20',
            'tujuan' => 'required|string|max:255',
            'jenis_pinjaman' => 'required|in:kms,barang',
        ]);

        $jumlah = $request->jumlah;
        $tenor = $request->lama_angsuran;
        $jenis = $request->jenis_pinjaman;

        $propisi = $jumlah * 0.02;
        $total_jasa = 0;

        if ($jenis === 'barang') {
            // Flat bunga 2% per bulan
            $jasa_flat = $jumlah * 0.02;
            $total_jasa = $jasa_flat * $tenor;
            $jumlah_diterima = $jumlah - $propisi;
        } else if ($jenis === 'kms') {
            // Bunga menurun 2.5% dari sisa pokok
            $pokok_bulanan = $jumlah / $tenor;
            $sisa_pokok = $jumlah;
            for ($i = 1; $i <= $tenor; $i++) {
                $jasa_bulan = $sisa_pokok * 0.025;
                $total_jasa += $jasa_bulan;
                $sisa_pokok -= $pokok_bulanan;
            }
            $jumlah_diterima = $jumlah; // tidak ada potongan propisi
            $propisi = 0;
        }

        $jumlah_harus_dibayar = $jumlah + $total_jasa;
        $cicilan_per_bulan = $jumlah_harus_dibayar / $tenor;

        PengajuanPinjaman::create([
            'user_id' => Auth::id(),
            'jumlah' => $jumlah,
            'lama_angsuran' => $tenor,
            'tujuan' => $request->tujuan,
            'jenis_pinjaman' => $jenis,
            'potongan_propisi' => $propisi,
            'jumlah_diterima' => $jumlah_diterima,
            'total_jasa' => $total_jasa,
            'jumlah_harus_dibayar' => $jumlah_harus_dibayar,
            'cicilan_per_bulan' => $cicilan_per_bulan,
            'tanggal_pengajuan' => Carbon::now()->toDateString(),
            'status' => 'pending',
        ]);

        return redirect()->route('pinjaman_anggota.index')
            ->with('success', 'Pengajuan pinjaman berhasil dikirim.');
    }

}
