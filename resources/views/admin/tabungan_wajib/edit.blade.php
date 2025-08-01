@extends('layout')

@section('title', 'Edit Setoran Tabungan Wajib')

@section('content')
@include('components.alert')

<div class="p-6 bg-white rounded-2xl shadow-lg w-full">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-semibold text-gray-700">Edit Tabungan Wajib</h2>
    </div>

    <form action="{{ route('tabungan_wajib.update', $setoran->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label for="user_id" class="block mb-1 text-sm font-medium text-gray-700">Nama Anggota</label>
            <select name="user_id" id="user_id"
                class="w-full p-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500">
                <option value="">-- Pilih Anggota --</option>
                @foreach($anggota as $item)
                    <option value="{{ $item->id }}" {{ $item->id == $setoran->user_id ? 'selected' : '' }}>
                        {{ $item->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="jenis" class="block mb-1 text-sm font-medium text-gray-700">Jenis Setoran</label>
            <select name="jenis" id="jenis"
                class="w-full p-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500">
                <option value="">-- Pilih Jenis --</option>
                <option value="pokok" {{ $setoran->jenis == 'pokok' ? 'selected' : '' }}>Iuran Pokok</option>
                <option value="wajib" {{ $setoran->jenis == 'wajib' ? 'selected' : '' }}>Tabungan Wajib</option>
                <option value="dakem" {{ $setoran->jenis == 'dakem' ? 'selected' : '' }}>Dakem</option>
            </select>
        </div>

        <div>
            <label for="nominal" class="block mb-1 text-sm font-medium text-gray-700">Nominal Setoran</label>
            <input type="number" name="nominal" id="nominal" required min="1"
                class="w-full p-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500"
                value="{{ $setoran->nominal }}">
        </div>

        <div>
            <label for="tanggal" class="block mb-1 text-sm font-medium text-gray-700">Tanggal Setoran</label>
            <input type="date" name="tanggal" id="tanggal" required
                class="w-full p-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500"
                value="{{ $setoran->tanggal }}">
        </div>

        <div class="flex justify-end gap-2">
            <button 
            type="submit" class="bg-teal-600 hover:bg-teal-700 text-white font-semibold py-2 px-4 rounded-full">Perbarui</button>
            <a href="{{ route('tabungan_wajib.tabungan_wajib') }}"
                class="px-4 py-2 text-gray-600 hover:underline">
                Kembali
            </a>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const jenisSelect = document.getElementById('jenis');
        const nominalInput = document.getElementById('nominal');

        function handleJenisChange() {
            const jenis = jenisSelect.value;
            if (jenis === 'pokok') {
                nominalInput.value = 25000;
                nominalInput.readOnly = true;
            } else if (jenis === 'wajib') {
                nominalInput.value = 50000;
                nominalInput.readOnly = true;
            } else {
                nominalInput.readOnly = false;
            }
        }

        jenisSelect.addEventListener('change', handleJenisChange);
        handleJenisChange(); // Jalankan saat halaman dimuat
    });
</script>
@endsection