<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TabManasuka;
use Illuminate\Support\Facades\Auth;

class TabManasukaAnggotaController extends Controller
{
    Public function index(Request $request)
    {
        $search = $request->search;

        $tabunganManasuka = TabManasuka::with('anggota')
            ->where('user_id', Auth::id()) // anggota login
            ->when($search, function ($query, $search) {
                $query->whereHas('anggota', function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%");
                });
            })
            ->latest()
            ->get();

        return view('anggota.tab_manasuka_anggota.index', compact('tabunganManasuka'));
    }
}
