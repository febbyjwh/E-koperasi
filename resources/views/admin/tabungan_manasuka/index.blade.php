@extends('layout')

@section('title', 'Tabungan Manasuka')

@section('content')
<div class="p-4 bg-white rounded-2xl shadow-lg">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-sm md:text-xl font-semibold text-gray-700">Daftar Tabungan Manasuka</h2>
        
        <form action="{{ route('tabungan_manasuka.tabungan_manasuka') }}" method="GET" class="max-w-md w-full mr-4">
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

        <a href="{{ route('tabungan_manasuka.create') }}"
           class="inline-block px-4 py-2 text-sm bg-blue-600 text-white rounded-full hover:bg-blue-700 transition duration-300">
            Tambah Tabungan
        </a>
    </div>

    <div class="overflow-x-auto w-full">
        <table class="min-w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th class="px-6 py-3">No</th>
                    <th class="px-6 py-3">Nama Anggota</th>
                    <th class="px-6 py-3">Nominal Masuk</th>
                    <th class="px-6 py-3">Nominal Keluar</th>
                    <th class="px-6 py-3">Total</th>
                    <th class="px-6 py-3">Tanggal</th>
                    <th class="px-0 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $grouped = $tabunganManasuka->groupBy('user_id');
                    $groupIndex = 1;
                @endphp

                @forelse ($grouped as $userId => $items)
                    {{-- Baris khusus nama anggota --}}
                    <tr class="bg-blue-100">
                        <td class="px-6 py-2"></td>
                        <td class="px-6 py-2 font-bold text-gray-800">{{ $items->first()->anggota->name ?? '-' }}</td>
                        <td colspan="5"></td>
                    </tr>

                    @foreach ($items as $i => $tabungan)
                        <tr class="bg-white hover:bg-gray-50">
                            <td class="px-6 py-4">{{ $groupIndex }}.{{ $loop->iteration }}</td>
                            <td class="px-6 py-4"></td>
                            <td class="px-6 py-4 {{ $tabungan->nominal_masuk > 0 ? 'text-green-600 font-medium' : '' }}">
                                Rp {{ number_format($tabungan->nominal_masuk, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 {{ $tabungan->nominal_keluar > 0 ? 'text-red-600 font-medium' : '' }}">
                                Rp {{ number_format($tabungan->nominal_keluar, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 font-semibold">
                                Rp {{ number_format($tabungan->total, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4">
                                {{ \Carbon\Carbon::parse($tabungan->tanggal)->format('d M Y') }}
                            </td>
                            <td class="px-0 py-4 space-x-2">
                                <a href="{{ route('tabungan_manasuka.edit', $tabungan->id) }}"
                                class="text-white bg-green-700 hover:bg-green-800 focus:outline-none font-medium rounded-full text-sm px-5 py-1 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Edit</a>
                                <form action="{{ route('tabungan_manasuka.destroy', $tabungan->id) }}" method="POST"
                                    class="inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-white bg-red-700 hover:bg-red-800 focus:outline-none font-medium rounded-full text-sm px-5 py-1 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    @php
                        $totalSaldo = $items->sum('nominal_masuk') - $items->sum('nominal_keluar');
                    @endphp
                    <tr class="bg-gray-100">
                        <td colspan="7" class="px-6 py-2 font-semibold text-right text-gray-700">
                            Total Saldo {{ $items->first()->anggota->name ?? 'Anggota' }}:
                            <span class="text-blue-700">Rp {{ number_format($totalSaldo, 0, ',', '.') }}</span>
                        </td>
                    </tr>

                    @php $groupIndex++; @endphp
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-gray-500 py-4">Belum ada data tabungan manasuka.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection