<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengajuanPinjaman;
use App\Models\User;
use App\Models\ModalLog;
use App\Models\Modal;
use Illuminate\Support\Facades\Auth;

class PengajuanController extends Controller
{
    // Tampilkan daftar pengajuan (admin)
    public function index()
    {
        $pengajuan = PengajuanPinjaman::with('user')->latest()->get();
        return view('admin.pengajuan_pinjaman.index', compact('pengajuan'));
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
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'jumlah' => 'required|numeric|min:100000',
            'lama_angsuran' => 'required|integer|min:1',
            'tujuan' => 'required|string|max:255',
        ]);

        PengajuanPinjaman::create([
            'user_id' => $request->user_id,
            'jumlah' => $request->jumlah,
            'lama_angsuran' => $request->lama_angsuran,
            'tujuan' => $request->tujuan,
            'tanggal_pengajuan' => now(),
            'status' => 'pending',
        ]);

        return redirect()->route('pengajuan_pinjaman.index')
                        ->with('success', 'Pengajuan berhasil disimpan.');
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
            'user_id' => 'required|exists:users,id', // ← tambahkan ini!
            'jumlah' => 'required|numeric|min:100000',
            'lama_angsuran' => 'required|integer|min:1',
            'tujuan' => 'required|string|max:255',
            'tanggal_pengajuan' => 'required|date',
        ]);

        $pengajuan = PengajuanPinjaman::findOrFail($id);

        $pengajuan->update([
            'user_id' => $request->user_id,
            'jumlah' => $request->jumlah,
            'lama_angsuran' => $request->lama_angsuran,
            'tujuan' => $request->tujuan,
            'tanggal_pengajuan' => $request->tanggal_pengajuan,
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