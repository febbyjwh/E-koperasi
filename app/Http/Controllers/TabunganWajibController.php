<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TabWajib;
use App\Models\User;

class TabunganWajibController extends Controller
{
    public function index(Request $request)
    {
        $query = TabWajib::with('anggota')->latest();

        if ($request->has('search') && $request->search != '') {
            $query->whereHas('anggota', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $setoranWajib = $query->paginate(10)->withQueryString();
        // $setoranWajib = $query->paginate(10)->withQueryString();

        // dd(get_class($setoranWajib));
        return view('admin.tabungan_wajib.index', compact('setoranWajib'));
    }

    public function create()
    {
        $anggota = User::where('role', 'anggota')->get();
        return view('admin.tabungan_wajib.create', compact('anggota'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'jenis' => 'required|in:pokok,wajib,dakem',
            'nominal' => 'required|integer|min:1',
            'tanggal' => 'required|date',
        ]);

        // Hitung total nominal dari user
        $existingTotal = TabWajib::where('user_id', $request->user_id)->sum('nominal');
        $total = $existingTotal + $request->nominal;

        // Simpan data baru
        TabWajib::create([
            'user_id' => $request->user_id,
            'jenis'   => $request->jenis,
            'nominal' => $request->nominal,
            'total'   => $total,
            'tanggal' => $request->tanggal,
        ]);

        return redirect()->route('tabungan_wajib.tabungan_wajib')
            ->with('pesan', 'Setoran tabungan wajib berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $setoran = TabWajib::findOrFail($id);
        $anggota = User::where('role', 'anggota')->get();

        return view('admin.tabungan_wajib.edit', compact('setoran', 'anggota'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'jenis' => 'required|in:pokok,wajib,dakem',
            'nominal' => 'required|integer|min:1',
            'tanggal' => 'required|date',
        ]);

        $setoran = TabWajib::findOrFail($id);

        // Hitung total baru berdasarkan seluruh setoran user
        $totalSebelum = TabWajib::where('user_id', $request->user_id)
                        ->where('id', '!=', $id)
                        ->sum('nominal');

        $totalBaru = $totalSebelum + $request->nominal;

        $setoran->update([
            'user_id' => $request->user_id,
            'jenis' => $request->jenis,
            'nominal' => $request->nominal,
            'tanggal' => $request->tanggal,
            'total' => $totalBaru,
        ]);

        return redirect()->route('tabungan_wajib.tabungan_wajib')
            ->with('edit', 'Setoran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $setoran = TabWajib::findOrFail($id);
        $setoran->delete();

        return redirect()->route('tabungan_wajib.tabungan_wajib')->with('hapus', 'Setoran berhasil dihapus.');
    }
}
