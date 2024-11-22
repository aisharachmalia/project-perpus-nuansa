<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/logo/logoNuansa1.ico')}}">
    <title>Nuansa Baca</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @include('partials.css')
    @stack('css')
</head>

<body>
    <div id="app">
        @include('partials.sidebar')
        @include('partials.header')
        <div id="main">
            @yield('content')
        </div>
        

        @include('partials.footer')
    </div>
    @include('partials.js')
    @stack('scripts')
</body>

</html>
