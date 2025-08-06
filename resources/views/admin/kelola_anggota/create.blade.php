@extends('layout')
@section('title', 'Kelola Anggota')
@section('content')


    <div class="p-6 bg-white rounded-2xl shadow-lg overflow-x-auto">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold text-gray-700">Tambah Anggota</h2>
        </div>

        <form action="{{ route('kelola_anggota.store')}}" method="POST" class="space-y-4">
            @csrf
            <div class="mb-5">
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
                <input type="email" name="email" id="email"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-teal-500 dark:focus:border-teal-500"
                    placeholder="name@flowbite.com" required />
            </div>
            <div class="mb-4">
                <label for="nama" class="block text-gray-700 font-medium mb-2">Nama Lengkap</label>
                <input type="text" name="nama" id="nama"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-teal-500 dark:focus:border-teal-500"
                    required>
            </div>
            <div class="mb-4">
                <label for="username" class="block text-gray-700 font-medium mb-2">Username</label>
                <input type="username" name="username" id="username"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-teal-500 dark:focus:border-teal-500"
                    required>
            </div>
            <div class="mb-4">
                <label for="no_hp" class="block text-gray-700 font-medium mb-2">No. HP</label>
                <input type="text" name="no_hp" id="no_hp"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-teal-500 dark:focus:border-teal-500"
                    required>
            </div>
            <div class="mb-4">
                <label for="alamat" class="block text-gray-700 font-medium mb-2">Alamat</label>
                <textarea name="alamat" id="alamat" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-teal-500 focus:border-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-teal-500 dark:focus:border-teal-500" required></textarea>
            </div>
            <div class="mb-4">
                <label for="jenis_kelamin" class="block text-gray-700 font-medium mb-2">Jenis Kelamin</label>
                <select name="jenis_kelamin" id="jenis_kelamin"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-teal-500 dark:focus:border-teal-500"
                    required>
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="tanggal_lahir" class="block text-gray-700 font-medium mb-2">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                    class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-teal-500 dark:focus:border-teal-500 dark:shadow-xs-light" required>
            </div>

            <div class="flex justify-end gap-2">
                <button type="submit" class="px-4 py-2 bg-teal-600 text-white rounded-full hover:bg-teal-700 transition">Simpan</button>
                <a href="{{ route('kelola_anggota.kelola_anggota') }}"
                    class="px-4 py-2 text-gray-600 hover:underline">
                    Kembali
                </a>
            </div>
        </form>
    </div>

@endsection
