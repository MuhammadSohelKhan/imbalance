<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} | @yield('title')</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon"/>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon"/>

    <!-- CSS files -->
    <link href="{{ asset('dist/css/tabler.min.css') }}" rel="stylesheet"/>

    @section('links')
    @show

</head>
<body class="antialiased border-top-wide border-primary d-flex flex-column">

    @section('content')
    @show

    <script>
        document.body.style.display = "block"
    </script>
</body>
</html>
