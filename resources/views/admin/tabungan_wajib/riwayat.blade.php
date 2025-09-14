@extends('layout')

@section('title', 'Riwayat Penarikan Tabungan Wajib')

@section('content')
    <div class="p-4 bg-white rounded-2xl shadow-lg">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-sm md:text-xl font-semibold text-gray-700">Riwayat Penarikan Tabungan Wajib</h2>
        </div>

        <div class="overflow-x-auto w-full">
            <table class="min-w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-3">No</th>
                        <th class="px-6 py-3">Jumlah Penarikan</th>
                        <th class="px-6 py-3">Tanggal Penarikan</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $grouped = $riwayat->groupBy('user_id');
                        $groupIndex = 1;
                    @endphp

                    @forelse ($grouped as $userId => $items)
                        <tr class="bg-gray-100">
                            <td colspan="3" class="px-6 py-2 font-bold text-gray-800">
                                {{ $items->first()->anggota->name ?? '-' }}
                            </td>
                        </tr>

                        @foreach ($items as $i => $item)
                            <tr class="bg-white hover:bg-gray-50">
                                <td class="px-6 py-4">{{ $groupIndex }}.{{ $loop->iteration }}</td>
                                <td class="px-6 py-4">Rp {{ number_format($item->total_ditarik, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($item->tanggal_penarikan)->format('d M Y') }}
                                </td>
                            </tr>
                        @endforeach
                        @php $groupIndex++; @endphp
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-gray-500 py-4">Belum ada riwayat penarikan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="flex justify-end gap-2">
                <a href="{{ route('tabungan_wajib.tabungan_wajib') }}"
                    class="px-4 py-2 text-gray-600 hover:underline cursor-pointer">
                    Kembali
                </a>
            </div>
        </div>
        <div class="mt-4">
            {{ $riwayat->links('vendor.pagination.tailwind') }}
        </div>
    </div>
@endsection
