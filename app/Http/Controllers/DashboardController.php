<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
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
