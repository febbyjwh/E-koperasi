@extends('layout')

@section('title', 'Daftar Pelunasan Pinjaman Anggota')

@section('content')
    {{-- @include('components.alert') --}}

    @once
        @include('components.modal')
    @endonce

    <div class="p-4 bg-white rounded-2xl shadow-lg">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <h2 class="text-lg md:text-xl font-semibold text-gray-700">Daftar Pelunasan Pinjaman Anggota</h2>

            <form action="{{ route('pelunasan_anggota.index') }}" method="GET" class="max-w-md w-full mr-4">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="block w-full p-3 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Cari...">
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
                class="inline-block px-4 py-2 text-sm bg-blue-600 text-white rounded-full hover:bg-blue-700 transition duration-300">
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
                        <th class="px-6 py-3">Tanggal Pengajuan</th>
                        <th class="px-6 py-3">Tanggal Dikonfirmasi</th>
                        <th class="px-6 py-3">Tanggal Dibayar</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Keterangan</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pelunasans as $i => $item)
                        @php
                            $jumlahPinjaman = $item->pinjaman->jumlah ?? 0;
                            $statusColor = match ($item->status) {
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'terverifikasi' => 'bg-blue-100 text-blue-800',
                                'lunas' => 'bg-green-100 text-green-800',
                                'ditolak' => 'bg-red-100 text-red-800',
                                default => 'bg-yellow-100 text-yellow-800',
                            };
                        @endphp
                        <tr class="bg-white hover:bg-gray-50 border-b">
                            <td class="px-6 py-4">
                                {{ $pelunasans->firstItem() ? $pelunasans->firstItem() + $i : $i + 1 }}
                            </td>
                            <td class="px-6 py-4">{{ $item->user->name ?? '-' }}</td>
                            <td class="px-6 py-4">Rp {{ number_format($jumlahPinjaman, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">Rp {{ number_format($item->jumlah_dibayar, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">Rp {{ number_format($item->sisa_pinjaman, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">{{ ucfirst($item->metode_pembayaran ?? 'Tunai') }}</td>
                            <td class="px-6 py-4">
                                {{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4">
                                {{ \Carbon\Carbon::parse($item->tanggal_dikonfirmasi)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4">{{ \Carbon\Carbon::parse($item->tanggal_bayar)->format('d M Y') }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs rounded-full font-medium {{ $statusColor }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm">{{ $item->keterangan ?? '-' }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex flex-row justify-end space-x-2">
                                    <a href="{{ route('pelunasan_anggota.edit', $item->id) }}"
                                        class="text-white bg-green-700 hover:bg-green-800 focus:outline-none font-medium rounded-full text-sm px-4 py-1 text-center dark:bg-green-600 dark:hover:bg-green-700">
                                        Edit
                                    </a>

                                    <a href="{{ route('pelunasan_anggota.show', $item->id) }}"
                                        class="text-white bg-orange-700 hover:bg-orange-800 focus:outline-none font-medium rounded-full text-sm px-4 py-1 text-center dark:bg-orange-600 dark:hover:bg-orange-700">
                                        Pelunasan
                                    </a>

                                    @if ($item->status === 'lunas')
                                        <a href="{{ route('pelunasan_anggota.bukti', $item->id) }}"
                                            class="text-white bg-blue-600 hover:bg-blue-700 focus:outline-none font-medium rounded-full text-sm px-4 py-1 text-center">
                                            Bukti
                                        </a>
                                    @endif

                                    {{-- <button onclick="showModal('{{ route('pelunasan_anggota.destroy', $item->id) }}')"
                                class="text-white bg-red-700 hover:bg-red-800 focus:outline-none font-medium rounded-full text-sm px-5 py-1 text-center">
                                Hapus
                            </button> --}}
                                    <button type="button"
                                        onclick="showDeleteModal('{{ route('pelunasan_anggota.destroy', $item->id) }}')"
                                        class="text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 font-medium rounded-full text-sm px-4 py-1 cursor-pointer">
                                        Hapus
                                    </button>

                                    <!-- Modal -->
                                    <div id="deleteModal"
                                        class="hidden fixed inset-0 z-50 flex items-center justify-center">
                                        <!-- Overlay -->
                                        <div
                                            class="absolute inset-0 bg-black/30 backdrop-blur-sm transition-opacity duration-300">
                                        </div>

                                        <!-- Konten Modal -->
                                        <div
                                            class="relative bg-white w-full max-w-sm mx-4 rounded-2xl shadow-xl transform transition-all duration-300 scale-95">
                                            <div class="flex flex-col items-center p-6">
                                                <!-- Icon Warning -->
                                                <div
                                                    class="flex items-center justify-center w-16 h-16 rounded-full bg-red-100 mb-4">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-500"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.664 1.732-3L13.732 4a2 2 0 00-3.464 0L4.34 16c-.77 1.336.192 3 1.732 3z" />
                                                    </svg>
                                                </div>

                                                <!-- Judul -->
                                                <h2 class="text-lg font-semibold text-gray-700 mb-2">Hapus Data Pelunasan
                                                    Cicilan?</h2>
                                                <p class="text-sm text-gray-500 text-center mb-6">Tindakan ini tidak dapat
                                                    dibatalkan. Apakah Anda yakin ingin menghapus data ini?</p>

                                                <!-- Tombol Aksi -->
                                                <div class="flex space-x-3">
                                                    <button type="button" onclick="closeDeleteModal()"
                                                        class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg text-gray-700 text-sm font-medium cursor-pointer">
                                                        Batal
                                                    </button>
                                                    <form id="deleteForm" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="px-5 py-2 bg-red-600 hover:bg-red-700 rounded-lg text-white text-sm font-semibold cursor-pointer">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                {{ $pelunasans->links() }}
            </div>
        </div>
    </div>

    <script>
        function showDeleteModal(actionUrl) {
            document.getElementById('deleteModal').classList.remove('hidden');
            document.getElementById('deleteForm').setAttribute('action', actionUrl);
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }
    </script>
@endsection
