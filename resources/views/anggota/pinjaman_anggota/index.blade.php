@extends('layout')

@section('title', 'Pengajuan Pinjaman')

@section('content')
<div class="p-4 bg-white rounded-2xl shadow-lg w-full">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-sm md:text-xl font-semibold text-gray-700">Daftar Pengajuan Pinjaman</h2>
        
        <form action="{{ route('pinjaman_anggota.index') }}" method="GET" class="max-w-md w-full mr-4">
            <div class="relative">
                <input type="text" name="search" value="{{ request('search') }}"
                    class="block w-full p-3 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Cari nama anggota...">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <button type="submit" style="cursor: pointer"
                    class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-lightgray-700 text-gray font-medium rounded-lg text-sm px-4 py-2 h-10">
                    Cari
                </button>   
            </div>
        </form>

        <a href="{{ route('pinjaman_anggota.create') }}"
           class="inline-block px-4 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300">
            Ajukan Pinjaman
        </a>
    </div>

    <div class="overflow-x-auto w-full">
        <table class="min-w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th class="px-6 py-3">No</th>
                    <th class="px-6 py-3">Atas Nama</th>
                    <th class="px-6 py-3">Jenis Kredit</th>
                    <th class="px-6 py-3">Jumlah Pinjaman</th>
                    <th class="px-6 py-3">Jumlah Harus Dibayar</th>
                    <th class="px-6 py-3">Jumlah Diterima</th>
                    <th class="px-6 py-3">Tenor</th>
                    <th class="px-6 py-3">Tujuan</th>
                    <th class="px-6 py-3">Tanggal</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Bukti</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pengajuan as $item)
                    <tr class="bg-white hover:bg-gray-50">
                        <td class="px-6 py-4">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4">{{ $item->user->name ?? '-' }}</td>
                        <td class="px-6 py-4 capitalize">{{ $item->jenis_pinjaman }}</td>
                        <td class="px-6 py-4">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">Rp {{ number_format($item->jumlah_harus_dibayar, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">Rp {{ number_format($item->jumlah_diterima, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">{{ $item->lama_angsuran }} bulan</td>
                        <td class="px-6 py-4">{{ $item->tujuan }}</td>
                        <td class="px-6 py-4">{{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->format('d M Y') }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-block px-3 py-1 text-xs rounded-full
                                @if ($item->status === 'pending') bg-yellow-100 text-yellow-700
                                @elseif ($item->status === 'disetujui') bg-green-100 text-green-700
                                @elseif ($item->status === 'ditolak') bg-red-100 text-red-700
                                @elseif ($item->status === 'keluar') bg-blue-100 text-blue-700
                                @endif">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if ($item->status === 'disetujui')
                                <a href="{{ route('pinjaman_anggota.bukti', $item->id) }}"
                                class="text-blue-600 hover:underline text-xs">
                                    Lihat Bukti
                                </a>
                            @else
                                <span class="text-gray-400 text-xs italic">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center text-gray-500 py-4">Belum ada pengajuan pinjaman.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
