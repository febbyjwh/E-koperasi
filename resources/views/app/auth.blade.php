<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="./img/fav.png" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="/assets/fontawesome/all.min.css">
    <title>@yield('title')</title>
    @vite('resources/css/app.css', 'resources/js/app.js')
</head>

<body class="bg-gray-100">
    
    <!-- strat wrapper -->
    <div class="h-screen flex flex-row flex-wrap">
        <!-- strat content -->
        @yield('content')
        <!-- end content -->
    </div>
    <!-- end wrapper -->

    <!-- script -->
    <script src="/assets/fontawesome/pro.min.js"></script>
    <!-- end script -->

</body>

</html>