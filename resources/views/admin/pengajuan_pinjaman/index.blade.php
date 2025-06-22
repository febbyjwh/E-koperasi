@extends('layout')

@section('title', 'Konfirmasi Pengajuan Pinjaman')

@php
    function hitungCicilanBulanan($pengajuan) {
        $cicilan = [];
        $jumlah = $pengajuan->jumlah;
        $tenor = $pengajuan->lama_angsuran;
        $jenis = $pengajuan->jenis_pinjaman;

        if ($jenis === 'barang') {
            $jasa = $jumlah * 0.02;
            $pokok = $jumlah / $tenor;
            for ($i = 1; $i <= $tenor; $i++) {
                $cicilan[] = $pokok + $jasa;
            }
        } elseif ($jenis === 'kms') {
            $pokok = $jumlah / $tenor;
            $sisaPokok = $jumlah;
            for ($i = 1; $i <= $tenor; $i++) {
                $jasa = $sisaPokok * 0.025;
                $cicilan[] = $pokok + $jasa;
                $sisaPokok -= $pokok;
            }
        }

        return $cicilan;
    }

    function hitungJumlahDiterima($pengajuan) {
        return $pengajuan->jenis_pinjaman === 'barang'
            ? $pengajuan->jumlah - ($pengajuan->jumlah * 0.02)
            : $pengajuan->jumlah;
    }

    $pengajuanPending = $pengajuan->where('status', 'pending');
    $pengajuanDisetujui = $pengajuan->where('status', 'disetujui');
    $pengajuanDitolak = $pengajuan->where('status', 'ditolak');

    function renderTable($data, $judul, $showKonfirmasi = false) {
        echo "<h3 class='text-md font-semibold text-gray-800 mb-2 mt-6'>$judul</h3>";
        echo '<div class="overflow-x-auto w-full mb-6">';
        echo '<table class="min-w-full text-sm text-left text-gray-500 border rounded-lg">';
        echo '<thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th class="px-6 py-3">No</th>
                    <th class="px-6 py-3">Nama</th>
                    <th class="px-6 py-3">Jenis</th>
                    <th class="px-6 py-3">Jumlah Pinjaman</th>
                    <th class="px-6 py-3">Jumlah Harus Dibayar</th>
                    <th class="px-6 py-3">Jumlah Diterima</th>
                    <th class="px-6 py-3">Tenor</th>
                    <th class="px-6 py-3">Cicilan / Bulan</th>
                    <th class="px-6 py-3">Tujuan</th>
                    <th class="px-6 py-3">Tanggal</th>
                    <th class="px-6 py-3">Status</th>';
        if ($showKonfirmasi) echo '<th class="px-6 py-3">Konfirmasi</th>';
        echo '<th class="px-6 py-3 text-right">Aksi</th>
              </tr>
            </thead><tbody>';

        if ($data->isEmpty()) {
            $colspan = $showKonfirmasi ? 13 : 12;
            echo "<tr><td colspan='{$colspan}' class='px-6 py-4 text-center text-gray-500'>Tidak ada data.</td></tr>";
        } else {
            foreach ($data as $i => $item) {
                $cicilanList = hitungCicilanBulanan($item);
                $jumlahDiterima = hitungJumlahDiterima($item);

                $tooltip = collect($cicilanList)->map(function ($val, $i) {
                    return 'Bulan ' . ($i + 1) . ': Rp ' . number_format($val, 0, ',', '.');
                })->implode("\n");

                $statusColor = match ($item->status) {
                    'pending' => 'bg-yellow-100 text-yellow-800',
                    'disetujui' => 'bg-green-100 text-green-800',
                    'ditolak' => 'bg-red-100 text-red-800',
                    default => 'bg-gray-100 text-gray-800',
                };

                echo '<tr class="bg-white hover:bg-gray-50 border-b">';
                echo '<td class="px-6 py-4 font-medium text-gray-900">' . ($i + 1) . '</td>';
                echo '<td class="px-6 py-4">' . e($item->user->name ?? '-') . '</td>';
                echo '<td class="px-6 py-4 capitalize">' . ($item->jenis_pinjaman === 'barang' ? 'Kredit Barang' : 'Kredit Manasuka (KMS)') . '</td>';
                echo '<td class="px-6 py-4">Rp ' . number_format($item->jumlah, 0, ',', '.') . '</td>';
                echo '<td class="px-6 py-4">Rp ' . number_format(array_sum($cicilanList), 0, ',', '.') . '</td>';
                echo '<td class="px-6 py-4">Rp ' . number_format($jumlahDiterima, 0, ',', '.') . '</td>';
                echo '<td class="px-6 py-4">' . $item->lama_angsuran . ' bulan</td>';
                echo '<td class="px-6 py-4" title="' . e($tooltip) . '">Rp ' . number_format(round(array_sum($cicilanList) / count($cicilanList)), 0, ',', '.') . '</td>';
                echo '<td class="px-6 py-4">' . e($item->tujuan) . '</td>';
                echo '<td class="px-6 py-4">' . \Carbon\Carbon::parse($item->tanggal_pengajuan)->format('d M Y') . '</td>';
                echo '<td class="px-6 py-4 capitalize"><span class="px-2 py-1 text-xs rounded-full font-medium ' . $statusColor . '">' . $item->status . '</span></td>';

                if ($showKonfirmasi) {
                    echo '<td class="px-6 py-4 space-x-2">
                        <form action="' . route('pengajuan_pinjaman.konfirmasi', $item->id) . '" method="POST" class="inline-block">
                            ' . csrf_field() . method_field('PATCH') . '
                            <button name="status" value="disetujui" class="px-2 py-2 rounded hover:bg-green-100 text-xs" title="Setujui">
                                <i class="bx bx-check-circle" style="color:#40ce3b; font-size: 1.2rem"></i>
                            </button>
                            <button name="status" value="ditolak" class="px-2 py-2 rounded hover:bg-red-100 text-xs" title="Tolak">
                                <i class="bx bx-x-circle" style="color:#e91919; font-size: 1.2rem"></i>
                            </button>
                        </form>
                    </td>';
                }

                echo '<td class="px-6 py-4 text-right space-x-2">
                    <a href="' . route('pengajuan_pinjaman.edit', $item->id) . '" class="text-blue-600 hover:underline text-xs">Edit</a>
                    <form action="' . route('pengajuan_pinjaman.destroy', $item->id) . '" method="POST" class="inline-block" onsubmit="return confirm(\'Yakin ingin menghapus pengajuan ini?\')">
                        ' . csrf_field() . method_field('DELETE') . '
                        <button type="submit" class="text-red-600 hover:underline text-xs ml-2">Hapus</button>
                    </form>
                </td>';
                echo '</tr>';
            }
        }

        echo '</tbody></table></div>';
    }
