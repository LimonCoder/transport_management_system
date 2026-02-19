<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Vehicle | @yield('title')</title>
    <meta name="path" content="{{ url('/') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="description" content="Vehicle managment software">
    <meta name="author" content="innovation it">
    <meta name="robots" content="noindex, nofollow">
    <!-- Fonts -->

    <!-- Bootstrap Css -->
    <link href="{{ asset('/assets/css/bootstrap.min.css') }}" id="bootstrap-stylesheet" rel="stylesheet" type="text/css"/>
    <!-- Icons Css -->
    <link href="{{ asset('/assets/css/icons.min.css')  }}" rel="stylesheet" type="text/css"/>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" type="text/css"/>
    <!-- App Css-->
    <link href="{{ asset('/assets/css/app.min.css') }}" id="app-stylesheet" rel="stylesheet" type="text/css"/>

    {{--font.css--}}
    <link href="{{ asset('https://fonts.maateen.me/solaiman-lipi/font.css') }}" rel="stylesheet">

    <style>
        body {
            font-family: 'SolaimanLipi', Roboto, sans-serif !important;
            font-size: 14px;
        }
    </style>

    @stack('styles')
</head>
<body>
<div class="account-pages mt-5 mb-5">
    <!-- start container -->
    @yield('main-content')
    <!-- end container -->
</div>

<!-- Vendor js -->
<script src="{{ asset('/assets/js/vendor.min.js') }}"></script>
<script src="{{ asset('/assets/js/app.min.js') }}"></script>
@stack('scripts')
</body>
</html>
