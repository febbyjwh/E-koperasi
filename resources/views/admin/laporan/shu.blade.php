@extends('layout')

@section('title', 'Laporan SHU')

@section('content')
<div id="laporan-shu" class="p-4 bg-white rounded-2xl shadow-lg print:shadow-none print:rounded-none">
    <div class="flex items-center justify-between mb-4">
        <div class="flex flex-col">
            <h2 class="text-sm md:text-xl font-semibold text-gray-700">Laporan SHU</h2>
            <h4 class="text-sm md:text-lg text-gray-500">Pembagian Sisa Hasil Usaha Koperasi</h4>
        </div>

        <!-- Filter Periode -->
        <form action="{{ route('laporan.shu') }}" method="GET" class="flex items-center space-x-2 mr-4">
            <input type="month" name="periode" value="{{ request('periode') }}"
                class="p-2 border border-gray-300 rounded-lg text-sm focus:ring focus:ring-blue-300">
            <button type="submit"
                class="px-4 py-2 text-sm text-white bg-blue-600 rounded-full hover:bg-blue-700">
                Tampilkan
            </button>
        </form>
    </div>

    <!-- Export Button -->
    <div class="flex justify-start mb-4 print:hidden">
        <div class="relative inline-block text-left">
            <button id="dropdownExportButton"
                class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-full hover:bg-blue-700">
                Export
                <svg class="w-4 h-4 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 7l5 5 5-5" />
                </svg>
            </button>

            <div id="dropdownExport"
                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 absolute right-0 mt-2">
                <ul class="py-2 text-sm text-gray-700">
                    <li><a href="#" onclick="window.print()" class="block px-4 py-2 hover:bg-gray-100">Print</a></li>
                    {{-- <li><a href="{{ route('laporan.exportexcelshu') }}" class="block px-4 py-2 hover:bg-gray-100">Export Excel</a></li>
                    <li><a href="{{ route('laporan.exportpdfshu') }}" class="block px-4 py-2 hover:bg-gray-100">Export PDF</a></li> --}}
                </ul>
            </div>
        </div>
    </div>

    <!-- Tabel Laporan SHU -->
    <div class="overflow-hidden rounded-lg border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Keterangan</th>
                    <th class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">Jumlah (Rp)</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <tr>
                    <td class="px-6 py-4 text-gray-700">Pendapatan (Bunga Pinjaman)</td>
                    <td class="px-6 py-4 text-end font-semibold">{{ number_format($pendapatan, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td class="px-6 py-4 text-gray-700">Biaya Operasional (10%)</td>
                    <td class="px-6 py-4 text-end text-red-600">- {{ number_format($biaya_operasional, 0, ',', '.') }}</td>
                </tr>
                <tr class="bg-gray-100 font-bold">
                    <td class="px-6 py-4">SHU Bersih</td>
                    <td class="px-6 py-4 text-end">{{ number_format($shu_bersih, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Pembagian SHU -->
    <h3 class="mt-6 mb-2 text-lg font-semibold text-gray-700">Pembagian SHU</h3>
    <div class="overflow-hidden rounded-lg border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Kategori</th>
                    <th class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">Jumlah (Rp)</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <tr>
                    <td class="px-6 py-4 text-gray-700">Jasa Pinjaman (40%)</td>
                    <td class="px-6 py-4 text-end">{{ number_format($porsi['jasa_pinjaman'], 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td class="px-6 py-4 text-gray-700">Jasa Simpanan (35%)</td>
                    <td class="px-6 py-4 text-end">{{ number_format($porsi['jasa_simpanan'], 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td class="px-6 py-4 text-gray-700">Dana Cadangan (15%)</td>
                    <td class="px-6 py-4 text-end">{{ number_format($porsi['dana_cadangan'], 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td class="px-6 py-4 text-gray-700">Dana Sosial (5%)</td>
                    <td class="px-6 py-4 text-end">{{ number_format($porsi['dana_sosial'], 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td class="px-6 py-4 text-gray-700">Pengurus (5%)</td>
                    <td class="px-6 py-4 text-end">{{ number_format($porsi['pengurus'], 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <script>
        document.getElementById('dropdownExportButton').addEventListener('click', function () {
            document.getElementById('dropdownExport').classList.toggle('hidden');
        });
    </script>
</div>
@endsection
