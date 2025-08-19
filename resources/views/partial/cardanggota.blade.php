<div class="relative bg-teal-500 p-3 pb-14 rounded-b-3xl">
    <div class="grid grid-cols-2 lg:grid-cols-2 grid-rows-2 gap-2">
        <!-- Uang Ajuanmu -->
        <div class="p-2 sm:p-3 col-span-1 row-span-2 bg-white h-32 sm:h-50 rounded-lg">
            <div class="flex justify-start items-center gap-2">
                <i class="fas fa-wallet text-xs sm:text-3xl text-teal-500"></i>
                <p class="text-sm sm:text-xl font-light">Uang Ajuanmu</p>
            </div>
            <div class="h-20 sm:h-28 mt-4 sm:mt-8">
                <div class="flex items-center justify-center sm:text-center">
                    <p class="text-lg sm:text-3xl font-bold">Rp
                        {{ isset($pengajuan->jumlah) ? number_format($pengajuan->jumlah, 0, ',', '.') : 0 }}
                    </p>
                </div>
                <div class="border-t-2 border-gray-200 mt-3 sm:mt-4 pt-1 flex justify-between">
                    <a href="{{ route('pinjaman_anggota.index') }}" class="text-[10px] sm:text-lg hover:text-teal-500">
                        Lihat Detail >>
                    </a>
                    @php $status = $pengajuan?->status; @endphp
                    <span
                        class="inline-block px-1 sm:px-2 py-0 sm:py-1 sm:text-[12px] text-[9px] rounded-full
                        @if (is_null($status)) bg-gray-100 text-gray-700
                        @elseif ($status === 'pending') bg-yellow-100 text-yellow-700
                        @elseif ($status === 'disetujui') bg-green-100 text-green-700
                        @elseif ($status === 'ditolak') bg-red-100 text-red-700
                        @elseif ($status === 'keluar') bg-blue-100 text-blue-700
                        @else bg-gray-100 text-gray-700 @endif">
                        {{ is_null($status) ? 'Belum' : ucfirst($status) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Uang yang diterima -->
        <div class="p-2 sm:p-3 bg-white h-14 sm:h-24 rounded-lg">
            <div class="flex justify-start items-center gap-2">
                <i class="fas fa-hand-holding-usd text-xs sm:text-2xl text-teal-500"></i>
                <p class="text-xs sm:text-xl font-light">Uang yang diterima</p>
            </div>
            <div class="flex items-center justify-center sm:text-center h-5 sm:h-7 mt-2">
                <p class="text-lg sm:text-3xl font-bold">Rp
                    {{ isset($pengajuan->jumlah_diterima) ? number_format($pengajuan->jumlah_diterima, 0, ',', '.') : 0 }}
                </p>
            </div>
        </div>

        <!-- Sisa pembayaran -->
        <div class="p-2 sm:p-3 bg-white h-14 sm:h-24 rounded-lg">
            <div class="flex justify-start items-center gap-2">
                <i class="fas fa-badge-dollar text-xs sm:text-2xl text-teal-500"></i>
                <p class="text-xs sm:text-xl font-light">Sisa pembayaran</p>
            </div>
            <div class="flex items-center justify-center sm:text-center h-5 sm:h-7 mt-2">
                @php
                    $pelunasan = $pengajuan?->pelunasan?->last();
                    $sisa = $pelunasan?->sisa_pinjaman ?? $pengajuan->jumlah_diterima;
                @endphp
                <p class="text-lg sm:text-3xl font-bold">
                    Rp {{ number_format($sisa, 0, ',', '.') }}
                </p>

            </div>
        </div>
    </div>

    <!-- Menu bawah -->
    <div class="absolute inset-x-0 bottom-0 flex justify-center translate-y-1/2">
        <div
            class="bg-white h-14 sm:h-16 w-96 sm:w-full sm:max-w-2xl rounded-xl shadow-sm z-10 flex items-center justify-around p-2 sm:p-3">
            <a href="{{ route('pinjaman_anggota.index') }}" class="flex flex-col items-center justify-center">
                <i class="fas fa-hands-usd text-xl sm:text-2xl text-teal-500"></i>
                <p class="text-xs sm:text-sm font-light">Ajukan Pinjaman</p>
            </a>
            <a href="{{ route('cicilan_anggota.index') }}" class="flex flex-col items-center justify-center">
                <i class="fas fa-badge-dollar text-xl sm:text-2xl text-teal-500"></i>
                <p class="text-xs sm:text-sm font-light">Pelunasan</p>
            </a>
            <a href="{{ route('tab_wajib_anggota.index') }}" class="flex flex-col items-center justify-center">
                <i class="fas fa-money-check-edit-alt text-xl sm:text-2xl text-teal-500"></i>
                <p class="text-xs sm:text-sm font-light">Tab Wajib</p>
            </a>
            <a href="{{ route('tab_manasuka_anggota.index') }}" class="flex flex-col items-center justify-center">
                <i class="fas fa-money-check-edit text-xl sm:text-2xl text-teal-500"></i>
                <p class="text-xs sm:text-sm font-light">Tab Manasuka</p>
            </a>
        </div>
    </div>
</div>
