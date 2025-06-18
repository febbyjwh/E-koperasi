@extends('layout')

@section('title', 'Tambah Pelunasan Pinjaman')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded-xl shadow-lg">
    <h2 class="text-xl font-semibold mb-4 text-gray-700">Form Tambah Pelunasan</h2>

    <form action="{{ route('pelunasan_anggota.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label for="pinjaman_id" class="block text-sm font-medium text-gray-700">Pilih Pinjaman</label>
            <select name="pinjaman_id" id="pinjaman_id" required
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
                <option value="" disabled selected>-- Pilih Pinjaman --</option>
                @foreach($pinjamans as $pinjaman)
                    <option value="{{ $pinjaman->id }}">
                        #{{ $pinjaman->id }} - {{ $pinjaman->user->name }} (Rp {{ number_format($pinjaman->jumlah, 0, ',', '.') }})
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="tanggal_bayar" class="block text-sm font-medium text-gray-700">Tanggal Bayar</label>
            <input type="date" name="tanggal_bayar" id="tanggal_bayar" required
                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
        </div>

        <div>
            <label for="jumlah_dibayar" class="block text-sm font-medium text-gray-700">Jumlah Dibayar</label>
            <input type="number" name="jumlah_dibayar" id="jumlah_dibayar" required
                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200"
                   placeholder="Contoh: 500000">
        </div>

        <div>
            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
            <select name="status" id="status" required
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
                <option value="pending" selected>Pending</option>
                <option value="terverifikasi">Terverifikasi</option>
                <option value="ditolak">Ditolak</option>
            </select>
        </div>

        {{-- Keterangan --}}
        <div>
            <label for="keterangan" class="block text-sm font-medium text-gray-700">Keterangan</label>
            <textarea name="keterangan" id="keterangan" rows="3"
                      class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200"
                      placeholder="Opsional...">{{ old('keterangan') }}</textarea>
        </div>

        <div class="flex justify-end">
            <a href="{{ route('pelunasan_anggota.index') }}"
               class="px-4 py-2 text-gray-600 hover:underline mr-2">Batal</a>
            <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection
