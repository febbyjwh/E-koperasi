@extends('layout')

@section('title', 'Daftar Pelunasan Pinjaman Anggota')

@section('content')
<div class="p-4 bg-white rounded-2xl shadow-lg">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <h2 class="text-lg md:text-xl font-semibold text-gray-700">Daftar Pelunasan Pinjaman Anggota</h2>

        <form action="{{ route('pelunasan_anggota.index') }}" method="GET" class="max-w-md w-full mr-4">
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

        <a href="{{ route('pelunasan_anggota.create') }}"
            class="inline-block px-4 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300">
            Tambah Pelunasan
        </a>
    </div>

    <div class="overflow-x-auto w-full">
        <table class="min-w-full text-sm text-left text-gray-500 border rounded-lg">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th class="px-6 py-3">No</th>
                    <th class="px-6 py-3">Nama Anggota</th>
                    <th class="px-6 py-3">Jumlah Pinjaman</th>
                    <th class="px-6 py-3">Jumlah dibayar</th>
                    <th class="px-6 py-3">Sisa Cicilan</th>
                    <th class="px-6 py-3">Metode Pembayaran</th>
                    <th class="px-6 py-3">Tanggal Bayar</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Keterangan</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pelunasans as $i => $item)
                    @php
                        $jumlahPinjaman = $item->pinjaman->jumlah ?? 0;
                        $statusColor = match($item->status) {
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'terverifikasi' => 'bg-green-100 text-green-800',
                            'ditolak' => 'bg-red-100 text-red-800',
                            default => 'bg-gray-100 text-gray-800',
                        };
                    @endphp
                    <tr class="bg-white hover:bg-gray-50 border-b">
                        <td class="px-6 py-4">{{ $pelunasans->firstItem() + $i }}</td>
                        <td class="px-6 py-4">{{ $item->user->name ?? '-' }}</td>
                        <td class="px-6 py-4">Rp {{ number_format($jumlahPinjaman, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">Rp {{ number_format($item->jumlah_dibayar, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">Rp {{ number_format($item->sisa_pinjaman, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">{{ ucfirst($item->metode_pembayaran ?? 'Tunai') }}</td>
                        <td class="px-6 py-4">{{ \Carbon\Carbon::parse($item->tanggal_bayar)->format('d M Y') }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs rounded-full font-medium {{ $statusColor }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm">{{ $item->keterangan ?? '-' }}</td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{ route('pelunasan_anggota.edit', $item->id) }}" class="text-blue-600 hover:underline text-xs">Edit</a>
                                <a href="{{ route('pelunasan_anggota.show', $item->id) }}" class="text-green-600 hover:underline text-xs">Pelunasan</a>
                                <form action="{{ route('pelunasan_anggota.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline text-xs ml-2">Hapus</button>
                                </form>
                            </td>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12" class="px-6 py-4 text-center text-gray-500">Tidak ada data pelunasan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $pelunasans->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection