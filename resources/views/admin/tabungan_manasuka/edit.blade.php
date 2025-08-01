@extends('layout')

@section('title', 'Edit Tabungan Manasuka')

@section('content')
@include('components.alert')

<div class="bg-white p-6 rounded-xl shadow-md overflow-x-auto">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-semibold text-gray-700">Edit Anggota</h2>
    </div>

    <form action="{{ route('tabungan_manasuka.update', $tabungan->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="user_id" class="block text-gray-600 mb-1">Nama Anggota</label>
            <select name="user_id" id="user_id" class="w-full border rounded-lg px-3 py-2">
                <option value="">-- Pilih Anggota --</option>
                @foreach($anggota as $user)
                    <option value="{{ $user->id }}" {{ $tabungan->user_id == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
            @error('user_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="nominal_masuk" class="block text-gray-600 mb-1">Nominal Masuk</label>
            <input type="number" name="nominal_masuk" id="nominal_masuk" value="{{ old('nominal_masuk', $tabungan->nominal_masuk) }}"
                   class="w-full border rounded-lg px-3 py-2" min="0">
            <p id="nominalWarning" class="text-red-500 text-sm mt-1 hidden">Nominal masuk minimal Rp10.000</p>
            @error('nominal_masuk')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="nominal_keluar" class="block text-gray-600 mb-1">Nominal Keluar</label>
            <input type="number" name="nominal_keluar" id="nominal_keluar" value="{{ old('nominal_keluar', $tabungan->nominal_keluar) }}"
                   class="w-full border rounded-lg px-3 py-2" min="0">
            @error('nominal_keluar')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="tanggal" class="block text-gray-600 mb-1">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', \Carbon\Carbon::parse($tabungan->tanggal)->format('Y-m-d')) }}"
                   class="w-full border rounded-lg px-3 py-2" required>
            @error('tanggal')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end gap-2">
            <button type="submit"
                class="bg-teal-600 hover:bg-teal-700 text-white font-semibold py-2 px-4 rounded-full">
                Perbaharui
            </button>
            <a href="{{ route('tabungan_manasuka.tabungan_manasuka') }}"
                class="px-4 py-2 text-gray-600 hover:underline">
                Kembali
            </a>
        </div>
    </form>
</div>

<script>
    const nominalMasuk = document.getElementById('nominal_masuk');
    const warning = document.getElementById('nominalWarning');

    nominalMasuk.addEventListener('input', function () {
        if (this.value && parseInt(this.value) < 10000) {
            warning.classList.remove('hidden');
        } else {
            warning.classList.add('hidden');
        }

    });
</script>
@endsection
