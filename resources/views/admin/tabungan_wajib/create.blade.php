@extends('layout')

@section('title', 'Setoran Tabungan Wajib')

@section('content')
    <div class="p-6 bg-white rounded-2xl shadow-lg w-full">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold text-gray-700">Tambah Setoran Tabungan Wajib</h2>
            <a href="{{ route('tabungan_wajib.tabungan_wajib') }}"
                class="inline-block px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition duration-300">
                Kembali
            </a>
        </div>

        <form action="{{ route('tabungan_wajib.store') }}" method="POST" class="space-y-4">
            @csrf

            <div class="mb-4">
                <label for="user_id" class="block text-gray-700 font-medium mb-2">Nama Anggota</label>
                <select name="user_id" id="user_id"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5"
                    required>
                    <option value="">-- Pilih Anggota --</option>
                    @foreach($anggota as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="jenis" class="block text-gray-700 font-medium mb-2">Jenis Setoran</label>
                <select name="jenis" id="jenis"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5"
                    required>
                    <option value="">-- Pilih Jenis --</option>
                    <option value="pokok">Iuran Pokok</option>
                    <option value="wajib">Tabungan Wajib</option>
                    <option value="dakem">Dakem</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="nominal" class="block text-gray-700 font-medium mb-2">Nominal Setoran</label>
                <input type="number" name="nominal" id="nominal"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5"
                    required min="1">
            </div>

            <div class="mb-4">
                <label for="tanggal" class="block text-gray-700 font-medium mb-2">Tanggal Setoran</label>
                <input type="date" name="tanggal" id="tanggal"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5"
                    required>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-teal-600 text-white px-6 py-2 rounded hover:bg-teal-700">
                    Simpan
                </button>
            </div>
        </form>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const jenisSelect = document.getElementById('jenis');
                const nominalInput = document.getElementById('nominal');

                jenisSelect.addEventListener('change', function () {
                    const jenis = this.value;

                    if (jenis === 'pokok') {
                        nominalInput.value = 25000;
                        nominalInput.readOnly = true;
                    } else if (jenis === 'wajib') {
                        nominalInput.value = 50000;
                        nominalInput.readOnly = true;
                    } else {
                        nominalInput.value = '';
                        nominalInput.readOnly = false;
                    }
                });
            });
        </script>
    </div>
@endsection