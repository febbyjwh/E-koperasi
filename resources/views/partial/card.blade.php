<div class="grid grid-cols-1 gap-6 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-1">
    <!-- Jumlah Anggota -->
    <div class="bg-gradient-to-r from-teal-400 to-cyan-500 text-white p-6 rounded-xl shadow-lg transform transition-transform hover:-translate-y-2">
        <div class="flex items-center justify-between">
            <p class="text-sm opacity-80">Jumlah Anggota</p>
            <svg class="w-6 h-6 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        <p class="text-3xl font-bold mt-2">{{ $jumlahAnggota }}</p>
    </div>

    <!-- Total Tabungan -->
    <div class="bg-gradient-to-r from-green-400 to-lime-500 text-white p-6 rounded-xl shadow-lg transform transition-transform hover:-translate-y-2">
        <div class="flex items-center justify-between">
            <p class="text-sm opacity-80">Total Tabungan</p>
            <svg class="w-6 h-6 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c1.104 0 2 .896 2 2s-.896 2-2 2-2-.896-2-2 .896-2 2-2z"></path>
            </svg>
        </div>
        <p class="text-3xl font-bold mt-2">Rp {{ number_format($totalTabungan, 0, ',', '.') }}</p>
    </div>

    <!-- Pinjaman Aktif -->
    <div class="bg-gradient-to-r from-red-400 to-rose-500 text-white p-6 rounded-xl shadow-lg transform transition-transform hover:-translate-y-2">
        <div class="flex items-center justify-between">
            <p class="text-sm opacity-80">Pinjaman Aktif</p>
            <svg class="w-6 h-6 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h1l1 10h14l1-10h1"></path>
            </svg>
        </div>
        <p class="text-3xl font-bold mt-2">Rp {{ number_format($pinjamanAktif, 0, ',', '.') }}</p>
    </div>

    <!-- Cicilan Masuk -->
    <div class="bg-gradient-to-r from-blue-400 to-indigo-500 text-white p-6 rounded-xl shadow-lg transform transition-transform hover:-translate-y-2">
        <div class="flex items-center justify-between">
            <p class="text-sm opacity-80">Cicilan Masuk</p>
            <svg class="w-6 h-6 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18"></path>
            </svg>
        </div>
        <p class="text-3xl font-bold mt-2">Rp {{ number_format($cicilanMasuk, 0, ',', '.') }}</p>
    </div>
</div>
