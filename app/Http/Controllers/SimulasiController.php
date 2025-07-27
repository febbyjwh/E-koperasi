<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SimulasiController extends Controller
{
    public function calculate(Request $request)
{
    // Ambil JSON dan ubah ke array
    $data = json_decode($request->getContent(), true);

    // Validasi secara manual
    $validator = \Validator::make($data, [
        'jumlah' => 'required|numeric|min:1',
        'lama_angsuran' => 'required|integer|min:1',
        'jenis_pinjaman' => 'required|in:barang,kms',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    // Ekstrak data valid
    $jumlah = $data['jumlah'];
    $tenor = $data['lama_angsuran'];
    $jenis = $data['jenis_pinjaman'];

    $results = [];
    $totalJasa = 0;

    if ($jenis === 'barang') {
        $jasaFlat = $jumlah * 0.02;
        $totalJasa = $jasaFlat * $tenor;
        $angsuran = ($jumlah + $totalJasa) / $tenor;

        for ($i = 1; $i <= $tenor; $i++) {
            $results[] = [
                'bulan' => $i,
                'cicilan' => round($angsuran),
                'pokok' => round($jumlah / $tenor),
                'jasa' => round($jasaFlat),
            ];
        }
    } else {
        $pokokBulanan = $jumlah / $tenor;
        $sisaPokok = $jumlah;

        for ($i = 1; $i <= $tenor; $i++) {
            $jasaBulan = $sisaPokok * 0.025;
            $totalJasa += $jasaBulan;

            $results[] = [
                'bulan' => $i,
                'cicilan' => round($pokokBulanan + $jasaBulan),
                'pokok' => round($pokokBulanan),
                'jasa' => round($jasaBulan),
            ];

            $sisaPokok -= $pokokBulanan;
        }
    }

    return response()->json([
        'data' => $results,
        'total_jasa' => round($totalJasa),
        'total_dibayar' => round($jumlah + $totalJasa),
    ]);
}

}
