<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Modal;

class ModalController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $modals = Modal::with('user')
            ->when($search, function ($query, $search) {
                $query->where('keterangan', 'like', "%{$search}%")
                    ->orWhere('sumber', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%");
            })
            ->orderBy('tanggal', 'desc')
            ->paginate(10); // tampilkeun 10 data per halaman

        
        $totalMasuk = Modal::where('status', 'masuk')->sum('jumlah');
        $totalKeluar = Modal::where('status', 'keluar')->sum('jumlah');
        $saldo = $totalMasuk - $totalKeluar;

        return view('admin.modal.index', compact('modals', 'totalMasuk', 'totalKeluar', 'saldo', 'search'));
    }

    public function create()
    {
        return view('admin.modal.create');
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     'tanggal' => 'required|date',
        //     'jumlah' => 'required|numeric|min:0',
        //     'keterangan' => 'nullable|string',
        //     'sumber' => 'required|in:admin,pelunasan',
        //     'status' => 'required|in:masuk,pending,ditolak',
        // ]);

        Modal::create([
            'tanggal' => $request->tanggal,
            'jumlah' => $request->jumlah,
            'keterangan' => $request->keterangan,
            'sumber' => $request->sumber,
            'status' => $request->status,
            'user_id' => auth()->id(), // ganti dari 
        ]);

        return redirect()->route('modal.index')->with('pesan', 'Data modal berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $modal = Modal::findOrFail($id);
        return view('admin.modal.edit', compact('modal'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
            'sumber' => 'required|in:modal_awal,pelunasan,lainnya',
            'status' => 'required|in:masuk,keluar,pending',
        ]);

        $modal = Modal::findOrFail($id);
        $modal->update([
            'tanggal' => $request->tanggal,
            'jumlah' => $request->jumlah,
            'keterangan' => $request->keterangan,
            'sumber' => $request->sumber,
            'status' => $request->status,
        ]);

        return redirect()->route('modal.index')->with('edit', 'Data modal berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $modal = Modal::findOrFail($id);
        $modal->delete();

        return redirect()->route('modal.index')->with('hapus', 'Data modal berhasil dihapus.');
    }
}