@endphp

@section('content')
<div class="p-4 bg-white rounded-2xl shadow-lg mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <h2 class="text-lg md:text-xl font-semibold text-gray-700">Daftar Pengajuan Pinjaman</h2>

        <form action="{{ route('pengajuan_pinjaman.index') }}" method="GET" class="w-full md:max-w-md">
            <div class="relative">
                <input type="text" name="search" value="{{ request('search') }}"
                    class="block w-full p-3 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Cari nama anggota...">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 20 20" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <button type="submit"
                    class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-lightgray-700 text-gray font-medium rounded-lg text-sm px-4 py-2 h-10">
                    Cari
                </button>
            </div>
        </form>

        <a href="{{ route('pengajuan_pinjaman.create') }}"
            class="inline-block px-4 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300">
            Tambah Pengajuan
        </a>
    </div>
</div>

{{-- Tabel Pengajuan --}}
<div class="tabel-pengajuan-pending p-4 bg-white rounded-2xl shadow-lg mb-6">
    @php renderTable($pengajuanPending, 'Pengajuan Menunggu Konfirmasi', true); @endphp
</div>

<div class="tabel-pengajuan-disetujui p-4 bg-white rounded-2xl shadow-lg mb-6">
    @php renderTable($pengajuanDisetujui, 'Pengajuan Disetujui'); @endphp
</div>

<div class="tabel-pengajuan-ditolak p-4 bg-white rounded-2xl shadow-lg">
    @php renderTable($pengajuanDitolak, 'Pengajuan Ditolak'); @endphp
</div>
@endsection
