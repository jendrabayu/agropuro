<aside id="sidebar-wrapper">
  <div class="sidebar-brand">
    <a href="{{ route('customer.order.index') }}">Agropuro</a>
  </div>
  <div class="sidebar-brand sidebar-brand-sm">
    <a href="{{ route('customer.order.index') }}">AP</a>
  </div>
  <ul class="sidebar-menu">
    <li class="menu-header">Customer</li>
    <li class="{{ set_active('customer/order') }}"><a class="nav-link" href="{{ route('customer.order.index') }}"><i
          class="fas fa-box"></i>
        <span>Pesanan Saya</span></a></li>

    <li class="{{ set_active('accountsetting') }}"><a class="nav-link" href="{{ route('accountsetting.index') }}"><i
          class="fas fa-user-cog"></i>
        <span>Pengaturan Akun</span></a></li>

    <li class="{{ set_active('customer/address') }}"><a class="nav-link" href="{{ route('customer.address.index') }}"><i
          class="fas fa-map-marked-alt"></i>
        <span>Alamat</span></a></li>

    <li class="menu-header">Fitur</li>
    <li><a class="nav-link" href="{{ route('forum.index') }}"><i class="fas fa-comments"></i>
        <span>Forum</span></a></li>
    <li><a class="nav-link" href="{{ route('plantingschedule.index') }}"><i class="fas fa-leaf"></i>
        <span>Penjadwalan Tanam</span></a></li>

    <li class="menu-header">Belanja</li>
    <li><a class="nav-link" href="{{ route('product.index') }}"><i class="fas fa-shopping-bag"></i>
        <span>Produk</span></a></li>
    <li><a class="nav-link" href="{{ route('cart.index') }}"><i class="fas fa-shopping-cart"></i>
        <span>Keranjang</span></a></li>
  </ul>

  <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
    <a href="{{ route('home') }}" class="btn btn-primary btn-lg btn-block btn-icon-split">
      <i class="fas fa-rocket"></i> Halaman Depan
    </a>
  </div>
</aside>
