<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;

class NeracaExport implements FromArray, WithHeadings, WithEvents, ShouldAutoSize
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        return $this->data;
    }

    public function headings(): array
    {
        return []; // Header sudah ada di data
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet;

                // (kode formatting tetap sama seperti sebelumnya)
                // ...
                $sheet->mergeCells("A17:C17")->setCellValue("A17", 'Dicetak pada: ' . now('Asia/Jakarta')->format('d F Y, H:i') . ' WIB');
            }
        ];
    }
}

