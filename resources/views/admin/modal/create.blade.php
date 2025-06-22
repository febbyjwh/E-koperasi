@extends('layout')

@section('title','Tambah Modal Utama')

@section('content')
<div class="p-6 bg-white rounded-2xl shadow-lg w-full">
    <h2 class="text-xl font-semibold text-gray-700 mb-4">Tambah Sumber Modal</h2>

    <form action="{{ route('modal.store')}}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" 
                   class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200"
                   value="{{ old('tanggal', date('Y-m-d')) }}" required>
        </div>

        <div>
            <label for="jumlah" class="block text-sm font-medium text-gray-700">Jumlah Modal</label>
            <input type="number" name="jumlah" id="jumlah" 
                   class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200"
                   placeholder="Contoh: 5000000" required>
        </div>

        <div>
            <label for="keterangan" class="block text-sm font-medium text-gray-700">Keterangan</label>
            <textarea name="keterangan" id="keterangan" rows="3"
                      class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200"
                      placeholder="Contoh: Modal awal koperasi atau hasil pelunasan pinjaman" required>{{ old('keterangan') }}</textarea>
        </div>

        <div>
            <label for="sumber" class="block text-sm font-medium text-gray-700">Sumber Dana</label>
            <select name="sumber" id="sumber" required 
                    class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200">
                <option value="">-- Pilih Sumber --</option>
                <option value="modal_awal">Modal Awal</option>
                <option value="pelunasan">Pelunasan Pinjaman</option>
                <option value="lainnya">Lainnya</option>
            </select>
        </div>

        <div>
            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
            <select name="status" id="status" required
                    class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200">
                <option value="">-- Pilih Status --</option>
                <option value="masuk">Masuk</option>
                <option value="pending">Pending</option>
                <option value="ditolak">Ditolak</option>
                <option value="keluar">Keluar</option>
            </select>
        </div>

        <div class="flex justify-end space-x-2">
            <a href="{{ route('modal.index') }}" 
               class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">Batal</a>
            <button type="submit" 
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
        </div>
    </form>
</div>
@endsection
