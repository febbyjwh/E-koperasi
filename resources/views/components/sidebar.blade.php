<div id="sideBar"
    class="relative flex flex-col flex-wrap bg-white border-r border-gray-300 p-6 flex-none w-64 md:-ml-64 md:fixed md:top-0 md:z-30 md:h-screen md:shadow-xl animated faster">


    <!-- sidebar content -->
    <div class="flex flex-col">

        <!-- sidebar toggle -->
        <div class="text-right hidden md:block mb-4">
            <button id="sideBarHideBtn">
                <i class="fad fa-times-circle"></i>
            </button>
        </div>
        <!-- end sidebar toggle -->

        <p class="uppercase text-xs text-gray-600 mb-4 tracking-wider">homes</p>

        <!-- link -->
        <a href="/"
            class="mb-3 font-medium text-sm {{ request()->routeIs('dashboard') ? 'text-teal-500' : '' }} hover:text-teal-600  
            ">
            <i class="fad fa-chart-pie text-xs mr-2"></i>
            Dashboard
        </a>
        <!-- end link -->

        <p class="uppercase text-xs text-gray-600 mb-4 mt-4 tracking-wider">kelola keuangan</p>

        <!-- link -->
        <a href="/admin"
            class="mb-3 font-medium text-sm {{ request()->routeIs('admin') ? 'text-teal-500' : '' }} hover:text-teal-600 transition ease-in-out duration-500">
            <i class="fad fa-money-bill-wave text-xs mr-2"></i>
            Modal Utama
        </a>
        <!-- end link -->

        <p class="uppercase text-xs text-gray-600 mb-4 mt-4 tracking-wider">kelola anggota</p>

        <!-- link -->
        <a href="/anggota"
            class="mb-3 font-medium text-sm {{ request()->routeIs('anggota') ? 'text-teal:500' : ''}} hover:text-teal-600 transition ease-in-out duration-500">
            <i class="fad fa-users text-xs mr-2"></i>
            Anggota
        </a>
        <!-- end link -->
    </div>
    <!-- end sidebar content -->

</div>
