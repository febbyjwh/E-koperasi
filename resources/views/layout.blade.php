<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="./img/fav.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Ubuntu&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/assets/fontawesome/all.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    {{-- <link rel="stylesheet" href="./assets/vendor/apexcharts/dist/apexcharts.css"> --}}
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}"> --}}
    <title>@yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

    @php
        $anggota = auth()->user()->role == 'anggota';
        $admin = auth()->user()->role == 'admin';
    @endphp

    <!-- start navbar -->
    <div @class(['hidden', 'md:block', 'sm:block'])>
        @include('components.navbar')
    </div>
    <!-- end navbar -->

    @if (in_array(auth()->user()->role, ['admin', 'anggota']))
    @include('components.sidebar')
    @endif

    <style>
    @media print {
        body * {
        visibility: hidden;
        }
        #laporan-neraca, #laporan-neraca * {
        visibility: visible;
        }
        #laporan-neraca {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;    
        }
    }
    </style>

    <!-- strat wrapper -->
    <div @class([
        'p-4' => $admin || $anggota,
        'sm:ml-64' => $admin || $anggota,
    ])>
        <div @class([
            'p-4' => $admin,
            'mt-14' => $admin,
            'sm:mt-16' => $anggota,
        ])">
            @yield('content')

            @if ($anggota)
            <div @class(['block', 'md:hidden', 'sm:hidden'])>
                @include('components.bottombar')
            </div>
            @endif
        </div>
    </div>
    <!-- end wrapper -->

    <!-- script -->
    <script src="/assets/fontawesome/pro.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.3.0/dist/flowbite.min.js"></script>
    <script src="/assets/fontawesome/pro.min.js"></script>
    <script src="https://unpkg.com/preline@latest/dist/preline.js"></script>
    {{-- <script src="/node_modules/apexcharts/dist/apexcharts.min.js"></script> --}}
    <script src="https://unpkg.com/alpinejs" defer></script>

    {{-- <script src="./assets/vendor/lodash/lodash.min.js"></script>
    <script src="./assets/vendor/apexcharts/dist/apexcharts.min.js"></script>
    <script src="./assets/vendor/preline/dist/helper-apexcharts.js"></script> --}}
    <!-- end script -->
</body>

</html>
