@extends('layout')
@section('title', 'Kelola Anggota')
@section('content')
    <div class="p-4 bg-white rounded-2xl shadow-lg">
        <div class=" flex items-center justify-between mb-4">
            <h2 class="text-sm md:text-xl font-semibold text-gray-700">Daftar Anggota</h2>
            <a href="{{ route('kelola_anggota.create') }}"
                class="inline-block px-2 sm:px-4 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300">
                Tambah Anggota
            </a>
        </div>

        <div class="overflow-x-auto w-full">

            <table class="min-w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-3">No</th>
                        <th class="px-6 py-3 whitespace-nowrap">Nomor Anggota</th>
                        <th class="px-6 py-3">Nama</th>
                        <th class="px-6 py-3">NIS/NI</th>
                        <th class="px-6 py-3 whitespace-nowrap">Jenis Kelamin</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Email</th>
                        <th class="px-6 py-3 whitespace-nowrap">Tanggal Registrasi</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            1
                        </th>
                        <td class="px-6 py-4">AG001</td>
                        <td class="px-6 py-4">Ahmad Sulaiman</td>
                        <td class="px-6 py-4">123456</td>
                        <td class="px-6 py-4">Laki-laki</td>
                        <td class="px-6 py-4">Aktif</td>
                        <td class="px-6 py-4">ahmad@example.com</td>
                        <td class="px-6 py-4">01 Jan 2024</td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                            <a href="#" class="font-medium text-red-600 dark:text-blue-500 hover:underline">Delete</a>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

    </div>

@endsection
