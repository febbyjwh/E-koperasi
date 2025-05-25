@extends('app.app')
@section('title', 'Kelola Anggota')
@section('content')
<div class="p-6 bg-white rounded-2xl shadow-lg overflow-x-auto">

    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-semibold text-gray-700">Daftar Anggota</h2>
        <a href="{{ route('kelola_anggota.create') }}"
            class="inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300">
            Tambah Anggota
        </a>
    </div>
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Registrasi</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200 text-sm text-gray-700">
            <tr>
                <td class="px-6 py-4">1</td>
                <td class="px-6 py-4">Ahmad Sulaiman</td>
                <td class="px-6 py-4">ahmad@example.com</td>
                <td class="px-6 py-4">01 Jan 2024</td>
                <td class="px-6 py-4 text-right space-x-2">
                    <button class="px-3 py-1 bg-yellow-400 hover:bg-yellow-500 text-white rounded-lg text-xs">
                        Edit
                    </button>
                    <button class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded-lg text-xs">
                        Hapus
                    </button>
                </td>
            </tr>
            <tr>
                <td class="px-6 py-4">2</td>
                <td class="px-6 py-4">Siti Aminah</td>
                <td class="px-6 py-4">siti@example.com</td>
                <td class="px-6 py-4">15 Feb 2024</td>
                <td class="px-6 py-4 text-right space-x-2">
                    <button class="px-3 py-1 bg-yellow-400 hover:bg-yellow-500 text-white rounded-lg text-xs">
                        Edit
                    </button>
                    <button class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded-lg text-xs">
                        Hapus
                    </button>
                </td>
            </tr>
            <tr>
                <td class="px-6 py-4">3</td>
                <td class="px-6 py-4">Budi Hartono</td>
                <td class="px-6 py-4">budi@example.com</td>
                <td class="px-6 py-4">23 Mar 2024</td>
                <td class="px-6 py-4 text-right space-x-2">
                    <button class="px-3 py-1 bg-yellow-400 hover:bg-yellow-500 text-white rounded-lg text-xs">
                        Edit
                    </button>
                    <button class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded-lg text-xs">
                        Hapus
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
</div>

@endsection