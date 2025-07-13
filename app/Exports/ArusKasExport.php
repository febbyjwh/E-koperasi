<?php
namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ArusKasExport implements FromView
{
    protected $kasMasuk, $kasKeluar, $totalKasMasuk, $totalKasKeluar, $kasBersih, $saldoKasAwal, $saldoKas, $periode;

    public function __construct($kasMasuk, $kasKeluar, $totalKasMasuk, $totalKasKeluar, $kasBersih, $saldoKasAwal, $saldoKas, $periode)
    {
        $this->kasMasuk = $kasMasuk;
        $this->kasKeluar = $kasKeluar;
        $this->totalKasMasuk = $totalKasMasuk;
        $this->totalKasKeluar = $totalKasKeluar;
        $this->kasBersih = $kasBersih;
        $this->saldoKasAwal = $saldoKasAwal;
        $this->saldoKas = $saldoKas;
        $this->periode = $periode;
    }

    public function view(): View
    {
        return view('admin.laporan.arus_kas_excel', [
            'kasMasuk' => $this->kasMasuk,
            'kasKeluar' => $this->kasKeluar,
            'totalKasMasuk' => $this->totalKasMasuk,
            'totalKasKeluar' => $this->totalKasKeluar,
            'kasBersih' => $this->kasBersih,
            'saldoKasAwal' => $this->saldoKasAwal,
            'saldoKas' => $this->saldoKas,
            'periode' => $this->periode,
        ]);
    }
}
