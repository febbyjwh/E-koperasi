<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TabWajib;
use Illuminate\Support\Facades\Auth;

class TabWajibAnggotaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $query = TabWajib::with('anggota')
            ->where('user_id', Auth::id()) // anggota login
            ->when($search, function ($query, $search) {
                $query->whereHas('anggota', function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%")
                    ->orWhere('jenis', 'like', "%$search%");
                });
            })
            ->latest();

        $setoranWajib = $query->paginate(10)->withQueryString();

        return view('anggota.tab_wajib_anggota.index', compact('setoranWajib'));
    }

}
