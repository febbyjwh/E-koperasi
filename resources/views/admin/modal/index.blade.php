@extends('layout')

@section('title','Modal Masuk')

@section('content')
<div class="p-4 bg-white rounded-2xl shadow-lg">
    {{-- Total Masuk & Keluar --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-green-100 border border-green-300 rounded-xl p-4 shadow-sm">
            <h3 class="text-sm font-semibold text-green-700 mb-1">Total Uang Masuk</h3>
            <p class="text-xl font-bold text-green-900">Rp {{ number_format($totalMasuk, 0, ',', '.') }}</p>
        </div>
        <div class="bg-red-100 border border-red-300 rounded-xl p-4 shadow-sm">
            <h3 class="text-sm font-semibold text-red-700 mb-1">Total Uang Keluar</h3>
            <p class="text-xl font-bold text-red-900">Rp {{ number_format($totalKeluar, 0, ',', '.') }}</p>
        </div>
        <div class="bg-blue-100 border border-blue-400 rounded-xl p-4 shadow">
            <h3 class="text-sm text-blue-700 font-semibold">Total Saldo</h3>
            <p class="text-xl font-bold text-blue-800">Rp {{ number_format($saldo, 0, ',', '.') }}</p>
        </div>
    </div>
    

    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg md:text-xl font-semibold text-gray-700">Modal Utama</h2>
        
        <form action="{{ route('modal.index') }}" method="GET" class="max-w-md w-full mr-4">
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

        <a href="{{ route('modal.create') }}"
           class="inline-block px-4 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300">
            Tambah Modal
        </a>
    </div>

    <div class="overflow-x-auto w-full">
        <table class="min-w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th class="px-6 py-3">No</th>
                    <th class="px-6 py-3">Tanggal</th>
                    <th class="px-6 py-3">Jumlah</th>
                    <th class="px-6 py-3">Keterangan</th>
                    <th class="px-6 py-3">Sumber</th>
                    <th class="px-6 py-3">Petugas</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($modals as $modal)
                    <tr class="bg-white hover:bg-gray-50 border-b">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4">{{ \Carbon\Carbon::parse($modal->tanggal)->format('d-m-Y') }}</td>
                        <td class="px-6 py-4">Rp {{ number_format($modal->jumlah, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">{{ $modal->keterangan ?? '-' }}</td>
                        <td class="px-6 py-4 capitalize">{{ $modal->sumber ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $modal->user->username ?? '-' }}</td>
                        <td class="px-6 py-4">
                            @switch($modal->status)
                                @case('masuk')
                                    <span class="bg-green-100 text-green-800 px-2 py-1 text-xs rounded-full font-medium">Masuk</span>
                                    @break
                                @case('keluar')
                                    <span class="bg-red-100 text-red-800 px-2 py-1 text-xs rounded-full font-medium">Keluar</span>
                                    @break
                                @case('pending')
                                    <span class="bg-yellow-100 text-yellow-800 px-2 py-1 text-xs rounded-full font-medium">Pending</span>
                                    @break
                                @case('ditolak')
                                    <span class="bg-gray-100 text-gray-800 px-2 py-1 text-xs rounded-full font-medium">Ditolak</span>
                                    @break
                                @default
                                    <span class="text-gray-500 text-sm">-</span>
                            @endswitch
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('modal.edit', $modal->id) }}" class="font-medium text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('modal.destroy', $modal->id) }}" method="POST" class="inline-block"
                                  onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="font-medium text-red-600 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-gray-600">Belum ada data modal.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection