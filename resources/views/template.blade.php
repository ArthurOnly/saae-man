<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
   <meta charset="UTF-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css"> 
   <link href="{{ asset('css/app.css') }}" rel="stylesheet">
   <title>{{ config('app.name', 'Laravel') }}</title>

    <title>APP</title>
</head>

<body class="bg-gray-800 text-white">
    <x-site.nav/>
    @yield('body')
    @yield('js')

     <script src="http://cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script>
    <script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
    {!! Toastr::message() !!}
</body>
</html>
