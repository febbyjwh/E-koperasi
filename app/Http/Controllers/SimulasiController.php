<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SimulasiController extends Controller
{
    public function calculate(Request $request)
    {
        $nominal = (float) $request->nominal;
        $tenor = (int) $request->tenor;

        if ($nominal <= 0 || $tenor <= 0) {
            return response()->json([
                'error' => 'Nominal dan tenor harus lebih dari 0'
            ], 422);
        }

        // Kredit Barang (flat rate)
        $jasaFlatBarang = $nominal * 0.02;
        $totalJasaBarang = $jasaFlatBarang * $tenor;
        $cicilanBarang = array_fill(0, $tenor, ($nominal + $totalJasaBarang) / $tenor);

        // Kredit Manasuka (menurun)
        $pokokBulanan = $nominal / $tenor;
        $sisaPokok = $nominal;
        $cicilanKMS = [];
        for ($i = 0; $i < $tenor; $i++) {
            $jasaBulan = $sisaPokok * 0.025;
            $cicilanKMS[] = $pokokBulanan + $jasaBulan;
            $sisaPokok -= $pokokBulanan;
        }

        return response()->json([
            'barang' => $cicilanBarang,
            'kms' => $cicilanKMS,
            'total_barang' => array_sum($cicilanBarang),
            'total_kms' => array_sum($cicilanKMS)
        ]);
    }
}
