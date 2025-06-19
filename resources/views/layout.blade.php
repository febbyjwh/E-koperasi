<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="./img/fav.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Ubuntu&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/assets/fontawesome/all.min.css">
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

    @if ($admin)
        @include('components.sidebar')
    @endif

    <!-- strat wrapper -->
    <div @class([
        'p-4' => $admin,
        'sm:ml-64' => $admin,
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
    <!-- end script -->
</body>

</html>
