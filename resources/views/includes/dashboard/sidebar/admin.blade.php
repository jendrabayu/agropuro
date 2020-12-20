<aside id="sidebar-wrapper">
  <div class="sidebar-brand">
    <a href="{{ route('admin.dashboard') }}">Agropuro</a>
  </div>
  <div class="sidebar-brand sidebar-brand-sm">
    <a href="{{ route('admin.dashboard') }}">AP</a>
  </div>
  <ul class="sidebar-menu">
    <li class="menu-header">Admin</li>
    <li class="{{ set_active('admin') }}"><a class="nav-link" href="{{ route('admin.dashboard') }}"><i
          class="fas fa-tachometer-alt"></i>
        <span>Dashboard</span></a></li>
    <li class="{{ set_active('profile-setting') }}"><a target="_blank" class="nav-link"
        href="{{ route('profile-setting.index') }}"><i class="fas fa-user-cog"></i>
        <span>Pengaturan Akun</span></a></li>
    <li class="{{ set_active('admin/customer') }}"><a class="nav-link" href="{{ route('admin.customer') }}"><i
          class="fas fa-users"></i>
        <span>Pelanggan</span></a></li>


    <li class="menu-header">Forum</li>

    <li><a class="nav-link" target="_blank" href="{{ route('forum.index') }}"><i class="fas fa-comments"></i>
        <span>Forum</span></a></li>

    <li class="{{ set_active('admin/forum-category') }}"><a class="nav-link"
        href="{{ route('admin.forum-category.index') }}"><i class="fas fa-box"></i>
        <span>Kategori</span></a></li>

    <li class="menu-header">Penjdwalan</li>
    <li><a class="nav-link" target="_blank" href="{{ route('planting-schedule.index') }}"><i class="fas fa-leaf"></i>
        <span>Penjadwalan Tanam</span></a></li>


    <li class="menu-header">Toko Online</li>
    <li class="dropdown {{ set_active('admin/product') }} {{ request()->is('admin/product/*') ? 'active' : '' }}">
      <a href="#" class="nav-link has-dropdown"><i class="fas fa-boxes"></i><span>Produk</span></a>
      <ul class="dropdown-menu">
        <li class="{{ set_active('admin/product') }}"><a class="nav-link"
            href="{{ route('admin.product.index') }}">Daftar
            Produk
          </a></li>
        <li class="{{ set_active('admin/product/create') }}"><a class="nav-link"
            href="{{ route('admin.product.create') }}">Tambah
            Produk Baru</a></li>
      </ul>
    </li>
    <li class="{{ set_active('admin/order') }} {{ request()->is('admin/order/*') ? 'active' : '' }}"><a class="nav-link"
        href="{{ route('admin.order.index') }}"><i class="fas fa-box"></i>
        <span>Pesanan Saya</span></a></li>

    <li class="{{ set_active('admin/category') }}"><a class="nav-link" href="{{ route('admin.category.index') }}"><i
          class="fas fa-th-large"></i>
        <span>Kategori</span></a></li>

    <li class="{{ set_active('admin/shop-address') }}"><a class="nav-link" href="{{ route('admin.shop-address') }}"><i
          class="fas fa-map-marked-alt"></i>
        <span>Alamat Toko</span></a></li>

    <li class="{{ set_active('admin/bank-account') }}"><a class="nav-link"
        href="{{ route('admin.bank-account.index') }}"><i class="fas fa-money-check-alt"></i>
        <span>Rekening</span></a></li>

    <li class="{{ set_active('admin/recap') }}"><a class="nav-link" href="{{ route('admin.recap') }}"><i
          class="fas fa-list-alt"></i>
        <span>Rekap Penjualan</span></a></li>
  </ul>

  <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
    <a href="{{ route('home') }}" class="btn btn-primary btn-lg btn-block btn-icon-split">
      <i class="fas fa-rocket"></i> Halaman Depan
    </a>
  </div>


</aside>
