<div class="space-y-3.5 lg:overflow-x-auto">

    <!-- Cicilan Pinjaman -->
    @if ($pengajuan)
        <div class="bg-white dark:bg-gray-800 rounded-lg p-5.5 shadow-sm flex flex-col">
            <div class="flex justify-between items-center mb-2">
                <span class="font-semibold text-sm">Cicilan bulan ke-{{ $bulanPinjam }}</span>
                <span class="text-gray-500 dark:text-gray-400 text-sm">
                    Rp {{ number_format($nominalCicilanBulanIni ?? 0, 0, ',', '.') }}
                </span>
            </div>
            <div class="mb-2">
                <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">
                    Pembayaran selanjutnya
                </span>
            </div>
            <div class="mb-2 text-xs text-gray-500 dark:text-gray-400">
                Tengat : {{ $tengat ?? '-' }}
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2 dark:bg-gray-600 mb-1.5">
                <div class="bg-teal-500 h-2 rounded-full" style="width:{{ $progress }}%"></div>
            </div>
            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $progress }}%</div>
        </div>
    @endif

    <!-- Simpanan Wajib -->
    <div class="bg-white dark:bg-gray-800 rounded-lg p-3.5 shadow-sm flex flex-col">
        <div class="flex justify-between items-center mb-1.5">
            <span class="font-semibold text-sm">Simpanan Wajib</span>
            <span class="text-gray-500 dark:text-gray-400 text-sm">
                Rp {{ number_format($tabunganWajibTotal ?? 0, 0, ',', '.') }}
            </span>
        </div>

        <div class="mb-2">
            @if ($statusTabungan['status'] === 'sudah')
                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                    Sudah nabung wajib
                </span>
            @else
                <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">
                    Belum nabung bulan ini
                </span>
            @endif
        </div>

        <div class="mb-2 text-xs text-gray-500 dark:text-gray-400">
            {{ $statusTabungan['tanggal'] }}
        </div>
    </div>

    <!-- Simpanan Manasuka -->
    <div class="bg-white dark:bg-gray-800 rounded-lg p-3.5 shadow-sm flex flex-col">
        <div class="flex justify-between items-center mb-1.5">
            <span class="font-semibold text-sm">Simpanan Manasuka</span>
            <span class="text-gray-500 dark:text-gray-400 text-sm">
                Rp {{ number_format($tabunganManasukaTotal ?? 0, 0, ',', '.') }}
            </span>
        </div>

        <div class="mb-2">
            @if ($statusTabunganManasuka['status'] === 'sudah')
                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                    Sudah nabung Manasuka
                </span>
            @else
                <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">
                    Belum nabung bulan ini
                </span>
            @endif
        </div>

        <div class="mb-2 text-xs text-gray-500 dark:text-gray-400">
            {{ $statusTabunganManasuka['tanggal'] }}
        </div>
    </div>
</div>
