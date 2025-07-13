<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
    aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
        <ul class="space-y-5 font-medium">

            @if (auth()->check() && auth()->user()->role === 'admin')            
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

            <li x-data="{ open: {{ request()->routeIs('laporan.*') ? 'true' : 'false' }} }">
                <p class="uppercase text-xs text-gray-400 mb-4 tracking-wider">Laporan</p>
                <button @click="open = !open"
                    class="flex items-center p-2 w-full rounded-lg transition ease-in-out duration-500 group text-gray-900 hover:text-teal-400 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                    <i class="fas fa-chart-bar mr-3 text-gray-500 dark:text-gray-400 group-hover:text-teal-400 dark:group-hover:text-white"></i>
                    <span class="ms-3 flex-1 text-left">Laporan</span>
                    <svg class="w-4 h-4 ml-auto transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <ul x-show="open" x-transition class="ml-8 mt-2 space-y-1">
                    <li>
                        <a href="{{ route('laporan.neraca') }}" @class([
                            'block px-2 py-1 rounded-md text-sm',
                            'text-teal-400 bg-gray-100' => request()->routeIs('laporan.neraca'),
                            'text-gray-700 hover:text-teal-500 dark:text-gray-300 dark:hover:text-white' => !request()->routeIs('laporan.neraca')
                        ])>Laporan Neraca</a>
                    </li>
                    <li>
                        <a href="{{ route('laporan.arus_kas') }}" @class([
                            'block px-2 py-1 rounded-md text-sm',
                            'text-teal-400 bg-gray-100' => request()->routeIs('laporan.arus_kas'),
                            'text-gray-700 hover:text-teal-500 dark:text-gray-300 dark:hover:text-white' => !request()->routeIs('laporan.arus_kas')
                        ])>Laporan Arus Kas</a>
                    </li>
                    <li>
                        <a href="{{ route('laporan.shu') }}" @class([
                            'block px-2 py-1 rounded-md text-sm',
                            'text-teal-400 bg-gray-100' => request()->routeIs('laporan.shu'),
                            'text-gray-700 hover:text-teal-500 dark:text-gray-300 dark:hover:text-white' => !request()->routeIs('laporan.shu')
                        ])>Laporan SHU</a>
                    </li>
                </ul>
            </li>

            @elseif (auth()->check() && auth()->user()->role === 'anggota')
            <li>
                <p class="uppercase text-xs text-gray-400 mb-4 tracking-wider">Homes</p>
                <a href="{{ route('anggota.anggota') }}" @class([
                    'flex items-center p-2 rounded-lg transition ease-in-out duration-500 group',
                    'text-gray-900 hover:text-teal-400 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700',
                    'text-teal-400 bg-gray-100' => request()->routeIs('anggota.anggota'),
                ])>
                    <i @class([
                        'fas fa-chart-pie mr-3 transition duration-500',
                        'text-gray-500 dark:text-gray-400 group-hover:text-teal-400 dark:group-hover:text-white',
                        'text-teal-400' => request()->routeIs('anggota.anggota'),
                    ])></i>
                    <span class="ms-3">Dashboard</span>
                </a>
            </li>

            <li>
                <p class="uppercase text-xs text-gray-400 mb-4 tracking-wider">Pinjaman</p>

                <a href="{{ route('pinjaman_anggota.index') }}" @class([
                    'flex items-center p-2 rounded-lg transition ease-in-out duration-500 group',
                    'text-gray-900 hover:text-teal-400 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700',
                    'text-teal-400 bg-gray-100' => request()->routeIs('pinjaman_anggota.index'),
                ])>
                    <i @class([
                        'fad fa-money-bill-wave mr-3 transition duration-500',
                        'text-gray-500 dark:text-gray-400 group-hover:text-teal-400 dark:group-hover:text-white',
                        'text-teal-400' => request()->routeIs('pinjaman_anggota.index'),
                    ])></i>
                    <span class="ms-3">Ajukan Pinjaman</span>
                </a>

                <a href="{{ route('cicilan_anggota.index') }}" @class([
                    'flex items-center p-2 rounded-lg transition ease-in-out duration-500 group',
                    'text-gray-900 hover:text-teal-400 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700',
                    'text-teal-400 bg-gray-100' => request()->routeIs('cicilan_anggota.index'),
                ])>
                    <i @class([
                        'fad fa-money-bill-wave mr-3 transition duration-500',
                        'text-gray-500 dark:text-gray-400 group-hover:text-teal-400 dark:group-hover:text-white',
                        'text-teal-400' => request()->routeIs('cicilan_anggota.index'),
                    ])></i>
                    <span class="ms-3">Cicilan Pinjaman</span>
                </a>
            </li>

            <li>
                <p class="uppercase text-xs text-gray-400 mb-4 tracking-wider">Tabungan Saya</p>

                <a href="{{ route('tab_wajib_anggota.index') }}" @class([
                    'flex items-center p-2 rounded-lg transition ease-in-out duration-500 group',
                    'text-gray-900 hover:text-teal-400 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700',
                    'text-teal-400 bg-gray-100' => request()->routeIs('tab_wajib_anggota.index'),
                ])>
                    <i @class([
                        'fad fa-money-bill-wave mr-3 transition duration-500',
                        'text-gray-500 dark:text-gray-400 group-hover:text-teal-400 dark:group-hover:text-white',
                        'text-teal-400' => request()->routeIs('tab_wajib_anggota.index'),
                    ])></i>
                    <span class="ms-3">Tabungan Wajib</span>
                </a>

                <a href="{{ route('tab_manasuka_anggota.index') }}" @class([
                    'flex items-center p-2 rounded-lg transition ease-in-out duration-500 group',
                    'text-gray-900 hover:text-teal-400 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700',
                    'text-teal-400 bg-gray-100' => request()->routeIs('tab_manasuka_anggota.index'),
                ])>
                    <i @class([
                        'fad fa-money-bill-wave mr-3 transition duration-500',
                        'text-gray-500 dark:text-gray-400 group-hover:text-teal-400 dark:group-hover:text-white',
                        'text-teal-400' => request()->routeIs('tab_manasuka_anggota.index'),
                    ])></i>
                    <span class="ms-3">Tabungan Manasuka</span>
                </a>
            </li>
            @endif

        </ul>
    </div>
</aside>
