@extends('layouts.front')
@section('title', 'Produk')
@section('hero_class', 'hero-normal')

@section('content')
  <!-- Breadcrumb Section -->
  @include('includes.front.breadcrumb', ['breadcrumbs' => [
  'Home' => route('home'),
  'Produk' =>'#'
  ]])
  <!-- Breadcrumb Section END -->
  <!-- Product Section -->
  <section class="product">
    <div class="container">
      <div class="row">
        <div class="col-lg-3 col-md-5">
          <div class="sidebar">
            <div class="sidebar__item">
              <h4>Kategori</h4>
              <ul>
                <li><a href="{{ route('product.index') }}">Semua Produk</a></li>
                @foreach ($categories as $category)
                  <li>
                    <a href="{{ route('product.index', ['category' => $category->slug]) }}">{{ $category->name }}</a>
                  </li>
                @endforeach
              </ul>
            </div>
            <div class="sidebar__item">
              <div class="latest-product__text mb-5">
                <h4>Produk Terbaru</h4>
                <div class="latest-product__slider owl-carousel">
                  <x-product.side-product-slider :products="$latestProduct"></x-product.side-product-slider>
                </div>
              </div>
              <div class="latest-product__text">
                <h4>Produk Terlaris</h4>
                <div class="latest-product__slider owl-carousel">
                  <x-product.side-product-slider :products="$salesProduct"></x-product.side-product-slider>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-9 col-md-7">
          <div class="section-title">
            <h2>{{ $titleName }}</h2>
          </div>
          <div class="filter__item">
            <div class="row">
              <div class="col-lg-4 col-md-5">
                <div class="filter__sort">
                  <div class="dropdown">
                    <a class="dropdown-toggle sort__link" href="#" role="button" id="dropdownMenuLink"
                      data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Urutkan Harga
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                      <a class="dropdown-item"
                        href="{{ route('product.index', array_merge(request()->only('search', 'category', 'page'), ['price' => 'low-high'])) }}">Harga:
                        Rendah ke Tinggi</a>
                      <a class="dropdown-item"
                        href="{{ route('product.index', array_merge(request()->only('search', 'category', 'page'), ['price' => 'high-low'])) }}">Harga:
                        Tinggi ke Rendah</a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-md-4">
                <div class="filter__found">
                  <h6><span>{{ $products->total() }}</span> Produk ditemukan</h6>
                </div>
              </div>
              <div class="col-lg-4 col-md-3">
                <div class="filter__option">
                  <a class="mx-1 sort__link"
                    href="{{ route('product.index', array_merge(request()->only('search', 'category', 'page'), ['sort' => 'time'])) }}">Terbaru</a>
                  <a class="mx-1 sort__link"
                    href="{{ route('product.index', array_merge(request()->only('search', 'category', 'page'), ['sort' => 'sales'])) }}">Terlaris</a>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            @foreach ($products as $product)
              <div class="col-lg-4 col-md-6 col-sm-6">
                <!-- Use Blade Component -->
                <x-product.card-product :product="$product"></x-product.card-product>
              </div>
            @endforeach
          </div>
          {{ $products->appends(request()->input())->links('front.pagination') }}
        </div>
      </div>
    </div>
  </section>
  <!-- Product Section End -->
@endsection

@push('css')
  <style>
    .sort__link,
    .sort__link:active,
    .sort__link:visited,
    .sort__link:link,
    .sort__link:hover {
      color: black
    }

  </style>
@endpush
