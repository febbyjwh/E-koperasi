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


    <!-- strat wrapper -->
    <div class="flex flex-col min-h-screen">
        <div class="flex-1 flex items-center justify-center flex-col">
            @yield('content')
        </div>
    </div>
    <!-- end wrapper -->

    <!-- script -->
    <script src="/assets/fontawesome/pro.min.js"></script>
    <!-- end script -->
</body>

</html>
