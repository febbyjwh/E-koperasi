@extends('layout')

@section('title', 'Edit Pengajuan Pinjaman')

@section('content')
<div class="p-6 bg-white rounded-2xl shadow-lg max-w-2xl mx-auto">
    <h2 class="text-2xl font-semibold mb-6 text-gray-700">Edit Pengajuan Pinjaman</h2>

    <form action="{{ route('pengajuan_pinjaman.update', $pengajuan->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        {{-- Pilih Anggota --}}
        <div>
            <label for="user_id" class="block text-sm font-medium text-gray-700">Nama Anggota</label>
            <select name="user_id" id="user_id"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200"
                    required>
                <option value="">-- Pilih Anggota --</option>
                @foreach ($anggota as $user)
                    <option value="{{ $user->id }}" {{ $pengajuan->user_id == $user->id ? 'selected' : '' }}>
                        {{ $user->name }} ({{ $user->username }})
                    </option>
                @endforeach
            </select>
            @error('user_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Jumlah pinjaman --}}
        <div>
            <label for="jumlah" class="block text-sm font-medium text-gray-700">Jumlah Pinjaman</label>
            <input type="number" name="jumlah" id="jumlah"
                   value="{{ old('jumlah', $pengajuan->jumlah) }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200"
                   required>
            @error('jumlah')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Lama angsuran --}}
        <div>
            <label for="lama_angsuran" class="block text-sm font-medium text-gray-700">Lama Angsuran (bulan)</label>
            <input type="number" name="lama_angsuran" id="lama_angsuran"
                   value="{{ old('lama_angsuran', $pengajuan->lama_angsuran) }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200"
                   required>
            @error('lama_angsuran')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Tujuan --}}
        <div>
            <label for="tujuan" class="block text-sm font-medium text-gray-700">Tujuan Pinjaman</label>
            <textarea name="tujuan" id="tujuan" rows="3"
                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200"
                      required>{{ old('tujuan', $pengajuan->tujuan) }}</textarea>
            @error('tujuan')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Tanggal Pengajuan --}}
        <div>
            <label for="tanggal_pengajuan" class="block text-sm font-medium text-gray-700">Tanggal Pengajuan</label>
            <input type="date" name="tanggal_pengajuan" id="tanggal_pengajuan"
                   value="{{ old('tanggal_pengajuan', \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->format('Y-m-d')) }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200"
                   required>
            @error('tanggal_pengajuan')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Tombol --}}
        <div class="flex justify-end">
            <a href="{{ route('pengajuan_pinjaman.index') }}" 
               class="px-4 py-2 text-gray-600 hover:underline mr-2">Batal</a>
            <button type="submit"
                    class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection