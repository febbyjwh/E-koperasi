@extends ('layout')

@section ('title','Laporan Neraca')

@section ('content')
<div id="laporan-neraca" class="p-4 bg-white rounded-2xl shadow-lg print:shadow-none print:rounded-none">
    <div class="flex items-center justify-between mb-4">
        <div class="flex flex-col">
            <h2 class="text-sm md:text-xl font-semibold text-gray-700">Laporan Neraca</h2>
            <h4 class="text-sm md:text-x3 text-gray-500">laporan keuangan yang menunjukkan posisi keuangan koperasi</h4>
        </div>
        <form action="{{ route('laporan.neraca') }}" method="GET" class="flex items-center space-x-2 mr-4">

            <div class="relative print:hidden">
                <!-- Tombol Trigger -->
                <button id="dropdownFilterButton" type="button"
                    class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-full hover:bg-gray-200 focus:outline-none">
                    Filter
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <!-- Dropdown Menu -->
                <div id="dropdownFilter"
                    class="z-10 hidden absolute mt-2 w-44 right-0 bg-white divide-y divide-gray-100 rounded-lg shadow">
                    <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownFilterButton">
                        <li><button type="submit" name="filter" value="tanggal"
                                class="w-full text-left px-4 py-2 hover:bg-gray-100">Tanggal</button></li>
                        {{-- <li><button type="submit" name="filter" value="nama"
                                class="w-full text-left px-4 py-2 hover:bg-gray-100">Nama Anggota</button></li> --}}
                        <li><button type="submit" name="filter" value="jenis"
                                class="w-full text-left px-4 py-2 hover:bg-gray-100">Jenis Transaksi</button></li>
                    </ul>
                </div>
            </div>

            <!-- Input Search -->
            <div class="relative w-full max-w-xs print:hidden">
                <input type="text" name="search" value="{{ request('search') }}"
                    class="block w-full p-3 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Keterangan ...">
                <div class="absolute inset-y-0 left-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
            </div>

            <!-- Button Cari -->
            {{-- <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 transition">
                Cari
            </button> --}}
        </form>

    </div>

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

            <!-- Dropdown menu -->
            <div id="dropdownExport"
                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 absolute right-0 mt-2">
                <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownExportButton">
                    {{-- <li>
                        <a href="#" onclick="window.print()" class="block px-4 py-2 hover:bg-gray-100">Print</a>
                    </li> --}}
                    <li>
                        <a href="{{ route('laporan.exportexcel', ['jenis' => 'neraca']) }}"
                            class="block px-4 py-2 hover:bg-gray-100">Export Excel</a>
                    </li>
                    <li>
                        <a href="{{ route('laporan.exportpdf') }}" class="block px-4 py-2 hover:bg-gray-100">Export
                            PDF</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="flex flex-col">
        <div class="-m-1.5 overflow-x-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">
                <div class="overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                        <thead>
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">
                                    Kategori</th>
                                <th scope="col"
                                    class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">
                                    Keterangan</th>
                                <th scope="col"
                                    class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">
                                    Jumlah (Rp)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">

                            {{-- ASET --}}
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-neutral-800"
                                    rowspan="2">Aset</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">Kas
                                    / Saldo Kas</td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium text-gray-800 dark:text-neutral-200">
                                    {{ number_format($kas, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">
                                    Piutang Anggota</td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium text-gray-800 dark:text-neutral-200">
                                    {{ number_format($piutang, 0, ',', '.') }}</td>
                            </tr>
                            <tr class="bg-gray-100 font-bold">
                                <td colspan="2" class="px-6 py-4 text-sm text-gray-800 dark:text-neutral-800">Total Aset
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-end text-sm font-semibold text-gray-900 dark:text-white">
                                    {{ number_format($total_aset, 0, ',', '.') }}</td>
                            </tr>

                            {{-- MODAL --}}
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-neutral-800"
                                    rowspan="3">Modal</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">
                                    Modal Awal</td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium text-gray-800 dark:text-neutral-200">
                                    {{ number_format($modal_awal, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">
                                    Modal Anggota</td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium text-gray-800 dark:text-neutral-200">
                                    {{ number_format($modal_anggota, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">SHU
                                    Ditahan</td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium text-gray-800 dark:text-neutral-200">
                                    {{ number_format($shu_ditahan, 0, ',', '.') }}</td>
                            </tr>
                            <tr class="bg-gray-100 font-bold">
                                <td colspan="2" class="px-6 py-4 text-sm text-gray-800 dark:text-neutral-800">Total
                                    Modal</td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-end text-sm font-semibold text-gray-900 dark:text-white">
                                    {{ number_format($total_modal, 0, ',', '.') }}</td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('dropdownFilterButton').addEventListener('click', function () {
            const dropdown = document.getElementById('dropdownFilter');
            dropdown.classList.toggle('hidden');
        });
    </script>
    <script>
        document.getElementById('dropdownExportButton').addEventListener('click', function () {
            const dropdown = document.getElementById('dropdownExport');
            dropdown.classList.toggle('hidden');
        });
    </script>
</div>
@endsection