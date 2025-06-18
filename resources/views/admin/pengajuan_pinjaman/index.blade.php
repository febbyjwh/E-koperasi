@extends('layout')

@section('title', 'Konfirmasi Pengajuan Pinjaman')

@section('content')
<div class="p-6 bg-white rounded-2xl shadow-lg overflow-x-auto">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-sm md:text-xl font-semibold text-gray-700">Daftar Pengajuan Pinjaman</h2>
        <a href="{{ route('pengajuan_pinjaman.create') }}"
           class="inline-block px-2 sm:px-4 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300">
            Tambah Pengajuan
        </a>
    </div>

    <table class="min-w-full border rounded">
        <thead>
            <tr class="bg-gray-100 text-gray-700">
                <th class="px-4 py-2 border">No</th>
                <th class="px-4 py-2 border">Nama</th>
                <th class="px-4 py-2 border">Jumlah</th>
                <th class="px-4 py-2 border">Tenor</th>
                <th class="px-4 py-2 border">Tujuan</th>
                <th class="px-4 py-2 border">Tanggal</th>
                <th class="px-4 py-2 border">Status</th>
                <th class="px-4 py-2 border">Konfirmasi</th>
                <th class="px-4 py-2 border">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pengajuan as $item)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2 border">{{ $item->user->name ?? '-' }}</td>
                    <td class="px-4 py-2 border">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                    <td class="px-4 py-2 border">{{ $item->lama_angsuran }} bulan</td>
                    <td class="px-4 py-2 border">{{ $item->tujuan }}</td>
                    <td class="px-4 py-2 border">{{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->format('d M Y') }}</td>
                    <td class="px-4 py-2 border capitalize">
                        <span class="@if($item->status === 'pending') text-yellow-500 
                                    @elseif($item->status === 'disetujui') text-green-600 
                                    @elseif($item->status === 'ditolak') text-red-600 
                                    @else text-gray-500 @endif">
                            {{ $item->status ?? '-' }}
                        </span>
                    </td>
                    {{-- Konfirmasi Setujui / Tolak --}}
                    <td class="px-4 py-2 border">
                        <form action="{{ route('pengajuan_pinjaman.konfirmasi', $item->id) }}" method="POST" class="flex gap-2">
                            @csrf
                            @method('PATCH')
                            <button name="status" value="disetujui"
                                    class="px-2 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-sm">
                                Setujui
                            </button>
                            <button name="status" value="ditolak"
                                    class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-sm">
                                Tolak
                            </button>
                        </form>
                    </td>
                    {{-- Aksi Edit / Delete --}}
                    <td class="px-4 py-2 border text-center">
                        <a href="{{ route('pengajuan_pinjaman.edit', $item->id) }}"
                           class="text-blue-600 hover:underline text-sm">Edit</a>
                        <form action="{{ route('pengajuan_pinjaman.destroy', $item->id) }}" method="POST"
                              class="inline-block"
                              onsubmit="return confirm('Yakin ingin menghapus pengajuan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="text-red-600 hover:underline text-sm ml-2">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center py-4 text-gray-500">
                        Tidak ada pengajuan yang menunggu konfirmasi.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection