@extends('layout')

@section('title', 'Tabungan Wajib')

@section('content')

    @once
        @include('components.modal')
    @endonce

    <div class="p-4 bg-white rounded-2xl shadow-lg">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-sm md:text-xl font-semibold text-gray-700">Daftar Setoran Tabungan Wajib</h2>

            <form action="{{ route('tabungan_wajib.tabungan_wajib') }}" method="GET" class="max-w-md w-full mr-4">
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

            <a href="{{ route('tabungan_wajib.create') }}"
                class="inline-block px-4 py-2 text-sm bg-blue-600 text-white rounded-full hover:bg-blue-700 transition duration-300">
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
                        <th class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $grouped = $setoranWajib->sortBy(fn($item) => $item->anggota->name ?? '')->groupBy('user_id');
                        $groupIndex = 1;
                    @endphp

                    @forelse ($grouped as $userId => $items)
                        <tr class="bg-gray-100">
                            <td class="px-6 py-2"></td>
                            <td class="px-6 py-2 font-bold text-gray-800">{{ $items->first()->anggota->name ?? '-' }}</td>
                            <td colspan="5"></td>
                        </tr>

                        @foreach ($items as $i => $setoran)
                            <tr class="bg-white hover:bg-gray-50">
                                <td class="px-6 py-4">{{ $groupIndex }}.{{ $loop->iteration }}</td>
                                <td class="px-6 py-4"></td>
                                <td class="px-6 py-4 capitalize">{{ $setoran->jenis }}</td>
                                <td class="px-6 py-4">
                                    Rp {{ number_format($setoran->nominal, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4">
                                    Rp {{ number_format($setoran->total, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($setoran->tanggal)->format('d M Y') }}</td>
                                <td class="px-0 py-4 space-x-2">
                                    <a href="{{ route('tabungan_wajib.edit', $setoran->id) }}"
                                        class="text-white bg-green-700 hover:bg-green-800 font-medium rounded-full text-sm px-5 py-1">
                                        Edit
                                    </a>

                                    <button type="button"
                                        onclick="showDeleteModal('{{ route('tabungan_wajib.destroy', $setoran->id) }}')"
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
                                                <h2 class="text-lg font-semibold text-gray-700 mb-2">Hapus Data Tabungan Manasuka?</h2>
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

                                </td>
                            </tr>
                        @endforeach

                        @php
                            $totalSaldo = $items->sum('nominal');
                        @endphp
                        <tr class="bg-white">
                            <td colspan="7" class="px-6 py-2 font-semibold text-right text-gray-700">
                                Total Tabungan Wajib {{ $items->first()->anggota->name ?? 'Anggota' }}:
                                <span class="text-blue-700">Rp {{ number_format($totalSaldo, 0, ',', '.') }}</span>
                            </td>
                        </tr>
                        @php $groupIndex++; @endphp
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-gray-500 py-4">Belum ada data tabungan wajib.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
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
