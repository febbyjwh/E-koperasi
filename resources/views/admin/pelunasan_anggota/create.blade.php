@extends('layout')

@section('title', 'Tambah Pelunasan Pinjaman')

@section('content')


<div class="p-6 bg-white rounded-2xl shadow-lg overflow-x-auto">
    <h2 class="text-xl font-semibold mb-6 text-gray-700">Form Tambah Pelunasan Pinjaman</h2>

    <form action="{{ route('pelunasan_anggota.store') }}" method="POST" class="space-y-5">
        @csrf

        {{-- Pilih Pinjaman --}}
        <div>
            <label for="pinjaman_id" class="block text-sm font-medium text-gray-700">Pilih Pinjaman</label>
            <select name="pinjaman_id" id="pinjaman_id" required
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
                <option value="" disabled selected>-- Pilih Nama Peminjam --</option>
                @foreach($pinjamans as $pinjaman)
                    <option value="{{ $pinjaman->id }}">
                        #{{ $pinjaman->id }} - {{ $pinjaman->user->name }} (Rp {{ number_format($pinjaman->jumlah, 0, ',', '.') }})
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Tanggal Bayar --}}
        <div>
            <label for="tanggal_bayar" class="block text-sm font-medium text-gray-700">Tanggal Bayar</label>
            <input type="date" name="tanggal_bayar" id="tanggal_bayar" required
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
        </div>

        {{-- Jumlah Dibayar --}}
        <div>
            <label for="jumlah_dibayar" class="block text-sm font-medium text-gray-700">Jumlah Dibayar</label>
            <input type="number" name="jumlah_dibayar" id="jumlah_dibayar" required
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200"
                placeholder="Contoh: 500000">
        </div>

        {{-- Keterangan --}}
        <div>
            <label for="keterangan" class="block text-sm font-medium text-gray-700">Keterangan (Opsional)</label>
            <textarea name="keterangan" id="keterangan" rows="3"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200"
                placeholder="Contoh: Pembayaran via teller bank">{{ old('keterangan') }}</textarea>
        </div>

        {{-- Tombol --}}
        <div class="flex justify-end gap-2">
            <a href="{{ route('pelunasan_anggota.index') }}"
               class="px-4 py-2 text-gray-600 hover:underline cursor-pointer">Batal</a>
            <button type="submit"
                class="px-4 py-2 bg-teal-600 text-white rounded-full hover:bg-teal-700 transition cursor-pointer">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection