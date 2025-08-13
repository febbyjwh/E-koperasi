{{-- File: resources/views/admin/pengajuan_pinjaman/table.blade.php --}}
@once
    @include('components.modal')
@endonce

<div class="p-4 bg-white rounded-2xl shadow mb-6">
    <h3 class="text-md font-semibold text-gray-800 mb-2">{{ $judul }}</h3>

    <div class="overflow-x-auto w-full">
        <table class="min-w-full text-sm text-left text-gray-500 border rounded-lg">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th class="px-6 py-3">No</th>
                    <th class="px-6 py-3">Nama</th>
                    <th class="px-6 py-3">Jenis</th>
                    <th class="px-6 py-3">Jumlah Pinjaman</th>
                    <th class="px-6 py-3">Jumlah Harus Dibayar</th>
                    <th class="px-6 py-3">Jumlah Diterima</th>
                    <th class="px-6 py-3">Tenor</th>
                    <th class="px-6 py-3">Tujuan</th>
                    <th class="px-6 py-3">Tanggal Pengajuan</th>
                    <th class="px-6 py-3">Tanggal Dikonfirmasi</th>
                    <th class="px-6 py-3">Status</th>
                    @if (!empty($showKonfirmasi))
                        <th class="px-6 py-3">Konfirmasi</th>
                    @endif
                    <th class="px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $i => $item)
                    <tr class="bg-white hover:bg-gray-50 border-b">
                        <td class="px-6 py-4">{{ $loop->iteration + $data->firstItem() - 1 }}</td>
                        <!-- <td class="px-6 py-4 font-medium text-gray-900">{{ $i + 1 }}</td> -->
                        <td class="px-6 py-4">{{ $item->user->name ?? '-' }}</td>
                        <td class="px-6 py-4 capitalize">
                            {{ $item->jenis_pinjaman === 'barang' ? 'Kredit Barang' : 'Kredit Manasuka (KMS)' }}</td>
                        <td class="px-6 py-4">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">Rp {{ number_format($item->jumlah_harus_dibayar, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">Rp {{ number_format($item->jumlah_diterima, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">{{ $item->lama_angsuran }} bulan</td>
                        <td class="px-6 py-4">{{ $item->tujuan }}</td>
                        <td class="px-6 py-4">
                            {{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->translatedFormat('d M Y') }}
                        </td>
                        <td class="px-6 py-4">
                            @if ($item->tanggal_dikonfirmasi)
                                {{ \Carbon\Carbon::parse($item->tanggal_dikonfirmasi)->translatedFormat('d M Y') }}
                            @else
                                <span class="text-gray-400 italic">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 capitalize">
                            @php
                                $statusColor = match ($item->status) {
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'disetujui' => 'bg-green-100 text-green-800',
                                    'ditolak' => 'bg-red-100 text-red-800',
                                    default => 'bg-gray-100 text-gray-800',
                                };
                            @endphp
                            <span class="px-2 py-1 text-xs rounded-full font-medium {{ $statusColor }}">
                                {{ $item->status }}
                            </span>
                        </td>
                        @if (!empty($showKonfirmasi))
                            <td class="px-6 py-4 space-x-2">
                                <form action="{{ route('pengajuan_pinjaman.konfirmasi', $item->id) }}" method="POST"
                                    class="inline-block">
                                    @csrf
                                    @method('PATCH')
                                    <button name="status" value="disetujui"
                                        class="px-2 py-2 rounded hover:bg-green-100 text-xs cursor-pointer" title="Setujui">
                                        <i class="bx bx-check-circle" style="color:#40ce3b; font-size: 1.2rem"></i>
                                    </button>
                                    <button name="status" value="ditolak"
                                        class="px-2 py-2 rounded hover:bg-red-100 text-xs cursor-pointer" title="Tolak">
                                        <i class="bx bx-x-circle" style="color:#e91919; font-size: 1.2rem"></i>
                                    </button>
                                </form>
                            </td>
                        @endif
                        <td class="px-6 py-4 text-right">
                            <div class="flex flex-row justify-end space-x-2">
                                <a href="{{ route('pengajuan_pinjaman.edit', $item->id) }}"
                                    class="text-white bg-green-700 hover:bg-green-800 focus:outline-none font-medium rounded-full text-sm px-4 py-1 text-center dark:bg-green-600 dark:hover:bg-green-700">
                                    Edit
                                </a>

                                <a href="{{ route('pengajuan_pinjaman.invoice', $item->id) }}"
                                    class="text-white bg-gray-700 hover:bg-gray-800 focus:outline-none font-medium rounded-full text-sm px-4 py-1 text-center dark:bg-gray-600 dark:hover:bg-gray-700">
                                    Bukti
                                </a>

                                <button type="button"
                                    onclick="showDeleteModal('{{ route('pengajuan_pinjaman.destroy', $item->id) }}')"
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
                                            <h2 class="text-lg font-semibold text-gray-700 mb-2">Hapus Data Peminjaman?</h2>
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
                        <td colspan="13" class="px-6 py-4 text-center text-gray-500">Tidak ada data.</td>
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
