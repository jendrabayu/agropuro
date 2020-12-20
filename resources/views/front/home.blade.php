@extends('layouts.front')
@section('title', 'Home')

@section('hero_item')
  <div class="hero__item set-bg" data-setbg="{{ asset('assets/front-bg.jpg') }}">
    <div class="hero__text">
      <span>Tersedia Berbagai Pupuk</span>
      <h2>Organik & Kimia</h2>
      <p class="text-light">Original & Berkualitas</p>
      <a href="#" class="primary-btn">Beli Sekarang</a>
    </div>
  </div>
@endsection

@section('content')
  <!-- Categories Section -->
  <section class="categories">
    <div class="container">
      <div class="row">
        <div class="categories__slider owl-carousel">
          <!-- 4x3 -->
          @foreach ($categories as $category)
            <div class="col-lg-3">
              <div class="categories__item set-bg" data-setbg="{{ asset('storage/' . $category->image) }}">
                <h5><a href="{{ route('product.index', ['category' => $category->slug]) }}">{{ $category->name }}</a></h5>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </section>
  <!-- Categories Section END -->

  <section class="featured  mt-5">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="section-title">
            <h2>Produk Unggulan</h2>
          </div>
          <div class="featured__controls">
            <ul>
              <li class="active" data-filter="*">All</li>
              @foreach ($categories as $category)
                <li data-filter=".{{ $category->slug }}">{{ $category->name }}</li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
      <div class="row featured__filter">
        <!-- 8 items/products -->
        @foreach ($featuredProduct as $product)
          <div class="col-lg-3 col-md-4 col-sm-6 mix {{ $product->category->slug }}">
            <div class="featured__item">
              <div class="featured__item__pic set-bg" data-setbg="{{ Storage::url($product->gambar) }}">
                <ul class="featured__item__pic__hover">
                  <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                  <li><a href="{{ route('product.show', [$product->id, $product->slug]) }}"><i
                        class="fa fa-search-plus"></i></a></li>
                </ul>
              </div>
              <div class="featured__item__text">
                <h6><a href="{{ route('product.show', [$product->id, $product->slug]) }}">{{ $product->nama }}</a></h6>
                <h5>{{ rupiah_format($product->harga) }}</h5>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </section>
  <!-- Featured Section END -->

  <!-- Banner -->
  <div class="banner">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6">
          <div class="banner__pic">
            <img src="{{ asset('assets/front/img/banner/banner-1.jpg') }}" alt="">
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
          <div class="banner__pic">
            <img src="{{ asset('assets/front/img/banner/banner-2.jpg') }}" alt="">
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Banner END -->

  <!-- Latest/Top Rated/Review Products Section -->
  <section class="latest-product spad mb-5">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 col-md-6">
          <div class="latest-product__text">
            <!-- Latest Products -->
            <h4>Produk Terbaru</h4>
            <div class="latest-product__slider owl-carousel">
              <x-product.side-product-slider :products="$latestProduct"></x-product.side-product-slider>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="latest-product__text">
            <!-- Top Rated Products -->
            <h4>Produk Terlaris</h4>
            <div class="latest-product__slider owl-carousel">
              <x-product.side-product-slider :products="$salesProduct"></x-product.side-product-slider>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Latest/Top Rated/Review Products Section END -->
@endsection
