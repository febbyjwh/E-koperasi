@extends('layout')

@section('title', 'Pelunasan Pinjaman Anggota')

@section('content')
<div class="p-6 bg-white rounded-xl shadow-lg">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-sm md:text-xl font-semibold text-gray-700">
            Daftar Pelunasan Peminjaman Anggota
        </h2>

        {{-- ✅ Tombol Tambah Pelunasan --}}
        <a href="{{ route('pelunasan_anggota.create') }}"
           class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
            Tambah Pelunasan
        </a>
    </div>

    <table class="min-w-full table-auto border">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 border">No</th>
                <th class="px-4 py-2 border">Nama Anggota</th>
                <th class="px-4 py-2 border">ID Pinjaman</th>
                <th class="px-4 py-2 border">Jumlah Dibayar</th>
                <th class="px-4 py-2 border">Tanggal Bayar</th>
                <th class="px-4 py-2 border">Status</th>
                <th class="px-4 py-2 border">Keterangan</th>
                <th class="px-4 py-2 border">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pelunasans as $item)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2 border">{{ $item->user->name ?? '-' }}</td>
                    <td class="px-4 py-2 border">#{{ $item->pinjaman_id }}</td>
                    <td class="px-4 py-2 border">Rp {{ number_format($item->jumlah_dibayar, 0, ',', '.') }}</td>
                    <td class="px-4 py-2 border">{{ \Carbon\Carbon::parse($item->tanggal_bayar)->format('d M Y') }}</td>
                    
                    {{-- Status --}}
                    <td class="px-4 py-2 border capitalize">
                        @if($item->status === 'pending')
                            <form action="{{ route('pelunasan_anggota.konfirmasi', $item->id) }}" method="POST" class="flex gap-1">
                                @csrf
                                <button type="submit" name="status" value="terverifikasi"
                                    class="px-2 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-xs">
                                    Verifikasi
                                </button>
                                <button type="submit" name="status" value="ditolak"
                                    class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-xs">
                                    Tolak
                                </button>
                            </form>
                        @elseif($item->status === 'terverifikasi')
                            <span class="text-green-600 font-semibold">Terverifikasi</span>
                        @elseif($item->status === 'ditolak')
                            <span class="text-red-600 font-semibold">Ditolak</span>
                        @endif
                    </td>

                    {{-- Keterangan --}}
                    <td class="px-4 py-2 border">{{ $item->keterangan ?? '-' }}</td>

                    {{-- ✅ Aksi Edit & Delete --}}
                    <td class="px-4 py-2 border whitespace-nowrap">
                        <a href="{{ route('pelunasan_anggota.edit', $item->id) }}"
                           class="text-blue-600 hover:underline text-sm">Edit</a>

                        <form action="{{ route('pelunasan_anggota.destroy', $item->id) }}" method="POST"
                              class="inline-block ml-2"
                              onsubmit="return confirm('Yakin ingin menghapus data pelunasan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline text-sm">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center py-4 text-gray-500">
                        Belum ada data pelunasan pinjaman.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
