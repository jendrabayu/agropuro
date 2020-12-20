@extends('layouts.dashboard-skeleton')

@section('app')
  <div class="main-wrapper">
    <div class="navbar-bg"></div>
    <nav class="navbar navbar-expand-lg main-navbar">
      @include('includes.dashboard.topnav')
    </nav>

    <div class="main-sidebar">
      @if (auth()->user()->role === 1)
        @include('includes.dashboard.sidebar.admin')
      @elseif(auth()->user()->role === 2)
        @include('includes.dashboard.sidebar.user')
      @endif
    </div>

    <div class="main-content">
      <section class="section">
        @yield('content')
      </section>
    </div>

    <footer class="main-footer">
      @include('includes.dashboard.footer')
    </footer>
    @yield('modal')
  </div>
@endsection

@push('js')
  <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
@endpush
