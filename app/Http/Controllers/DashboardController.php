<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
class DashboardController extends Controller
{
    public function index()
    {
        $totalPengajuan = \App\Models\PengajuanPinjaman::count();
        $disetujui = \App\Models\PengajuanPinjaman::where('status', 'disetujui')->count();
        $pending = \App\Models\PengajuanPinjaman::where('status', 'pending')->count();
        $totalDana = \App\Models\PengajuanPinjaman::where('status', 'disetujui')->sum('jumlah');

        return view('dashboard', compact('totalPengajuan', 'disetujui', 'pending', 'totalDana'));
    }

}
