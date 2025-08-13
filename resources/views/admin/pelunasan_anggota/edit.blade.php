@extends('layout')

@section('title', 'Edit Pelunasan')

@section('content')

    @php
        // Ambil tanggal pelunasan atau tanggal pinjaman sesuai kebutuhan
        $tanggal = \Carbon\Carbon::parse($pelunasan->tanggal_pelunasan ?? $pelunasan->created_at);
        // Format sama dengan bukti pinjaman
        $invoiceId = 'PINDA' . str_pad($pelunasan->pinjaman_id, 3, '0', STR_PAD_LEFT) . '-' . $tanggal->format('dmY');
    @endphp

    <div class="p-6 bg-white rounded-xl shadow-lg overflow-x-auto">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold text-gray-700">Edit Pelunasan Pinjaman Anggota</h2>
        </div>

        <form action="{{ route('pelunasan_anggota.update', $pelunasan->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Nama Anggota (readonly) --}}
            <div class="mb-4">
                <label class="block text-sm text-gray-600 mb-1">Nama Anggota</label>
                <input type="text" value="{{ $pelunasan->user->name ?? '-' }}" disabled
                    class="w-full px-3 py-2 border rounded bg-gray-100 text-gray-700">
            </div>

            {{-- ID Pinjaman --}}
            <div type="hidden" class="mb-4">
                {{-- <label class="block text-sm text-gray-600 mb-1">ID Pinjaman</label> --}}
                <input type="hidden" name="pinjaman_id" value="{{ old('pinjaman_id', $pelunasan->pinjaman_id) }}"
                    class="w-full px-3 py-2 border rounded @error('pinjaman_id') border-red-500 @enderror">
                @error('pinjaman_id')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- ID Pelunasan (hanya tampil) --}}
            <div class="mb-4">
                <label class="block text-sm text-gray-600 mb-1">ID Pelunasan</label>
                <input type="text" value="{{ $invoiceId }}" readonly
                    class="w-full px-3 py-2 border rounded bg-gray-100 text-gray-700">
            </div>

            {{-- Jumlah Dibayar --}}
            <div class="mb-4">
                <label class="block text-sm text-gray-600 mb-1">Jumlah Dibayar</label>
                <input type="number" name="jumlah_dibayar" value="{{ old('jumlah_dibayar', $pelunasan->jumlah_dibayar) }}"
                    class="w-full px-3 py-2 border rounded @error('jumlah_dibayar') border-red-500 @enderror">
                @error('jumlah_dibayar')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Metode Pembayaran --}}
            <div class="mb-4">
                <label class="block text-sm text-gray-600 mb-1">Metode Pembayaran</label>
                <input type="text" name="metode_pembayaran"
                    value="{{ old('metode_pembayaran', $pelunasan->metode_pembayaran) }}"
                    class="w-full px-3 py-2 border rounded @error('metode_pembayaran') border-red-500 @enderror">
                @error('metode_pembayaran')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tanggal Bayar --}}
            {{-- <div class="mb-4">
            <label class="block text-sm text-gray-600 mb-1">Tanggal Bayar</label>
            <input type="date" name="tanggal_bayar" value="{{ old('tanggal_bayar', $pelunasan->tanggal_bayar) }}"
                   class="w-full px-3 py-2 border rounded @error('tanggal_bayar') border-red-500 @enderror">
            @error('tanggal_bayar')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div> --}}

            {{-- Status --}}
            {{-- <div class="mb-4">
            <label class="block text-sm text-gray-600 mb-1">Status</label>
            <select name="status"
                    class="w-full px-3 py-2 border rounded @error('status') border-red-500 @enderror">
                <option value="pending" {{ $pelunasan->status === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="terverifikasi" {{ $pelunasan->status === 'terverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
                <option value="ditolak" {{ $pelunasan->status === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
            </select>
            @error('status')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div> --}}

            {{-- Keterangan --}}
            <div class="mb-4">
                <label class="block text-sm text-gray-600 mb-1">Keterangan</label>
                <textarea name="keterangan" rows="3"
                    class="w-full px-3 py-2 border rounded @error('keterangan') border-red-500 @enderror">{{ old('keterangan', $pelunasan->keterangan) }}</textarea>
                @error('keterangan')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol Submit --}}
            <div class="flex justify-end gap-2">
                <button type="submit"
                    class="bg-teal-600 text-white px-6 py-2 rounded-full hover:bg-teal-700 cursor-pointer">Perbaharui</button>
                <a href="{{ route('pelunasan_anggota.index') }}"
                    class="px-4 py-2 text-gray-600 hover:underline cursor-pointer">
                    Kembali
                </a>
            </div>
        </form>
    </div>
@endsection
