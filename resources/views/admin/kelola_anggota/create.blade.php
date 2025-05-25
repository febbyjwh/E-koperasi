@extends('app.app')
@section('title', 'Kelola Anggota')
@section('content')
<div class="p-6 bg-white rounded-2xl shadow-lg overflow-x-auto">
     <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-semibold text-gray-700">Tambah Anggota</h2>
        <a href="{{ route('kelola_anggota.create') }}"
            class="inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300">
            Kembali 
        </a>
    </div>

    <form action="">
        @csrf
        <div class="mb-4">
            <label for="nama" class="block text-gray-700 font-medium mb-2">Nama Lengkap</label>
            <input type="text" name="nama" id="nama" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring" required>
        </div>
        <div class="mb-4">
            <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
            <input type="email" name="email" id="email" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring" required>
        </div>
        <div class="mb-4">
            <label for="no_hp" class="block text-gray-700 font-medium mb-2">No. HP</label>
            <input type="text" name="no_hp" id="no_hp" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring" required>
        </div>
        <div class="mb-4">
            <label for="alamat" class="block text-gray-700 font-medium mb-2">Alamat</label>
            <textarea name="alamat" id="alamat" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring" required></textarea>
        </div>
        <div class="mb-4">
            <label for="jenis_kelamin" class="block text-gray-700 font-medium mb-2">Jenis Kelamin</label>
            <select name="jenis_kelamin" id="jenis_kelamin" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring" required>
                <option value="">Pilih Jenis Kelamin</option>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>
        </div>
        <div class="mb-4">
            <label for="tanggal_lahir" class="block text-gray-700 font-medium mb-2">Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring" required>
        </div>
        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Tambah Anggota</button>
        </div>
    </form>
</div>

@endsection