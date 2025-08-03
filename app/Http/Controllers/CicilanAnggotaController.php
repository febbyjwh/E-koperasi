<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Angsuran;
use App\Models\PelunasanPinjaman;
use App\Models\PengajuanPinjaman;

class CicilanAnggotaController extends Controller
{
    public function index(Request $request)
    {
        $query = PelunasanPinjaman::with(['user', 'pinjaman'])
            ->where('user_id', auth()->id())
            ->whereHas('pinjaman', function ($q) {
                $q->where('status', 'disetujui');
            });

        if ($search = $request->search) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        }

        $pelunasans = $query->latest()->paginate(10);

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

        return view('anggota.cicilan_anggota.index', compact('pelunasans'));
    }
}
