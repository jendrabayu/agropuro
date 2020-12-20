<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Home') &mdash; Agropuro </title>
  @stack('css')
  <link rel="stylesheet" href="{{ asset('assets/stisla/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/stisla/css/components.css') }}">
</head>

<body class="layout-3">
  <div id="app">
    <div class="main-wrapper container">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <div class="container">
          <a href="{{ route('home') }}" class="navbar-brand sidebar-gone-hide">Agropuro</a>
          <a href="#" class="nav-link sidebar-gone-show" data-toggle="sidebar"><i class="fas fa-bars"></i></a>
          <ul class="navbar-nav navbar-right">
            @if (auth()->check())
              <li class="dropdown"><a href="#" data-toggle="dropdown"
                  class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                  <img alt="image" src="{{ asset('storage/' . auth()->user()->photo) }}" class="rounded-circle mr-1">
                  <div class="d-sm-none d-lg-inline-block">{{ set_name_of_user(auth()->user()->name) }}</div>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                  <a href="{{ route('accountsetting.index') }}" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> Profile
                  </a>
                  <div class="dropdown-divider"></div>
                  <a href="#" class="dropdown-item has-icon text-danger" id="btnLogout">
                    <i class="fas fa-sign-out-alt"></i> Logout
                  </a>
                  <form id="logoutForm" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                  </form>
                  <script>
                    document.getElementById('btnLogout').addEventListener('click', e => {
                      e.preventDefault()
                      document.getElementById('logoutForm').submit()
                    });

                  </script>
                </div>
              </li>
            @else
              <li class="nav-item">
                <a class="btn btn-icon icon-left btn-light" href="{{ route('login') }}">
                  <i class="fas fa-sign-in-alt"></i>
                  Login
                </a>
              </li>
            @endif
          </ul>
        </div>
      </nav>

      <nav class="navbar navbar-secondary navbar-expand-lg">
        <div class="container">
          <ul class="navbar-nav">
            <li class="nav-item {{ set_active('forum') }} {{ request()->is('forum/*') ? 'active' : '' }}">
              <a href="{{ route('forum.index') }}" class="nav-link"><span>Forum</span></a>
            </li>
            <li
              class="nav-item {{ set_active('plantingschedule') }} {{ request()->is('plantingschedule/*') ? 'active' : '' }}">
              <a href="{{ route('plantingschedule.index') }}" class="nav-link"><span>Penjadwalan Tanam</span></a>
            </li>
            <li class="nav-item">
              <a href="{{ route('product.index') }}" class="nav-link"><span>Belanja</span></a>
            </li>
            <li class="nav-item">
              <a href="{{ route('home') }}" class="nav-link"><span>Halaman Depan</span></a>
            </li>
            <li class="nav-item">
              @if (auth()->check() && auth()->user()->role === \App\USER::ROLE_ADMIN)
                <a href="{{ route('admin.dashboard') }}" class="nav-link"><span>Dashboard</span></a>
              @endif
            </li>
          </ul>
        </div>
      </nav>

      <div class="main-content">
        <section class="section">
          <section class="section-header">
            @yield('section_header')
          </section>

          <section class="section-body">
            @yield('app')
          </section>
        </section>
      </div>
      <footer class="main-footer">
        @include('includes.dashboard.footer')
      </footer>
      @yield('modal')
    </div>
  </div>

  <script src="{{ asset('assets/stisla/js/app.js') }}"></script>
  @stack('js')
</body>

</html>
