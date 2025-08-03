<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 my-6">
    <!-- Jumlah Anggota -->
    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
        <p class="text-sm text-gray-500 dark:text-gray-400">Jumlah Anggota</p>
        <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $jumlahAnggota }}</p>
    </div>

    <!-- Total Tabungan -->
    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
        <p class="text-sm text-gray-500 dark:text-gray-400">Total Tabungan</p>
        <p class="text-2xl font-bold text-green-600 dark:text-green-400">Rp {{ number_format($totalTabungan, 0, ',', '.') }}</p>
    </div>

    <!-- Pinjaman Aktif -->
    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
        <p class="text-sm text-gray-500 dark:text-gray-400">Pinjaman Aktif</p>
        <p class="text-2xl font-bold text-red-600 dark:text-red-400">Rp {{ number_format($pinjamanAktif, 0, ',', '.') }}</p>
    </div>

    <!-- Cicilan Masuk -->
    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
        <p class="text-sm text-gray-500 dark:text-gray-400">Cicilan Masuk</p>
        <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">Rp {{ number_format($cicilanMasuk, 0, ',', '.') }}</p>
    </div>
</div>