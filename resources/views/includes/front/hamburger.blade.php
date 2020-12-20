  <div class="hamburger__menu__overlay"></div>
  <div class="hamburger__menu__wrapper">
    <div class="hamburger__menu__logo">
      <a href="{{ route('home') }}"><img src="{{ asset('assets/logo.png') }}" alt=""></a>
    </div>
    <div class="hamburger__menu__cart">
      <ul>
        <li><a href="{{ route('cart.index') }}"><i class="fa fa-shopping-bag"></i>
            <span>{{ total_product_in_cart() }}</span></a></li>
      </ul>
      <div class="header__cart__price"><span>{{ total_price_in_cart() }}</span></div>
    </div>
    <div class="hamburger__menu__widget">
      <div class="header__top__right__auth">
        @if (auth()->check())
          <a href="{{ route('customer.order.index') }}"><i class="fa fa-user"></i>
            {{ set_name_of_user(auth()->user()->name) }}</a>
        @else
          <a href="{{ route('login') }}"><i class="fa fa-user"></i> Login</a>
        @endif
      </div>
    </div>
    <nav class="hamburger__menu__nav mobile-menu">
      <ul>
        <li class="{{ set_active('/') }}"><a href="{{ route('home') }}">Home</a></li>
        <li class="{{ set_active('product') }}"><a href="{{ route('product.index') }}">Produk</a></li>
        <li><a target="_blank" href="{{ route('customer.order.index') }}">Pesanan Saya</a></li>
        <li><a href="#">Menu</a>
          <ul class="header__menu__dropdown">
            <li><a target="_blank" href="{{ route('forum.index') }}">Forum</a></li>
            <li><a target="_blank" href="{{ route('plantingschedule.index') }}">Penjadwalan Tanam</a>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
    <div id="mobile-menu-wrap"></div>
    <div class="hamburger__menu__contact">
      <ul>
        <li><i class="fa fa-envelope"></i> agropuro@mail.com</li>
        <li>Pengiriman Seluruh Indonesia</li>
      </ul>
    </div>
  </div>
