@extends('layout')

@section('content')
<div class="max-w-full mx-auto bg-white shadow-md p-6 rounded-lg">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-semibold text-gray-700">Rincian Cicilan Pinjaman Anggota</h2>
    </div>

    <div class="overflow-x-auto w-full">
        <table class="min-w-full text-sm text-left text-gray-700 border rounded-lg">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th class="px-6 py-3">Bulan Ke</th>
                    <th class="px-6 py-3">Pokok</th>
                    <th class="px-6 py-3">Bunga</th>
                    <th class="px-6 py-3">Total Angsuran</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Tanggal Bayar</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($pelunasans as $pelunasan)
                    @php
                        $modalId = 'bayar-modal-' . $pelunasan->id;
                        $isLunas = $pelunasan->status === 'sudah_bayar';
                        $statusColor = $isLunas ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800';
                        $isOwner = optional($pelunasan->peminjaman)->user_id === auth()->id();
                    @endphp

                    {{-- Tampilkan hanya jika admin atau anggota pemilik --}}
                    @if(auth()->user()->role === 'admin' || ($isOwner && auth()->user()->role === 'anggota'))
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">{{ $pelunasan->bulan_ke }}</td>
                            <td class="px-6 py-4">Rp {{ number_format($pelunasan->pokok, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">Rp {{ number_format($pelunasan->bunga, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">Rp {{ number_format($pelunasan->total_angsuran, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $statusColor }}">
                                    {{ Str::title(str_replace('_', ' ', $pelunasan->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">{{ $pelunasan->tanggal_bayar ?? '-' }}</td>

                            {{-- Aksi --}}
                            <td class="px-6 py-4 text-right flex gap-2 justify-end items-center">
                                @if(auth()->user()->role === 'admin')
                                    @if ($isLunas)
                                        <a href="{{ route('pelunasan_anggota.invoice', $pelunasan->id) }}"
                                            class="text-white bg-gray-700 hover:bg-gray-800 font-medium rounded-full text-sm px-5 py-1">
                                            Bukti
                                        </a>
                                    @else
                                        <button data-modal-target="{{ $modalId }}" data-modal-toggle="{{ $modalId }}"
                                            class="text-white bg-yellow-700 hover:bg-yellow-800 font-medium rounded-full cursor-pointer text-sm px-5 py-1">
                                            Bayar
                                        </button>

                                        {{-- Modal Pembayaran --}}
                                        <div id="{{ $modalId }}" tabindex="-1" aria-hidden="true"
                                            class="hidden fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full flex justify-center items-center">
                                            <div class="relative w-full max-w-md max-h-full">
                                                <div class="bg-white rounded-lg shadow dark:bg-gray-700">
                                                    <div class="flex items-center justify-between p-4 border-b rounded-t dark:border-gray-600">
                                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                            Bayar Angsuran Bulan ke-{{ $pelunasan->bulan_ke }}
                                                        </h3>
                                                        <button type="button"
                                                            class="text-gray-400 hover:bg-gray-200 rounded-lg text-sm w-8 h-8"
                                                            data-modal-hide="{{ $modalId }}">
                                                            <i class="fal fa-times"></i>
                                                        </button>
                                                    </div>
                                                    <div class="p-4">
                                                        <form action="{{ route('pelunasan_anggota.bayar', $pelunasan->id) }}" method="POST">
                                                            @csrf
                                                            <div class="mb-4">
                                                                <label class="block mb-2 text-sm font-medium text-gray-700">Jumlah Bayar</label>
                                                                <input type="text" name="jumlah_bayar"
                                                                    value="{{ $pelunasan->total_angsuran }}"
                                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5"
                                                                    required />
                                                            </div>
                                                            <button type="submit"
                                                                class="w-full text-white bg-yellow-600 hover:bg-yellow-700 font-medium rounded-lg text-sm px-5 py-2.5">
                                                                Bayar Sekarang
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                @elseif(auth()->user()->role === 'anggota')
                                    @if ($isLunas)
                                        <a href="{{ route('pelunasan_anggota.invoice', $pelunasan->id) }}"
                                            class="text-white bg-green-600 hover:bg-green-700 font-medium rounded-full text-sm px-5 py-1">
                                            Bukti
                                        </a>
                                    @else
                                        <a href=""
                                            class="text-white bg-blue-400 dark:bg-blue-500 cursor-not-allowed font-medium rounded-full text-sm px-5 py-1 text-center"
                                            aria-disabled="true" title="Menunggu konfirmasi pembayaran admin">
                                            Bukti
                                        </a>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>

        {{-- Tombol Kembali --}}
        <div class="flex justify-end mt-4">
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('pelunasan_anggota.index') }}" class="py-1 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                    Kembali
                </a>
            @elseif(auth()->user()->role === 'anggota')
                <a href="{{ route('cicilan_anggota.index') }}" class="py-1 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                    Kembali
                </a>
            @endif
        </div>
    </div>
</div>
@endsection
