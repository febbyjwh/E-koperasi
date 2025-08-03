@extends ('layout')

@section ('title','Laporan Arus Kas')

@section ('content')
<div id="laporan-arus-kas" class="p-4 bg-white rounded-2xl shadow-lg print:shadow-none print:rounded-none">
    <div class="flex items-center justify-between mb-4">
        <div class="flex flex-col">
            <h2 class="text-sm md:text-xl font-semibold text-gray-700">Laporan Arus Kas</h2>
            <h4 class="text-sm md:text-x3 text-gray-500">Laporan perputaran uang kas koperasi</h4>
        </div>
        <form action="{{ route('laporan.arus_kas') }}" method="GET" class="flex items-center space-x-2 mr-4">
            <!-- Dropdown Filter -->
            <!-- Filter Periode Bulan -->
            <input type="month" name="periode" value="{{ request('periode') }}"
                class="p-2 border border-gray-300 rounded-lg text-sm focus:ring focus:ring-blue-300">
            <button type="submit"
                class="cursor-pointer px-4 py-2 text-sm text-white bg-blue-600 rounded-full hover:bg-blue-700">
                Tampilkan
            </button>

        </form>
    </div>

    <!-- Export Button -->
    <div class="flex justify-start mb-4 print:hidden">
        <div class="relative inline-block text-left">
            <button id="dropdownExportButton" data-dropdown-toggle="dropdownExport"
                class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-full hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Export
                <svg class="w-4 h-4 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 7l5 5 5-5" />
                </svg>
            </button>

            <div id="dropdownExport"
                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 absolute right-0 mt-2">
                <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownExportButton">
                    {{-- <li><a href="#" onclick="window.print()" class="block px-4 py-2 hover:bg-gray-100">Print</a></li> --}}
                    <li><a href="{{ route('laporan.exportexcelaruskas', ['jenis' => 'aruskas']) }}" class="block px-4 py-2 hover:bg-gray-100">Export Excel</a></li>
                    <li><a href="{{ route('laporan.exportpdfaruskas', ['jenis' => 'aruskas']) }}" class="block px-4 py-2 hover:bg-gray-100">Export PDF</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Tabel Arus Kas -->
    <div class="flex flex-col">
        <div class="-m-1.5 overflow-x-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">
                <div class="overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Kategori</th>
                                <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Keterangan</th>
                                <th class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">Jumlah (Rp)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            {{-- Kas Masuk --}}
                            <tr class="bg-gray-50 font-bold">
                                <td colspan="3" class="px-6 py-2 text-gray-700">Kas Masuk</td>
                            </tr>
                            @foreach($kasMasuk as $item)
                            <tr>
                                <td class="px-6 py-4"></td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $item['keterangan'] }}</td>
                                <td class="px-6 py-4 text-end text-sm text-gray-800">{{ number_format($item['jumlah'], 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                            <tr class="bg-gray-100 font-semibold">
                                <td colspan="2" class="px-6 py-3 text-gray-700">Total Kas Masuk</td>
                                <td class="px-6 py-3 text-end text-gray-900">{{ number_format($totalKasMasuk, 0, ',', '.') }}</td>
                            </tr>

                            {{-- Kas Keluar --}}
                            <tr class="bg-gray-50 font-bold">
                                <td colspan="3" class="px-6 py-2 text-gray-700">Kas Keluar</td>
                            </tr>
                            @foreach($kasKeluar as $item)
                            <tr>
                                <td class="px-6 py-4"></td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $item['keterangan'] }}</td>
                                <td class="px-6 py-4 text-end text-sm text-gray-800">{{ number_format($item['jumlah'], 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                            <tr class="bg-gray-100 font-semibold">
                                <td colspan="2" class="px-6 py-3 text-gray-700">Total Kas Keluar</td>
                                <td class="px-6 py-3 text-end text-gray-900">{{ number_format($totalKasKeluar, 0, ',', '.') }}</td>
                            </tr>

                            {{-- Summary --}}
                            <tr class="bg-gray-100 font-bold">
                                <td colspan="2" class="px-6 py-4 text-sm text-gray-700">Kenaikan Kas Bersih</td>
                                <td class="px-6 py-4 text-end text-sm text-gray-900">{{ number_format($kasBersih, 0, ',', '.') }}</td>
                            </tr>
                            <tr class="bg-gray-100 font-bold">
                                <td colspan="2" class="px-6 py-4 text-sm text-gray-700">Saldo Kas Awal</td>
                                <td class="px-6 py-4 text-end text-sm text-gray-900">{{ number_format($saldoKasAwal, 0, ',', '.') }}</td>
                            </tr>
                            <tr class="bg-gray-200 font-bold">
                                <td colspan="2" class="px-6 py-4 text-sm text-gray-700">Saldo Kas Akhir</td>
                                <td class="px-6 py-4 text-end text-sm text-gray-900">{{ number_format($saldoKas, 0, ',', '.') }}</td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <!-- Script Dropdown -->
    <script>
        document.getElementById('dropdownFilterButton').addEventListener('click', function () {
            const dropdown = document.getElementById('dropdownFilter');
            dropdown.classList.toggle('hidden');
        });
        document.getElementById('dropdownExportButton').addEventListener('click', function () {
            const dropdown = document.getElementById('dropdownExport');
            dropdown.classList.toggle('hidden');
        });
    </script>
</div>
@endsection
