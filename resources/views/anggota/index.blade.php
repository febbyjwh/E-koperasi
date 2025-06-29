@extends ('layout')

@section('title', 'anggota')

@section('content')

    <div class="relative bg-teal-500 p-5 pb-20 rounded-b-3xl">
        <div class="grid grid-cols-2 lg:grid-cols-2 grid-rows-2 gap-2">
            <div class=" p-3 sm:p-7 col-span-1 row-span-2 bg-white h-42 sm:h-58 rounded-lg">
                <div class="flex justify-start items-center gap-3">
                    <i class="fas fa-wallet text-xl sm:text-4xl text-teal-500"></i>
                    <p class="text-sm sm:text-2xl font-light">Uang Ajuanmu</p>
                </div>
                <div class="flex items-center justify-center sm:text-center h-30 sm:h-36">
                    <p class="text-2xl sm:text-5xl font-bold">Rp 4.000.000</p>
                </div>
            </div>
            <div class="p-3 sm:p-7 bg-white h-20 sm:h-28 rounded-lg">
                <div class="flex justify-start items-center gap-3">
                    <i class="fas fa-wallet text-xl sm:text-4xl text-teal-500"></i>
                    <p class="text-xs sm:text-2xl font-light">Uang Ajuanmu</p>
                </div>
                <div class="flex items-center justify-center sm:text-center h-5 sm:h-8">
                    <p class="text-xs sm:text-5xl font-bold">Rp 4.000.000</p>
                </div>
            </div>
            <div class="p-3 sm:p-7 bg-white h-20 sm:h-28 rounded-lg">
                <div class="flex justify-start items-center gap-3">
                    <i class="fas fa-wallet text-xl sm:text-4xl text-teal-500"></i>
                    <p class="text-xs sm:text-2xl font-light">Uang Ajuanmu</p>
                </div>
                <div class="flex items-center justify-center sm:text-center h-5 sm:h-8">
                    <p class="text-xs sm:text-5xl font-bold">Rp 4.000.000</p>
                </div>
            </div>
        </div>
        <div class="absolute inset-x-0 bottom-0 flex justify-center translate-y-1/2">
            <div
                class="bg-white h-20 w-96 sm:w-full sm:max-w-2xl rounded-xl shadow-sm z-10 flex items-center justify-between p-10">
                <a href="{{ route('pinjaman_anggota.index') }}">
                    <i class="fas fa-wallet text-3xl text-teal-500"></i>
                </a>
                <a href="">
                    <i class="fas fa-wallet text-3xl text-teal-500"></i>
                </a>
                <a href="">
                    <i class="fas fa-wallet text-3xl text-teal-500"></i>
                </a>
                <a href="">
                    <i class="fas fa-wallet text-3xl text-teal-500"></i>
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
