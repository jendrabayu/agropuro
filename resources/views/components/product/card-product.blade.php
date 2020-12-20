  <div class="product__item">
    <div class="product__item__pic set-bg" data-setbg="{{ Storage::url($product->gambar) }}">
      <ul class="product__item__pic__hover">
        <li><a href="#"><i class="fa fa-retweet"></i></a></li>
        <li><a href="{{ route('product.show', [$product->id, $product->slug]) }}"><i class="fa fa-search-plus"></i></a>
        </li>
      </ul>
    </div>
    <div class="product__item__text">
      <h6 class="mb-0"><a href="{{ route('product.show', [$product->id, $product->slug]) }}">{{ $product->nama }}</a>
      </h6>
      <p class="mb-0 text-secondary">Terjual {{ $product->sales() }}</p>
      <h5>{{ rupiah_format($product->harga) }}</h5>
    </div>
  </div>
