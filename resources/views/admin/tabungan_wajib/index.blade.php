@extends('layout')

@section('title', 'Tabungan Wajib')

@section('content')
<div class="p-4 bg-white rounded-2xl shadow-lg">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-sm md:text-xl font-semibold text-gray-700">Daftar Setoran Tabungan Wajib</h2>
        
        <form action="{{ route('tabungan_wajib.tabungan_wajib') }}" method="GET" class="max-w-md w-full mr-4">
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

        <a href="{{ route('tabungan_wajib.create') }}"
           class="inline-block px-4 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300">
            Tambah Setoran
        </a>
    </div>

    <div class="overflow-x-auto w-full">
        <table class="min-w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th class="px-6 py-3">No</th>
                    <th class="px-6 py-3">Nama Anggota</th>
                    <th class="px-6 py-3">Jenis Setoran</th>
                    <th class="px-6 py-3">Nominal</th>
                    <th class="px-6 py-3">Total</th>
                    <th class="px-6 py-3">Tanggal</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($setoranWajib as $setoran)
                    <tr class="bg-white hover:bg-gray-50">
                        <td class="px-6 py-4">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4">{{ $setoran->anggota->name ?? '-' }}</td>
                        <td class="px-6 py-4 capitalize">{{ $setoran->jenis }}</td>
                        <td class="px-6 py-4">Rp {{ number_format($setoran->nominal, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">Rp {{ number_format($setoran->total, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">{{ \Carbon\Carbon::parse($setoran->tanggal)->format('d M Y') }}</td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('tabungan_wajib.edit', $setoran->id) }}"
                               class="font-medium text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('tabungan_wajib.destroy', $setoran->id) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Yakin ingin menghapus setoran ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="font-medium text-red-600 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-gray-500 py-4">Belum ada data tabungan wajib.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
