<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="UTF-8">
  <meta name="description" content="Ogani Template">
  <meta name="keywords" content="Ogani, unica, creative, html">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Agropuro &mdash; @yield('title')</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">

  <!-- Css Styles -->
  @include('includes.front.style')
  <!-- change sass to css in the end  -->

  @stack('css')
</head>

<body>
  <!-- Page Preloader -->
  <div id="preloader">
    <div class="loader"></div>
  </div>
  <!-- Page Preloader END -->

  <!-- Hamburger (only visible on tablets and mobiles) -->
  @include('includes.front.hamburger')
  <!-- Hamburger END -->

  <!-- Header Section (on tablets and mobiles it's hidden) -->
  @include('includes.front.header')
  <!-- Header Section END -->

  <!-- Hero Section -->
  @include('includes.front.hero')
  <!-- Hero Section END -->

  @yield('content')

  <!-- Footer Section -->
  @include('includes.front.footer')
  <!-- Footer Section END -->

  <!-- JS Plugins -->
  @include('includes.front.script')

  @stack('js')
</body>

</html>
