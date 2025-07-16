{{-- File: resources/views/admin/pengajuan_pinjaman/table.blade.php --}}
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
                    {{-- <th class="px-6 py-3">Cicilan / Bulan</th> --}}
                    <th class="px-6 py-3">Tujuan</th>
                    <th class="px-6 py-3">Tanggal</th>
                    <th class="px-6 py-3">Status</th>
                    @if (!empty($showKonfirmasi)) <th class="px-6 py-3">Konfirmasi</th> @endif
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $i => $item)
                    <tr class="bg-white hover:bg-gray-50 border-b">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $i + 1 }}</td>
                        <td class="px-6 py-4">{{ $item->user->name ?? '-' }}</td>
                        <td class="px-6 py-4 capitalize">{{ $item->jenis_pinjaman === 'barang' ? 'Kredit Barang' : 'Kredit Manasuka (KMS)' }}</td>
                        <td class="px-6 py-4">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">Rp {{ number_format($item->jumlah_harus_dibayar, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">Rp {{ number_format($item->jumlah_diterima, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">{{ $item->lama_angsuran }} bulan</td>
                        {{-- <td class="px-6 py-4" title="{{ $item->cicilan_detail }}">
                            Rp {{ number_format($item->cicilan_per_bulan, 0, ',', '.') }}
                        </td> --}}
                        <td class="px-6 py-4">{{ $item->tujuan }}</td>
                        <td class="px-6 py-4">{{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->format('d M Y') }}</td>
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
                                <form action="{{ route('pengajuan_pinjaman.konfirmasi', $item->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('PATCH')
                                    <button name="status" value="disetujui" class="px-2 py-2 rounded hover:bg-green-100 text-xs" title="Setujui">
                                        <i class="bx bx-check-circle" style="color:#40ce3b; font-size: 1.2rem"></i>
                                    </button>
                                    <button name="status" value="ditolak" class="px-2 py-2 rounded hover:bg-red-100 text-xs" title="Tolak">
                                        <i class="bx bx-x-circle" style="color:#e91919; font-size: 1.2rem"></i>
                                    </button>
                                </form>
                            </td>
                        @endif
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('pengajuan_pinjaman.edit', $item->id) }}" class="text-blue-600 hover:underline text-xs">Edit</a>
                            <a href="{{ route('pengajuan_pinjaman.invoice', $item->id) }}" class="text-blue-600 hover:underline text-xs">Bukti</a>
                            <form action="{{ route('pengajuan_pinjaman.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus pengajuan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline text-xs ml-2">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="13" class="px-6 py-4 text-center text-gray-500">Tidak ada data.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
