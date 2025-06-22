@extends('layout')

@section('title', 'Edit Tabungan Manasuka')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded-xl shadow-md">
    <h2 class="text-xl font-semibold mb-4 text-gray-700">Edit Tabungan Manasuka</h2>

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
                   class="w-full border rounded-lg px-3 py-2" min="10000" required>
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

        <div class="flex justify-end">
            <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                Update
            </button>
        </div>
    </form>
</div>

<script>
    const nominalMasuk = document.getElementById('nominal_masuk');
    const warning = document.getElementById('nominalWarning');

    nominalMasuk.addEventListener('input', function () {
        if (this.value < 10000) {
            warning.classList.remove('hidden');
        } else {
            warning.classList.add('hidden');
        }
    });
</script>
@endsection
