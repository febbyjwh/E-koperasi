<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TabManasuka;
use App\Models\User;

class TabunganManasukaController extends Controller
{
    public function index(Request $request)
    {
        $query = TabManasuka::with('anggota')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('anggota', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        }

        $tabunganManasuka = $query->get();

        return view('admin.tabungan_manasuka.index', compact('tabunganManasuka'));
    }

    public function create()
    {
        $anggota = User::where('role', 'anggota')->get();
        return view('admin.tabungan_manasuka.create', compact('anggota'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'nominal_masuk' => 'nullable|integer|min:10000',
            'nominal_keluar' => 'nullable|integer|min:0',
            'tanggal' => 'required|date',
        ]);

        $nominalMasuk = $request->nominal_masuk ?? 0;
        $nominalKeluar = $request->nominal_keluar ?? 0;

        // Hitung total saldo sebelumnya
        $totalSebelumnya = TabManasuka::where('user_id', $request->user_id)
            ->sum('nominal_masuk') - TabManasuka::where('user_id', $request->user_id)
            ->sum('nominal_keluar');

        // Validasi saldo mencukupi
        if ($nominalKeluar > $totalSebelumnya) {
            return back()->withErrors(['nominal_keluar' => 'Saldo tidak mencukupi untuk penarikan ini.'])->withInput();
        }

        $total = $totalSebelumnya + $nominalMasuk - $nominalKeluar;

        TabManasuka::create([
            'user_id' => $request->user_id,
            'nominal_masuk' => $nominalMasuk,
            'nominal_keluar' => $nominalKeluar,
            'total' => $total,
            'tanggal' => $request->tanggal,
        ]);

        return redirect()->route('tabungan_manasuka.tabungan_manasuka')
            ->with('pesan', 'Tabungan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $tabungan = TabManasuka::findOrFail($id);
        $anggota = User::where('role', 'anggota')->get();

        return view('admin.tabungan_manasuka.edit', compact('tabungan', 'anggota'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'nominal_masuk' => 'nullable|integer|min:0',
            'nominal_keluar' => 'nullable|integer|min:0',
            'tanggal' => 'required|date',
        ]);

        $tabungan = TabManasuka::findOrFail($id);

        $nominalMasuk = $request->filled('nominal_masuk') ? (int)$request->nominal_masuk : 0;
        $nominalKeluar = $request->nominal_keluar ?? 0;

        $totalSebelumnya = TabManasuka::where('user_id', $request->user_id)
            ->where('id', '!=', $id)
            ->sum('nominal_masuk') - TabManasuka::where('user_id', $request->user_id)
            ->where('id', '!=', $id)
            ->sum('nominal_keluar');

        // Validasi saldo mencukupi
        if ($nominalKeluar > $totalSebelumnya) {
            return back()->withErrors(['nominal_keluar' => 'Saldo tidak mencukupi untuk penarikan.'])
                         ->withInput();
        }

        $total = $totalSebelumnya + $nominalMasuk - $nominalKeluar;

        $tabungan->update([
            'user_id' => $request->user_id,
            'nominal_masuk' => $nominalMasuk,
            'nominal_keluar' => $nominalKeluar,
            'total' => $total,
            'tanggal' => $request->tanggal,
        ]);

        return redirect()->route('tabungan_manasuka.tabungan_manasuka')
            ->with('edit', 'Tabungan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $tabungan = TabManasuka::findOrFail($id);
        $tabungan->delete();

        return redirect()->route('tabungan_manasuka.tabungan_manasuka')
            ->with('hapus', 'Tabungan berhasil dihapus.');
    }
}
