<form class="form-inline mr-auto">
  <ul class="navbar-nav mr-3">
    <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
    <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
  </ul>
</form>
<ul class="navbar-nav navbar-right">
  <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
      <img alt="image" src="{{ asset('storage/' . auth()->user()->photo) }}" class="rounded-circle mr-1">
      <div class="d-sm-none d-lg-inline-block">{{ set_name_of_user(auth()->user()->name) }}</div>
    </a>
    <div class="dropdown-menu dropdown-menu-right">
      <a href="{{ route('profile-setting.index') }}" class="dropdown-item has-icon">
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
</ul>
