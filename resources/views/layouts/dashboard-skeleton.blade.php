<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  {{-- <title>@yield('title', 'Home') &mdash; {{ config('app.name', 'Agropuro') }}</title>
  --}}
  <title>@yield('title', 'Home') &mdash; Agropuro </title>
  @stack('css')
  <link rel="stylesheet" href="{{ asset('assets/stisla/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/stisla/css/components.css') }}">
</head>

<body>
  <div id="app">
    @yield('app')
  </div>

  <script src="{{ asset('assets/stisla/js/app.js') }}"></script>
  @stack('js')
</body>

</html>
