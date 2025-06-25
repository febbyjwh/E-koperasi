@extends('layout')

@section('content')
    <div class="max-w-full mx-auto bg-white shadow-md p-6 rounded-lg">
        <h2 class="text-xl font-semibold mb-4">Detail Angsuran</h2>
        <div class="overflow-x-auto w-full">
            <table class="min-w-full text-sm text-left text-gray-500 border rounded-lg">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 border">Bulan Ke</th>
                        <th class="px-4 py-2 border">Pokok</th>
                        <th class="px-4 py-2 border">Bunga</th>
                        <th class="px-4 py-2 border">Total Angsuran</th>
                        <th class="px-4 py-2 border">Status Pelunasan</th>
                        <th class="px-4 py-2 border">Tanggal Bayar</th>
                        <th class="px-4 py-2 w-10 border">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pelunasans as $pelunasan)
                        <tr>
                            <td class="px-4 py-2 border">{{ $pelunasan->bulan_ke }}</td>
                            <td class="px-4 py-2 border">Rp {{ number_format($pelunasan->pokok, 0, ',', '.') }}</td>
                            <td class="px-4 py-2 border">Rp {{ number_format($pelunasan->bunga, 0, ',', '.') }}</td>
                            <td class="px-4 py-2 border">Rp {{ number_format($pelunasan->total_angsuran, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-2 border">{{ ucfirst($pelunasan->status) }}</td>
                            <td class="px-4 py-2 border">{{ $pelunasan->tanggal_bayar ?? '-' }}</td>
                            <td class="px-4 py-2 border">
                                @if ($pelunasan->status !== 'sudah_bayar')
                                    @php $modalId = 'bayar-modal-' . $pelunasan->id; @endphp
                                    
                                    <button data-modal-target="{{ $modalId }}" data-modal-toggle="{{ $modalId }}"
                                        class="block text-white bg-teal-500 hover:bg-teal-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-2 py-2 text-center w-full"
                                        type="button">
                                        Bayar
                                    </button>

                                    <div id="{{ $modalId }}" tabindex="-1" aria-hidden="true"
                                        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                        <div class="relative p-4 w-full max-w-md max-h-full">
                                            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                                                <div
                                                    class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                        Bayar Angsuran Bulan ke-{{ $pelunasan->bulan_ke }}
                                                    </h3>
                                                    <button type="button"
                                                        class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                        data-modal-hide="{{ $modalId }}">
                                                        <i class="fal fa-times"></i>
                                                        <span class="sr-only">Close modal</span>
                                                    </button>
                                                </div>
                                                <div class="p-4 md:p-5">
                                                    <form class="space-y-4"
                                                        action="{{ route('pelunasan_anggota.bayar', $pelunasan->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <div>
                                                            <label for="total_angsuran-{{ $pelunasan->id }}"
                                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                                                            <input type="text" name="jumlah_bayar"
                                                                id="total_angsuran-{{ $pelunasan->id }}"
                                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white"
                                                                value="{{ $pelunasan->total_angsuran }}" required />
                                                        </div>
                                                        {{-- <div>
                                                            <label for="metode_pembayaran-{{ $pelunasan->id }}"
                                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                                                            <input type="password" name="password"
                                                                id="metode_pembayaran-{{ $pelunasan->id }}"
                                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white"
                                                                required />
                                                        </div> --}}
                                                        <button type="submit"
                                                            class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                            Bayar Sekarang
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-green-600 font-semibold">Lunas</span>
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
