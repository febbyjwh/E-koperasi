@extends('layout')

@section('content')
    <div class="max-w-full mx-auto bg-white shadow-md p-6 rounded-lg">
        <h2 class="text-xl font-semibold mb-4">Detail Angsuran</h2>
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
                        @php
                            $firstPelunasan = $pelunasans->first();
                            $userId = optional($firstPelunasan?->pinjaman)->user_id;
                        @endphp

                        @if (auth()->user()->role === 'admin')
                            <th class="px-4 py-2">Aksi</th>
                        @elseif ($firstPelunasan && auth()->id() === $userId)
                            <th class="px-4 py-2">Bayar</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($pelunasans as $pelunasan)
                        @php
                            $modalId = 'bayar-modal-' . $pelunasan->id;
                            $isLunas = $pelunasan->status === 'sudah_bayar';
                            $statusColor = $isLunas ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800';
                        @endphp
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">{{ $pelunasan->bulan_ke }}</td>
                            <td class="px-6 py-4">Rp {{ number_format($pelunasan->pokok, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">Rp {{ number_format($pelunasan->bunga, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">Rp {{ number_format($pelunasan->total_angsuran, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $statusColor }}">
                                    {{ ucfirst($pelunasan->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">{{ $pelunasan->tanggal_bayar ?? '-' }}</td>
                            <td class="px-6 py-4 text-right flex gap-2 justify-end items-center">
                               @if (auth()->user()->role === 'admin')
                               @if ($isLunas)
                                    <a href="{{ route('pelunasan_anggota.invoice', $pelunasan->id) }}"
                                    class="text-white bg-green-600 hover:bg-green-700 font-medium rounded-lg text-xs px-4 py-2">
                                        Bukti
                                    </a>
                                @endif

                                @if (!$isLunas)
                                    <button data-modal-target="{{ $modalId }}" data-modal-toggle="{{ $modalId }}"
                                        class="text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-xs px-4 py-2">
                                        Bayar
                                    </button>

                                    {{-- Modal hanya untuk admin --}}
                                    <div id="{{ $modalId }}" tabindex="-1" aria-hidden="true"
                                        class="hidden fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full flex justify-center items-center">
                                        <div class="relative w-full max-w-md max-h-full">
                                            <div class="bg-white rounded-lg shadow dark:bg-gray-700">
                                                <div class="flex items-center justify-between p-4 border-b rounded-t dark:border-gray-600">
                                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                        Bayar Angsuran Bulan ke-{{ $pelunasan->bulan_ke }}
                                                    </h3>
                                                    <button type="button"
                                                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                        data-modal-hide="{{ $modalId }}">
                                                        <i class="fal fa-times"></i>
                                                        <span class="sr-only">Close modal</span>
                                                    </button>
                                                </div>
                                                <div class="p-4">
                                                    <form class="space-y-4"
                                                        action="{{ route('pelunasan_anggota.bayar', $pelunasan->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <div>
                                                            <label for="total_angsuran-{{ $pelunasan->id }}"
                                                                class="block mb-2 text-sm font-medium text-gray-700 dark:text-white">Jumlah Bayar</label>
                                                            <input type="text" name="jumlah_bayar"
                                                                id="total_angsuran-{{ $pelunasan->id }}"
                                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white"
                                                                value="{{ $pelunasan->total_angsuran }}" required />
                                                        </div>
                                                        <button type="submit"
                                                            class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                                            Bayar Sekarang
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-green-600 font-semibold text-sm">Lunas</span>
                                @endif
                            @else
                                {{-- Anggota hanya melihat status --}}
                                <span class="text-sm font-medium {{ $pelunasan->status === 'sudah_bayar' ? 'text-green-600' : 'text-yellow-600' }}">
                                    {{ ucfirst($pelunasan->status) }}
                                </span>

                                @if ($isLunas)
                                    <a href="{{ route('pelunasan_anggota.invoice', $pelunasan->id) }}"
                                        class="text-white bg-green-600 hover:bg-green-700 font-medium rounded-lg text-xs px-4 py-2">
                                        Bukti
                                    </a>
                                @endif
                            @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-6">
            <a href="{{ route('pelunasan_anggota.index') }}"
                class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded">← Kembali</a>
        </div>
    </div>
@endsection
