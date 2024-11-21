<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Nuansa Baca</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/logo/logoNuansa1.ico')}}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @include('user.css')
    @stack('css')
</head>

<body>
    <button type="button" class="btn btn-success btn-floating btn-lg" id="btn-back-to-top">
        <i class="fa fa-arrow-up" aria-hidden="true"></i>
    </button>
    <div>
        @include('user.header')
        <div>
            @yield('content')

        </div>
    </div>
  
    @include('user.js')

    @stack('scripts')
</body>

</html>
