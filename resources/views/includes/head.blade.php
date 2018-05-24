<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link href="{{ asset('fonts/font-awesome/css/font-awesome.min.css') }}" rel='stylesheet' type='text/css'>
    <link href="http://allfont.net/allfont.css?fonts=montserrat-light" rel="stylesheet" type="text/css" />

    <!-- Styles -->
    <link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sweetalert.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/skins/square/_all.css') }}" rel="stylesheet" type="text/css">
    @yield('styles')

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/icheck.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/circle-progress.min.js') }}" type="text/javascript"></script>

    @yield('scripts')
</head>