@extends('layout')

@section('title', 'Tambah Tabungan Manasuka')

@section('content')
<div class="p-6 bg-white rounded-2xl shadow-lg">
    <h2 class="text-lg font-semibold mb-4 text-gray-700">Tambah Tabungan Manasuka</h2>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tabungan_manasuka.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label for="user_id" class="block text-sm font-medium text-gray-700">Nama Anggota</label>
            <select name="user_id" id="user_id" required
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring focus:ring-blue-200">
                <option value="">-- Pilih Anggota --</option>
                @foreach ($anggota as $user)
                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="nominal_masuk" class="block text-sm font-medium text-gray-700">
                Nominal Masuk (min. Rp10.000)
            </label>
            <input type="number" name="nominal_masuk" id="nominal_masuk" min="10000"
                value="{{ old('nominal_masuk') }}"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring focus:ring-blue-200">

            {{-- Real-time validation warning --}}
            <p id="nominalWarning" class="text-sm text-red-600 mt-1 hidden">
                Nominal masuk minimal Rp10.000.
            </p>
        </div>

        <div>
            <label for="nominal_keluar" class="block text-sm font-medium text-gray-700">Nominal Keluar</label>
            <input type="number" name="nominal_keluar" id="nominal_keluar" min="0"
                   value="{{ old('nominal_keluar') }}"
                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring focus:ring-blue-200">
        </div>

        <div>
            <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" required
                   value="{{ old('tanggal') }}"
                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring focus:ring-blue-200">
        </div>

        <div class="flex justify-end gap-2">
            <button type="submit"
                    class="bg-teal-600 hover:bg-teal-700 text-white font-semibold py-2 px-4 rounded-full">
                Simpan
            </button>
            <a href="{{ route('tabungan_manasuka.tabungan_manasuka') }}"
               class="px-4 py-2 text-gray-600 hover:underline">Batal</a>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const nominalInput = document.getElementById('nominal_masuk');
            const warningText = document.getElementById('nominalWarning');

            nominalInput.addEventListener('input', function () {
                const value = parseInt(this.value, 10);
                if (!isNaN(value) && value < 10000) {
                    warningText.classList.remove('hidden');
                } else {
                    warningText.classList.add('hidden');
                }
            });
        });
    </script>

</div>
@endsection