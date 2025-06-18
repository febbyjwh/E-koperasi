<?php

namespace App\Http\Controllers;

use App\Models\PelunasanPinjaman;
use App\Models\PengajuanPinjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PelunasanController extends Controller
{
    public function index()
    {
        $pelunasans = \App\Models\PelunasanPinjaman::with('user')
        ->where('status', 'pending')
        ->latest()
        ->get();

        return view('admin.pelunasan_anggota.index', compact('pelunasans'));
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
            'jumlah_dibayar' => 'required|numeric|min:1000',
            'tanggal_bayar' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        $pinjaman = PengajuanPinjaman::findOrFail($request->pinjaman_id);

        PelunasanPinjaman::create([
            'user_id' => $pinjaman->user_id,
            'pinjaman_id' => $pinjaman->id,
            'jumlah_dibayar' => $request->jumlah_dibayar,
            'tanggal_bayar' => $request->tanggal_bayar,
            'metode_pembayaran' => 'tunai',
            'keterangan' => $request->keterangan,
            'status' => 'pending',
            'admin_id' => null,
        ]);

        return redirect()->route('pelunasan_anggota.index')->with('success', 'Pelunasan berhasil diajukan.');
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

        return back()->with('success', 'Status pelunasan diperbarui.');
    }

    public function edit($id)
    {
        $pelunasan = PelunasanPinjaman::with('user')->findOrFail($id);
        return view('admin.pelunasan_anggota.edit', compact('pelunasan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'pinjaman_id' => 'required|integer',
            'jumlah_dibayar' => 'required|numeric|min:0',
            'tanggal_bayar' => 'required|date',
            'status' => 'required|in:pending,terverifikasi,ditolak',
            'keterangan' => 'nullable|string',
        ]);

        $pelunasan = PelunasanPinjaman::findOrFail($id);
        $pelunasan->update($request->only([
            'pinjaman_id',
            'jumlah_dibayar',
            'tanggal_bayar',
            'status',
            'keterangan',
        ]));

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
