@extends('layouts.front')
@section('title', $product->nama)
@section('hero_class', 'hero-normal')
@section('content')
  <!-- Breadcrumb Section -->
  @include('includes.front.breadcrumb', ['breadcrumbs' => [
  'Home' => route('home'),
  'Produk' => route('product.index'),
  $product->category->name => route('product.index', ['category' => $product->category->slug]),
  $product->nama => '#'
  ]])
  <!-- Breadcrumb Section END -->

  <!-- Product Details Section Begin -->
  <section class="product-details spad">
    <div class="container">
      <!-- Alert Blade Component -->
      @include('includes.bs-alert')
      @include('includes.error-alert')
      <!-- End Alert Blade Component -->
      <div class="row">
        <div class="col-lg-6 col-md-6">
          <div class="product__details__pic">
            <div class="product__details__pic__item">
              <img class="product__details__pic__item--large w-100" src="{{ asset('storage/' . $product->gambar) }}"
                alt="">
            </div>
            <div class="product__details__pic__slider owl-carousel">
              <img data-imgbigurl="{{ asset('storage/' . $product->gambar) }}"
                src="{{ asset('storage/' . $product->gambar) }}" alt="">
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-6">
          <div class="product__details__text">
            <h3>{{ $product->nama }}</h3>
            <div class="product__details__price">{{ rupiah_format($product->harga) }}</div>
            <p>{{ $product->deskripsi_singkat }}</p>
            <form action="{{ route('cart.store', $product->id) }}" class="d-inline" method="POST">
              @csrf
              <div class="product__details__quantity">
                <div class="quantity">
                  <div class="pro-qty">
                    <input type="number" value="1" min="1" max="{{ $product->stok }}" name="quantity">
                  </div>
                </div>
              </div>
              <button type="submit" class="primary-btn">Masukkan Keranjang</button>
            </form>

            <ul>
              <li><b>Stok</b> <span>{{ $product->stok }}</span></li>
              <li><b>Pengiriman</b> <span>
                  @foreach ($couriers as $index => $courier)
                    @if ($index != count($couriers) - 1)
                      {{ $courier->name }},
                    @else
                      {{ $courier->name }}
                    @endif
                  @endforeach
                </span></li>
              <li><b>Berat</b> <span>{{ $product->berat }} gram / {{ $product->berat / 1000 }} kg</span></li>
              <li><b>Terjual</b> <span>{{ $product->sales() }}</span></li>
            </ul>
          </div>
        </div>
        <div class="col-lg-12">
          <div class="product__details__tab">
            <!-- Bootstrap Dynamic Tabs -->
            <ul class="nav nav-tabs" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab" aria-selected="true">Deskripsi</a>
              </li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tabs-1" role="tabpanel">
                <div class="product__details__tab__desc">
                  <h6>Informasi Produk</h6>
                  <div>
                    {!! $product->deskripsi !!}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Product Details Section END -->

  <!-- Related Product Section -->
  <section class="related-product">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="section-title related__product__title">
            <h2>Produk Terkait</h2>
          </div>
        </div>
      </div>
      <div class="row">
        @foreach ($relatedProducts as $product)
          <div class="col-lg-3 col-md-4 col-sm-6">
            <x-product.card-product :product="$product"></x-product.card-product>
          </div>
        @endforeach
      </div>
    </div>
  </section>
  <!-- Related Product Section END -->
@endsection
