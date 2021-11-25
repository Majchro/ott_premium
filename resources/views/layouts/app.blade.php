<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr" class="w-full h-full">
  <head>
    <meta charset="utf-8">
    <title>Old Time Turtle Premium</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  </head>
  <body class="w-full h-full">
    @yield('content')
  </body>
</html>
