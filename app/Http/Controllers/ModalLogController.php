<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Models\ModalLog;

class ModalLogController extends Controller
{
    public function index()
    {
        $logs = ModalLog::latest()->get();

        $totalMasuk = ModalLog::where('tipe', 'masuk')->sum('jumlah');
        $totalKeluar = ModalLog::where('tipe', 'keluar')->sum('jumlah');
        $saldo = $totalMasuk - $totalKeluar;

        return view('admin.modal_log.index', compact('logs', 'totalMasuk', 'totalKeluar', 'saldo'));
    }

    // Jika ingin tambah log manual (opsional, bisa di-nonaktifkan juga)
    public function create()
    {
        return view('admin.modal_log.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipe' => 'required|in:masuk,keluar',
            'jumlah' => 'required|numeric|min:1000',
            'sumber' => 'required|string|max:255',
        ]);

        ModalLog::create($request->only('tipe', 'jumlah', 'sumber'));

        return redirect()->route('modal_log.index')->with('success', 'Log modal berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        $log = ModalLog::findOrFail($id);
        $log->delete();

        return redirect()->route('modal_log.index')->with('success', 'Log modal berhasil dihapus.');
    }
}
