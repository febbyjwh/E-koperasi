@extends('layout')

@section('title', 'Laporan SHU')

@section('content')
<div class="p-4 bg-white rounded-2xl shadow">
    <h2 class="text-lg font-semibold text-gray-700 mb-4">Laporan Sisa Hasil Usaha (SHU)</h2>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Keterangan</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Jumlah (Rp)</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">

                <!-- Pendapatan -->
                <tr>
                    <td class="px-6 py-4 font-bold" rowspan="4">Pendapatan</td>
                    <td class="px-6 py-4">Penjualan Barang</td>
                    <td class="px-6 py-4 text-right">{{ number_format($penjualan_barang, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td class="px-6 py-4">Jasa Simpan Pinjam</td>
                    <td class="px-6 py-4 text-right">{{ number_format($jasa_simpan_pinjam, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td class="px-6 py-4">Pendapatan Lain-lain</td>
                    <td class="px-6 py-4 text-right">{{ number_format($pendapatan_lain, 0, ',', '.') }}</td>
                </tr>
                <tr class="bg-gray-100 font-semibold">
                    <td class="px-6 py-4">Total Pendapatan</td>
                    <td class="px-6 py-4 text-right">{{ number_format($total_pendapatan, 0, ',', '.') }}</td>
                </tr>

                <!-- Biaya -->
                <tr>
                    <td class="px-6 py-4 font-bold" rowspan="4">Biaya</td>
                    <td class="px-6 py-4">Biaya Operasional</td>
                    <td class="px-6 py-4 text-right">{{ number_format($biaya_operasional, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td class="px-6 py-4">Biaya Gaji</td>
                    <td class="px-6 py-4 text-right">{{ number_format($biaya_gaji, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td class="px-6 py-4">Biaya Lain-lain</td>
                    <td class="px-6 py-4 text-right">{{ number_format($biaya_lain, 0, ',', '.') }}</td>
                </tr>
                <tr class="bg-gray-100 font-semibold">
                    <td class="px-6 py-4">Total Biaya</td>
                    <td class="px-6 py-4 text-right">{{ number_format($total_biaya, 0, ',', '.') }}</td>
                </tr>

                <!-- SHU -->
                <tr>
                    <td class="px-6 py-4 font-bold" rowspan="3">Perhitungan SHU</td>
                    <td class="px-6 py-4">SHU Sebelum Pajak</td>
                    <td class="px-6 py-4 text-right font-semibold">{{ number_format($shu_sebelum_pajak, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td class="px-6 py-4">Pajak (10%)</td>
                    <td class="px-6 py-4 text-right">{{ number_format($pajak, 0, ',', '.') }}</td>
                </tr>
                <tr class="bg-gray-100 font-bold">
                    <td class="px-6 py-4">SHU Bersih</td>
                    <td class="px-6 py-4 text-right text-green-700">{{ number_format($shu_bersih, 0, ',', '.') }}</td>
                </tr>

            </tbody>
        </table>
    </div>
</div>
@endsection
