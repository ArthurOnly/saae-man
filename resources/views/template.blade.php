<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
   <meta charset="UTF-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <title>APP</title>
</head>

<body class="bg-gray-800 text-white">
    <x-site.nav/>
    @yield('body')
    @yield('js')
</body>
</html>
