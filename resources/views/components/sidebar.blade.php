<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
    aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
        <ul class="space-y-5 font-medium">
            <li>
                <p class="uppercase text-xs text-gray-400 mb-4 tracking-wider">Homes</p>
                <a href="{{ route('dashboard') }}" @class([
                    'flex items-center p-2 rounded-lg transition ease-in-out duration-500 group',
                    'text-gray-900 hover:text-teal-400 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700',
                    'text-teal-400 bg-gray-100' => request()->routeIs('dashboard'),
                ])>
                    <i @class([
                        'fas fa-chart-pie mr-3 transition duration-500',
                        'text-gray-500 dark:text-gray-400 group-hover:text-teal-400 dark:group-hover:text-white',
                        'text-teal-400' => request()->routeIs('dashboard'),
                    ])></i>
                    <span class="ms-3">Dashboard</span>
                </a>
            </li>

            <li>
                <p class="uppercase text-xs text-gray-400 mb-4 tracking-wider">kelola keuangan</p>

                <a href="{{ route('modal.index') }}" @class([
                    'flex items-center p-2 rounded-lg transition ease-in-out duration-500 group',
                    'text-gray-900 hover:text-teal-400 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700',
                    'text-teal-400 bg-gray-100' => request()->routeIs('modal.index'),
                ])>
                    <i @class([
                        'fad fa-money-bill-wave mr-3 transition duration-500',
                        'text-gray-500 dark:text-gray-400 group-hover:text-teal-400 dark:group-hover:text-white',
                        'text-teal-400' => request()->routeIs('modal.index'),
                    ])></i>
                    <span class="ms-3">Management Modal</span>
                </a>

                <a href="{{ route('pengajuan_pinjaman.index') }}" @class([
                    'flex items-center p-2 rounded-lg transition ease-in-out duration-500 group',
                    'text-gray-900 hover:text-teal-400 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700',
                    'text-teal-400 bg-gray-100' => request()->routeIs('pengajuan_pinjaman.index'),
                ])>
                    <i @class([
                        'fad fa-money-bill-wave mr-3 transition duration-500',
                        'text-gray-500 dark:text-gray-400 group-hover:text-teal-400 dark:group-hover:text-white',
                        'text-teal-400' => request()->routeIs('pengajuan_pinjaman.index'),
                    ])></i>
                    <span class="ms-3">Pengajuan Pinjaman</span>
                </a>

                <a href="{{ route('pelunasan_anggota.index') }}" @class([
                    'flex items-center p-2 rounded-lg transition ease-in-out duration-500 group',
                    'text-gray-900 hover:text-teal-400 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700',
                    'text-teal-400 bg-gray-100' => request()->routeIs('pelunasan_anggota.index'),
                ])>
                    <i @class([
                        'fad fa-money-bill-wave mr-3 transition duration-500',
                        'text-gray-500 dark:text-gray-400 group-hover:text-teal-400 dark:group-hover:text-white',
                        'text-teal-400' => request()->routeIs('pelunasan_anggota.index'),
                    ])></i>
                    <span class="ms-3">Cicilan Anggota</span>
                </a>
            </li>

            <li>
                <p class="uppercase text-xs text-gray-400 mb-4 tracking-wider">kelola Anggota</p>

                <a href="{{ route('kelola_anggota.kelola_anggota') }}" @class([
                    'flex items-center p-2 rounded-lg transition ease-in-out duration-500 group',
                    'text-gray-900 hover:text-teal-400 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700',
                    'text-teal-400 bg-gray-100' => request()->routeIs('kelola_anggota.kelola_anggota'),
                ])>
                    <i @class([
                        'fad fa-users mr-3 transition duration-500',
                        'text-gray-500 dark:text-gray-400 group-hover:text-teal-400 dark:group-hover:text-white',
                        'text-teal-400' => request()->routeIs('kelola_anggota.kelola_anggota'),
                    ])></i>
                    <span class="ms-3">Anggota</span>
                </a>

                <a href="{{ route('tabungan_wajib.tabungan_wajib') }}" @class([
                    'flex items-center p-2 rounded-lg transition ease-in-out duration-500 group',
                    'text-gray-900 hover:text-teal-400 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700',
                    'text-teal-400 bg-gray-100' => request()->routeIs('tabungan_wajib.tabungan_wajib'),
                ])>
                    <i @class([
                        'fad fa-users mr-3 transition duration-500',
                        'text-gray-500 dark:text-gray-400 group-hover:text-teal-400 dark:group-hover:text-white',
                        'text-teal-400' => request()->routeIs('tabungan_wajib.tabungan_wajib'),
                    ])></i>
                    <span class="ms-3">Tabungan Wajib</span>
                </a>

                <a href="{{ route('tabungan_manasuka.tabungan_manasuka') }}" @class([
                    'flex items-center p-2 rounded-lg transition ease-in-out duration-500 group',
                    'text-gray-900 hover:text-teal-400 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700',
                    'text-teal-400 bg-gray-100' => request()->routeIs('tabungan_manasuka.tabungan_manasuka'),
                ])>
                    <i @class([
                        'fad fa-users mr-3 transition duration-500',
                        'text-gray-500 dark:text-gray-400 group-hover:text-teal-400 dark:group-hover:text-white',
                        'text-teal-400' => request()->routeIs('tabungan_manasuka.tabungan_manasuka'),
                    ])></i>
                    <span class="ms-3">Tabungan Manasuka</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
