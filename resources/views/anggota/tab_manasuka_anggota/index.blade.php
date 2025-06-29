@extends('layout')

@section('title', 'Tabungan Saya')

@section('content')
<div class="p-4 bg-white rounded-2xl shadow-lg">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-sm md:text-xl font-semibold text-gray-700">Tabungan Saya</h2>
        
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
    </div>

    <div class="overflow-x-auto w-full">
        <table class="min-w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th class="px-6 py-3">No</th>
                    <th class="px-6 py-3">Nama</th>
                    <th class="px-6 py-3">Nominal Masuk</th>
                    <th class="px-6 py-3">Nominal Keluar</th>
                    <th class="px-6 py-3">Total</th>
                    <th class="px-6 py-3">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tabunganManasuka as $tabungan)
                    <tr class="bg-white hover:bg-gray-50">
                        <td class="px-6 py-4">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4">{{ $tabungan->anggota->name ?? '-' }}</td>
                        <td class="px-6 py-4">Rp {{ number_format($tabungan->nominal_masuk, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">Rp {{ number_format($tabungan->nominal_keluar, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 font-semibold">Rp {{ number_format($tabungan->total, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">{{ \Carbon\Carbon::parse($tabungan->tanggal)->format('d M Y') }}</td>
                    </tr>
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