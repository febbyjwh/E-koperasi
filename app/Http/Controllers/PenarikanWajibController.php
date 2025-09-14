<?php

namespace App\Http\Controllers;

use App\Models\PenarikanWajib;
use App\Models\TabWajib;
use Illuminate\Http\Request;

class PenarikanWajibController extends Controller
{
    /**
     * Tarik seluruh tabungan wajib seorang anggota
     */
    public function withdraw($userId)
    {
        // Ambil semua tabungan wajib anggota
        $tabungan = TabWajib::where('user_id', $userId)->get();

        if ($tabungan->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada tabungan untuk ditarik.');
        }

        // Total tabungan
        $totalSaldo = $tabungan->sum('nominal');

        // Cek apakah sudah pernah tarik hari ini
        $exists = PenarikanWajib::where('user_id', $userId)
            ->whereDate('tanggal_penarikan', now()->toDateString())
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Tabungan sudah ditarik hari ini.');
        }

        // Simpan ke riwayat
        PenarikanWajib::create([
            'user_id' => $userId,
            'total_ditarik' => $totalSaldo,
            'tanggal_penarikan' => now(),
            'keterangan' => 'Pencairan tabungan wajib',
        ]);

        // Hapus tabungan wajib anggota
        TabWajib::where('user_id', $userId)->delete();

        return redirect()->back()->with('success', 'Tabungan berhasil ditarik semua.');
    }

    /**
     * Tampilkan halaman riwayat penarikan
     */
    public function riwayat()
    {
        // Ambil riwayat dengan relasi anggota
        $riwayat = PenarikanWajib::with('anggota')
            ->orderBy('tanggal_penarikan', 'desc')
            ->paginate(10);

        return view('admin.tabungan_wajib.riwayat', compact('riwayat'));
    }

    /**
     * (Opsional) Bisa tambahkan fungsi index untuk daftar tabungan wajib per anggota
     */
    public function index()
    {
        // Ambil semua tabungan wajib, digroup per anggota
        $setoranWajib = TabWajib::with('anggota')->orderBy('tanggal', 'desc')->paginate(10);

        return view('admin.tabungan_wajib.index', compact('setoranWajib'));
    }
}
