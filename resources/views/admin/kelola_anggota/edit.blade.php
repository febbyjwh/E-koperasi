@extends('layout')

@section('title', 'Edit Anggota')

@section('content')
<div class="p-6 bg-white rounded-2xl shadow-lg overflow-x-auto">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-semibold text-gray-700">Edit Anggota</h2>
        <a href="{{ route('kelola_anggota.kelola_anggota') }}"
            class="inline-block px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition duration-300">
            Kembali
        </a>
    </div>

    <form action="{{ route('kelola_anggota.update', $anggota->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div class="mb-5">
            <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $anggota->email) }}"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5" required />
        </div>

        <div class="mb-4">
            <label for="nama" class="block text-gray-700 font-medium mb-2">Nama Lengkap</label>
            <input type="text" name="nama" id="nama" value="{{ old('nama', $anggota->name) }}"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5" required>
        </div>

        <div class="mb-4">
            <label for="username" class="block text-gray-700 font-medium mb-2">Username</label>
            <input type="text" name="username" id="username" value="{{ old('username', $anggota->username) }}"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5" required>
        </div>

        <div class="mb-4">
            <label for="no_hp" class="block text-gray-700 font-medium mb-2">No. HP</label>
            <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp', $anggota->no_hp) }}"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5">
        </div>

        <div class="mb-4">
            <label for="alamat" class="block text-gray-700 font-medium mb-2">Alamat</label>
            <textarea name="alamat" id="alamat"
                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-teal-500 focus:border-teal-500"
                required>{{ old('alamat', $anggota->alamat) }}</textarea>
        </div>

        <div class="mb-4">
            <label for="jenis_kelamin" class="block text-gray-700 font-medium mb-2">Jenis Kelamin</label>
            <select name="jenis_kelamin" id="jenis_kelamin"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5" required>
                <option value="">Pilih Jenis Kelamin</option>
                <option value="Laki-laki" {{ old('jenis_kelamin', $anggota->jenis_kelamin) === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                <option value="Perempuan" {{ old('jenis_kelamin', $anggota->jenis_kelamin) === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="tanggal_lahir" class="block text-gray-700 font-medium mb-2">Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir', $anggota->tanggal_lahir) }}"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5" required>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-teal-600 text-white px-6 py-2 rounded hover:bg-teal-700">Perbaharui</button>
        </div>
    </form>
</div>
@endsection