<section class="hero @yield('hero_class')">
  <div class="container">
    <div class="row">
      <div class="col-lg-3">
        <div class="hero__categories">
          <div class="hero__categories__all">
            <i class="fa fa-bars"></i>
            <span>Semua Kategori</span>
          </div>
          <ul>
            @foreach ($categories as $v)
              <li><a href="{{ route('product.index', ['category' => $v->slug]) }}">{{ $v->name }}</a></li>
            @endforeach
          </ul>
        </div>
      </div>
      <div class="col-lg-9">
        <div class="hero__search">
          <div class="hero__search__form">
            <form action="{{ route('product.index') }}">
              <input type="text" placeholder="Produk apa yang Anda cari?" name="search">
              <button type="submit" class="site-btn">CARI</button>
            </form>
          </div>
          <div class="hero__search__phone">
            <div class="hero__search__phone__icon">
              <i class="fa fa-phone"></i>
            </div>
            <div class="hero__search__phone__text">
              <h5>704-768-7449</h5>
              <span>24/7 Support</span>
            </div>
          </div>
        </div>
        @yield('hero_item')
      </div>
    </div>
  </div>
</section>
