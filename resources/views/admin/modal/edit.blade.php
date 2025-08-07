@extends('layout')

@section('title','Edit Modal Utama')

@section('content')


<div class="p-6 bg-white rounded-2xl shadow-lg overflow-x-auto">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-semibold text-gray-700">Edit Modal</h2>
    </div>

    <form action="{{ route('modal.update', $modal->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal"
                   class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200"
                   value="{{ old('tanggal', $modal->tanggal) }}" required>
        </div>

        <div>
            <label for="jumlah" class="block text-sm font-medium text-gray-700">Jumlah Modal</label>
            <input type="number" name="jumlah" id="jumlah"
                   class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200"
                   value="{{ old('jumlah', $modal->jumlah) }}" required>
        </div>

        <div>
            <label for="keterangan" class="block text-sm font-medium text-gray-700">Keterangan</label>
            <textarea name="keterangan" id="keterangan" rows="3"
                      class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200"
                      required>{{ old('keterangan', $modal->keterangan) }}</textarea>
        </div>

        <div>
            <label for="sumber" class="block text-sm font-medium text-gray-700">Sumber Dana</label>
            <select name="sumber" id="sumber" required
                    class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200">
                <option value="">-- Pilih Sumber --</option>
                <option value="modal_awal" {{ old('sumber', $modal->sumber) == 'modal_awal' ? 'selected' : '' }}>Modal Awal</option>
                <option value="pelunasan" {{ old('sumber', $modal->sumber) == 'pelunasan' ? 'selected' : '' }}>Pelunasan Pinjaman</option>
                <option value="lainnya" {{ old('sumber', $modal->sumber) == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
            </select>
        </div>

        <div>
            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
            <select name="status" id="status" required
                    class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200">
                <option value="">-- Pilih Status --</option>
                <option value="masuk" {{ old('status', $modal->status) == 'masuk' ? 'selected' : '' }}>Masuk</option>
                <option value="keluar" {{ old('status', $modal->status) == 'keluar' ? 'selected' : '' }}>Keluar</option>
                <option value="pending" {{ old('status', $modal->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="ditolak" {{ old('status', $modal->status) == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
            </select>
        </div>

        <div class="flex justify-end space-x-2">
            <button type="submit" 
                class="bg-teal-600 hover:bg-teal-700 text-white font-semibold py-2 px-4 rounded-full">Update
            </button>
            <a href="{{ route('modal.index') }}"
                class="px-4 py-2 text-gray-600 hover:underline">
                Kembali
            </a>
        </div>
    </form>
</div>
@endsection
