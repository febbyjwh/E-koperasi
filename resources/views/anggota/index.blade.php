@extends ('layout')

@section('title', 'anggota')

@section('content')

<div class="relative bg-teal-500 p-5 pb-20 rounded-b-3xl">
    <div class="grid grid-cols-2 lg:grid-cols-2 grid-rows-2 gap-2">
        <div class="p-3 sm:p-7 col-span-1 row-span-2 bg-white h-42 sm:h-82 rounded-lg">
            <div class="flex justify-start items-center gap-3">
                <i class="fas fa-wallet text-xs sm:text-4xl text-teal-500"></i>
                <p class="text-sm sm:text-2xl font-light">Uang Ajuanmu</p>
            </div>
            <div class=" h-30 sm:h-36 mt-10 sm:mt-20">
                <div class="flex items-center justify-center sm:text-center">
                    <p class="text-xl sm:text-6xl font-bold">Rp {{ isset($pengajuan->jumlah) ?
                        number_format($pengajuan->jumlah, 0, ',', '.') : 0 }}
                    </p>
                </div>
                <div class="border-t-2 border-gray-200 mt-8 sm:mt-15 pt-2 sm:pt-4 flex justify-between">
                    <a href="{{ route('pinjaman_anggota.index') }}"
                        class="text-[11px] sm:text-xl hover:text-teal-500">Lihat
                        Detail >></a>
                    @php
                    $status = $pengajuan?->status;
                    @endphp

                    <span class="inline-block px-1 sm:px-3 py-0 sm:py-1 sm:text-xs text-[10px] rounded-full
                            @if (is_null($status)) bg-gray-100 text-gray-700
                            @elseif ($status === 'pending') bg-yellow-100 text-yellow-700
                            @elseif ($status === 'disetujui') bg-green-100 text-green-700
                            @elseif ($status === 'ditolak') bg-red-100 text-red-700
                            @elseif ($status === 'keluar') bg-blue-100 text-blue-700
                            @else bg-gray-100 text-gray-700
                            @endif">
                        {{ is_null($status) ? 'Belum' : ucfirst($status) }}
                    </span>

                </div>
            </div>
        </div>
        <div class="p-3 sm:p-7 bg-white h-20 sm:h-40 rounded-lg">
            <div class="flex justify-start items-center gap-2">
                <i class="fas fa-hand-holding-usd text-xs sm:text-3xl text-teal-500"></i>
                <p class="text-xs sm:text-2xl font-light">Uang yang diterima</p>
            </div>
            <div class="flex items-center justify-center sm:text-center h-5 sm:h-8 mt-3">
                <p class="text-1xl sm:text-4xl font-bold">Rp {{ isset($pengajuan->jumlah_diterima) ?
                    number_format($pengajuan->jumlah_diterima, 0, ',', '.') : 0 }}</p>
            </div>
        </div>
        <div class="p-3 sm:p-7 bg-white h-20 sm:h-40 rounded-lg">
            <div class="flex justify-start items-center gap-3">
                <i class="fas fa-badge-dollar text-xs sm:text-3xl text-teal-500"></i>
                <p class="text-xs sm:text-2xl font-light">Sisa pembayaran</p>
            </div>
            <div class="flex items-center justify-center sm:text-center h-5 sm:h-8 mt-3">
                <p class="text-1xl sm:text-4xl font-bold">Rp {{ isset($pelunasan->sisa_pinjaman) ?
                    number_format($pelunasan->sisa_pinjaman, 0, ',', '.') : 0 }}</p>
            </div>
        </div>
    </div>
    <div class="absolute inset-x-0 bottom-0 flex justify-center translate-y-1/2">
        <div
            class="bg-white h-20 w-96 sm:w-full sm:max-w-2xl rounded-xl shadow-sm z-10 flex items-center justify-around p-4">

            <a href="{{ route('pinjaman_anggota.index') }}" class="flex flex-col items-center justify-center">
                <i class="fas fa-hands-usd text-2xl sm:text-3xl  text-teal-500"></i>
                <p class="text-xs sm:text-lg font-light">Ajukan Pinjaman</p>
            </a>

            <a href="" class="flex flex-col items-center justify-center">
                <i class="fas fa-badge-dollar text-2xl sm:text-3xl text-teal-500"></i>
                <p class="text-xs sm:text-lg font-light">Pelunasan</p>
            </a>

            <a href="" class="flex flex-col items-center justify-center">
                <i class="fas fa-money-check-edit-alt text-2xl sm:text-3xl text-teal-500"></i>
                <p class="text-xs sm:text-lg font-light">Tab Wajib</p>
            </a>

            <a href="" class="flex flex-col items-center justify-center">
                <i class="fas fa-money-check-edit text-2xl sm:text-3xl text-teal-500"></i>
                <p class="text-xs sm:text-lg font-light">Tab Manasuka</p>
            </a>

        </div>
    </div>

</div>
<div class="mt-15">
    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Product name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Color
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Category
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Price
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        Apple MacBook Pro 17"
                    </th>
                    <td class="px-6 py-4">
                        Silver
                    </td>
                    <td class="px-6 py-4">
                        Laptop
                    </td>
                    <td class="px-6 py-4">
                        $2999
                    </td>
                </tr>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        Microsoft Surface Pro
                    </th>
                    <td class="px-6 py-4">
                        White
                    </td>
                    <td class="px-6 py-4">
                        Laptop PC
                    </td>
                    <td class="px-6 py-4">
                        $1999
                    </td>
                </tr>
                <tr class="bg-white dark:bg-gray-800">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        Magic Mouse 2
                    </th>
                    <td class="px-6 py-4">
                        Black
                    </td>
                    <td class="px-6 py-4">
                        Accessories
                    </td>
                    <td class="px-6 py-4">
                        $99
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection