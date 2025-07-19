@extends('layout')

@section('title', 'Ajukan Pinjaman')

@section('content')
<div class="p-6 bg-white rounded-2xl shadow-lg w-full">
    <h2 class="text-2xl font-semibold mb-6 text-gray-700">Form Pengajuan Pinjaman</h2>

    <form action="{{ route('pengajuan_pinjaman.store') }}" method="POST" class="space-y-4">
        @csrf

        {{-- Pilih Anggota --}}
        <div>
            <label for="user_id" class="block text-sm font-medium text-gray-700">Nama Anggota</label>
            <select name="user_id" id="user_id"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200"
                    required>
                <option value="">-- Pilih Anggota --</option>
                @foreach ($anggota as $user)
                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }} ({{ $user->username }})
                    </option>
                @endforeach
            </select>
            @error('user_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Jenis Pinjaman --}}
        <div>
            <label for="jenis_pinjaman" class="block text-sm font-medium text-gray-700">Jenis Pinjaman</label>
            <select name="jenis_pinjaman" id="jenis_pinjaman"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200"
                    required>
                <option value="">-- Pilih Jenis --</option>
                <option value="kms" {{ old('jenis_pinjaman') == 'kms' ? 'selected' : '' }}>Kredit Manasuka (KMS)</option>
                <option value="barang" {{ old('jenis_pinjaman') == 'barang' ? 'selected' : '' }}>Kredit Barang</option>
            </select>
            @error('jenis_pinjaman')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Jumlah pinjaman --}}
        <div>
            <label for="jumlah" class="block text-sm font-medium text-gray-700">Jumlah Pinjaman</label>
            <input type="number" name="jumlah" id="jumlah"
                   value="{{ old('jumlah') }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200"
                   placeholder="Masukkan jumlah pinjaman" required>
            @error('jumlah')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Lama angsuran --}}
        <div>
            <label for="lama_angsuran" class="block text-sm font-medium text-gray-700">Lama Angsuran (bulan)</label>
            <input type="number" name="lama_angsuran" id="lama_angsuran"
                   value="{{ old('lama_angsuran') }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200"
                   placeholder="Contoh: 12" required>
            @error('lama_angsuran')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Tujuan --}}
        <div>
            <label for="tujuan" class="block text-sm font-medium text-gray-700">Tujuan Pinjaman</label>
            <textarea name="tujuan" id="tujuan" rows="3"
                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200"
                      placeholder="Contoh: Modal usaha, biaya pendidikan, dll." required>{{ old('tujuan') }}</textarea>
            @error('tujuan')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Tombol --}}
        <div class="flex justify-end">
            <button type="submit"
                class="bg-teal-600 hover:bg-teal-700 text-white font-semibold py-2 px-4 rounded-full">
                Ajukan
            </button>
            <a href="{{ route('pengajuan_pinjaman.index') }}" 
               class="px-4 py-2 text-gray-600 hover:underline">Batal
            </a>
        </div>
    </form>
</div>
@endsection
