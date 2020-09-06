<!doctype html>

<?php if (Session::has("user_current_establishment")) {
    Session::get("user_current_establishment")->refresh();
} ?>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Tapaspay') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
          integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ mix('/css/styles.css') }}">

    <!-- Custom head tags -->
    @yield('styles')
</head>
<body>

    <main class="container-fluid">
        @yield('content')
    </main>

    <div id="loader"><div>

    <!-- Scripts -->
    <script defer src="https://use.fontawesome.com/f0b4744be7.js"></script>

    <script defer src=" {{ asset('js/manifest.js') }} "></script>
    <script defer src=" {{ asset('js/vendor.js') }} "></script>
    <script defer src=" {{ asset('js/app.js') }} "></script>
    @yield("scripts")

</body>
</html>
